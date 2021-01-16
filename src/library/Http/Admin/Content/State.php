<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Content;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Content;
use Ebcms\RequestFilter;

class State extends Common
{
    public function post(
        RequestFilter $input,
        Content $contentModel
    ) {
        $contentModel->update([
            'state' => $input->post('state'),
        ], [
            'id' => $input->post('ids'),
        ]);
        return $this->success('操作成功！');
    }
}
