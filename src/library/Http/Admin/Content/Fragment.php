<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Content;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Content;
use App\Ebcms\Fragment\Model\Content as ModelContent;
use App\Ebcms\Fragment\Model\Fragment as ModelFragment;
use Ebcms\Router;
use Ebcms\RequestFilter;

class Fragment extends Common
{
    public function post(
        RequestFilter $input,
        Content $contentModel,
        ModelContent $fragmentContentModel,
        ModelFragment $fragmentModel,
        Router $router
    ) {
        $inserts = [];
        foreach ($contentModel->select('*', [
            'id' => $input->post('ids'),
        ]) as $value) {
            $inserts[] = [
                'fragment_id' => $input->post('fragment_id'),
                'title' => $value['title'],
                'redirect_uri' => $router->buildUrl('/ebcms/cms/web/content', ['id' => $value['alias'] ?: $value['id']]),
                'description' => $value['description'],
                'cover' => $value['cover'],
            ];
        }
        $fragmentContentModel->insert($inserts);

        $fragmentModel->deleteFragmentCache($input->post('fragment_id'));

        return $this->success('操作成功！');
    }
}
