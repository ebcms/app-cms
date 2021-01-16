<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Content;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Content;
use App\Ebcms\Cms\Model\Category;
use App\Ebcms\Fragment\Model\Fragment;
use Ebcms\App;
use Ebcms\Pagination;
use Ebcms\RequestFilter;
use Ebcms\Template;

class Index extends Common
{

    public function get(
        RequestFilter $input,
        Template $template,
        Category $categoryModel,
        Content $contentModel,
        Fragment $fragmentModel,
        Pagination $pagination
    ) {
        $options = [
            'ORDER' => [
                'id' => 'DESC',
            ],
        ];
        if ($input->get('category_id')) {
            $options['category_id'] = $input->get('category_id');
        }
        if ($input->get('state')) {
            $options['state'] = $input->get('state');
        }
        if (in_array($input->get('top'), ['0', '1'])) {
            $options['top'] = $input->get('top');
        }
        if ($q = $input->get('q')) {
            $options['OR'] = [
                'id' => $q,
                'title[~]' => '%' . $q . '%',
                'body[~]' => '%' . $q . '%',
            ];
        }
        $total = $contentModel->count($options);

        $page = $input->get('page', 1, ['intval']) ?: 1;
        $page_num = min(100, $input->get('page_num', 20, ['intval']) ?: 20);
        $options['LIMIT'] = [($page - 1) * $page_num, $page_num];

        $data = $contentModel->select('*', $options);

        $fragments = [];
        $fragments[App::getInstance()->getRequestPackage()] = [];
        foreach ($fragmentModel->all() as $value) {
            if (!isset($fragments[$value['package_name']])) {
                $fragments[$value['package_name']] = [];
            }
            $fragments[$value['package_name']][] = $value;
        }

        return $this->html($template->renderFromFile('admin/content/index@ebcms/cms', [
            'data' => $data,
            'total' => $total,
            'categorys' => $categoryModel->select('*', [
                'ORDER' => [
                    'priority' => 'DESC',
                    'id' => 'ASC',
                ],
            ]),
            'fragments' => $fragments,
            'pagination' => $pagination->render($page, $total, $page_num),
        ]));
    }
}
