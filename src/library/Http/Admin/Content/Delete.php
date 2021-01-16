<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Content;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Content;
use App\Ebcms\Cms\Model\Tag;
use Ebcms\RequestFilter;

class Delete extends Common
{
    public function get(
        RequestFilter $input,
        Content $contentModel,
        Tag $tagModel
    ) {
        $contentModel->delete([
            'id' => $input->get('id'),
        ]);
        $tagModel->delete([
            'content_id' => $input->get('id'),
        ]);
        return $this->success('操作成功！');
    }
}
