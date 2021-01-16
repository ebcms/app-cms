<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Web;

use App\Ebcms\Cms\Model\Content;
use App\Ebcms\Cms\Model\Category as ModelCategory;
use Ebcms\Pagination;
use Ebcms\RequestFilter;
use Ebcms\Template;

class Category extends Common
{

    public function get(
        ModelCategory $modelCategory,
        Content $modelContent,
        RequestFilter $input,
        Pagination $pagination,
        Template $template
    ) {
        if (!$category = $modelCategory->get('*', [
            'state' => 1,
            'OR' => [
                'id' => $input->get('id'),
                'alias' => $input->get('id'),
            ],
        ])) {
            return $this->notice('栏目未公开！', 404);
        }

        if ($category['redirect_uri']) {
            return $this->redirect($category['redirect_uri']);
        }

        $data = [];
        $data['category'] = $category;
        $data['meta'] = [
            'title' => $category['title'],
            'keywords' => $category['keywords'],
            'description' => $category['description'],
        ];

        switch ($category['type']) {
            case 'channel':
                # code...
                break;
            case 'list':
                $where = [
                    'category_id' => $category['id'],
                    'state' => 1,
                    'ORDER' => [
                        'id' => 'DESC',
                    ],
                ];
                for ($i = 0; $i <= 5; $i++) {
                    if ($input->get('filter' . $i)) {
                        $where['filter' . $i] = $input->get('filter' . $i);
                    }
                }
                $total = $modelContent->count($where);

                $page = $input->get('page', 1, ['intval']) ?: 1;
                $page_num = $category['page_num'];
                $where['LIMIT'] = [($page - 1) * $page_num, $page_num];

                $data['total'] = $total;
                $data['contents'] = $modelContent->select('*', $where);
                $data['pagination'] = $pagination->render($page, $total, $page_num);
                break;
            case 'page':
                # code...
                break;

            default:
                # code...
                break;
        }

        return $this->html($template->renderFromFile('web/' . ($category['tpl_category'] ?: 'category_' . $category['type']) . '@ebcms/cms', $data));
    }
}
