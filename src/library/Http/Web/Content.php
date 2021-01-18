<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Web;

use App\Ebcms\Cms\Model\Content as ModelContent;
use App\Ebcms\Cms\Model\Category;
use Ebcms\RequestFilter;
use Ebcms\Router;
use Ebcms\Template;

class Content extends Common
{

    public function get(
        ModelContent $modelContent,
        Category $modelCategory,
        RequestFilter $input,
        Router $router,
        Template $template
    ) {
        if (!$content = $modelContent->get('*', [
            'state' => 1,
            'OR' => [
                'id' => $input->get('id'),
                'alias' => $input->get('id'),
            ],
        ])) {
            return $this->notice('页面不存在！', 404);
        }

        if (!$category = $modelCategory->get('*', [
            'state' => 1,
            'id' => $content['category_id'],
        ])) {
            return $this->notice('栏目未公开！', 404);
        }

        $modelContent->update([
            'click[+]' => 1,
        ], [
            'id' => $content['id'],
        ]);

        if ($content['redirect_uri']) {
            return $this->redirect($content['redirect_uri']);
        }

        $content['extra'] = unserialize($content['extra']);

        $data = [];
        $data['category'] = $category;
        $data['content'] = $content;
        $data['meta'] = [
            'title' => $content['title'],
            'keywords' => $content['keywords'],
            'description' => $content['description'] ?: mb_substr(str_replace(["\r", "\n", "\t"], '', trim(strip_tags($content['body']))), 0, 250),
        ];
        $data['position'] = (function () use ($modelCategory, $category, $router, $content) {
            $res = [];
            foreach ($modelCategory->getParentsAndSelf($category['id']) as $value) {
                $res[] = [
                    'title' => $value['title'],
                    'url' => $router->buildUrl('/ebcms/cms/web/category', [
                        'id' => $value['alias'] ?: $value['id'],
                    ]),
                ];
            }
            $res[] = [
                'title' => $content['title'],
            ];
            return $res;
        })();

        return $this->html($template->renderFromFile('web/' . ($content['tpl'] ?: ($category['tpl_content'] ?: 'content')) . '@ebcms/cms', $data));
    }
}
