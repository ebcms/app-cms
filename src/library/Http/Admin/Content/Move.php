<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Content;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Content;
use Ebcms\RequestFilter;

class Move extends Common
{
    public function post(
        RequestFilter $input,
        Content $contentModel
    ) {
        $contentModel->update([
            'category_id' => $input->post('category_id'),
        ], [
            'id' => $input->post('ids'),
        ]);
        return $this->success('操作成功！');
    }
}
