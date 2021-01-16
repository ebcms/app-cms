<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Category;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Content;
use App\Ebcms\Cms\Model\Category;
use App\Ebcms\Cms\Model\Tag;
use Ebcms\RequestFilter;

class Delete extends Common
{
    public function get(
        RequestFilter $input,
        Content $contentModel,
        Tag $tagModel,
        Category $categoryModel
    ) {
        if ($categoryModel->get('*', [
            'pid' => $input->get('id')
        ])) {
            return $this->failure('请先删除子栏目！');
        }
        if ($content_ids = $contentModel->get('id', [
            'category_id' => $input->get('id', 0, ['intval']),
        ])) {
            $tagModel->delete([
                'content_id' => $content_ids,
            ]);
        }
        $contentModel->delete([
            'category_id' => $input->get('id', 0, ['intval']),
        ]);
        $categoryModel->delete([
            'id' => $input->get('id', 0, ['intval']),
        ]);
        return $this->success('操作成功！');
    }
}
