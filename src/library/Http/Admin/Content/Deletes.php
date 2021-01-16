<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Content;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Content;
use App\Ebcms\Cms\Model\Tag;
use Ebcms\RequestFilter;

class Deletes extends Common
{
    public function post(
        RequestFilter $input,
        Content $contentModel,
        Tag $tagModel
    ) {
        $contentModel->delete([
            'id' => $input->post('ids'),
        ]);
        $tagModel->delete([
            'content_id' => $input->post('ids'),
        ]);
        return $this->success('操作成功！');
    }
}
