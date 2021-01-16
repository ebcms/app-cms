<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Web;

use App\Ebcms\Cms\Model\Content;
use Ebcms\Database\Db;
use Ebcms\Pagination;
use Ebcms\RequestFilter;
use Ebcms\Template;

class Search extends Common
{

    public function get(
        RequestFilter $input,
        Pagination $pagination,
        Content $modelContent,
        Db $db,
        Template $template
    ) {

        $data = [];
        $data['meta'] = [
            'title' => '搜索:' . $input->get('q'),
            'keywords' => $input->get('q'),
            'description' => $input->get('q'),
        ];
        $where = 'WHERE state=1 AND MATCH (title,keywords,description,tags,body) AGAINST (:q IN NATURAL LANGUAGE MODE)';
        $total = $modelContent->count($db->slave()::raw($where, [
            ':q' => $input->get('q'),
        ]));

        $page = $input->get('page', 1, ['intval']) ?: 1;
        $page_num = 30;
        $where .= ' LIMIT ' . ($page - 1) * $page_num . ',' . $page_num;
        $data['contents'] = $modelContent->select('*',  $db->slave()::raw($where, [
            ':q' => $input->get('q'),
        ]));
        $data['total'] = $total;
        $data['pagination'] = $pagination->render($page, $total, $page_num);

        return $this->html($template->renderFromFile('web/search@ebcms/cms', $data));
    }
}
