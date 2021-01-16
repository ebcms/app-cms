<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Web;

use App\Ebcms\Cms\Model\Content as ModelContent;
use App\Ebcms\Cms\Model\Category;
use Ebcms\RequestFilter;
use Ebcms\Template;

class Content extends Common
{

    public function get(
        ModelContent $modelContent,
        Category $modelCategory,
        RequestFilter $input,
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

        $content['body'] = unserialize($content['body']);

        $data = [];
        $data['category'] = $category;
        $data['content'] = $content;
        $data['meta'] = [
            'title' => $content['title'],
            'keywords' => $content['keywords'],
            'description' => $content['description'] ?: mb_substr(str_replace(["\r", "\n", "\t"], '', trim(strip_tags($content['body']['body'] ?? ''))), 0, 250),
        ];

        return $this->html($template->renderFromFile('web/' . ($content['tpl'] ?: ($category['tpl_content'] ?: 'content')) . '@ebcms/cms', $data));
    }
}
