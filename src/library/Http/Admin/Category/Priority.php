<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Category;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Category;
use Ebcms\RequestFilter;

class Priority extends Common
{
    public function post(
        RequestFilter $input,
        Category $categoryModel
    ) {
        $type = $input->post('type');
        $category = $categoryModel->get('*', [
            'id' => $input->post('id'),
        ]);

        $categorys = $categoryModel->select('*', [
            'pid' => $category['pid'],
            'ORDER' => [
                'priority' => 'DESC',
                'id' => 'ASC',
            ],
        ]);

        $count = $categoryModel->count([
            'pid' => $category['pid'],
            'id[!]' => $category['id'],
            'priority[<=]' => $category['priority'],
            'ORDER' => [
                'priority' => 'DESC',
                'id' => 'ASC',
            ],
        ]);
        $change_key = $type == 'up' ? $count + 1 : $count - 1;

        if ($change_key < 0) {
            return $this->failure('已经是最有一位了！');
        }
        if ($change_key > count($categorys) - 1) {
            return $this->failure('已经是第一位了！');
        }
        $categorys = array_reverse($categorys);
        foreach ($categorys as $key => $value) {
            if ($key == $change_key) {
                $categoryModel->update([
                    'priority' => $count,
                ], [
                    'id' => $value['id'],
                ]);
            } elseif ($key == $count) {
                $categoryModel->update([
                    'priority' => $change_key,
                ], [
                    'id' => $value['id'],
                ]);
            } else {
                $categoryModel->update([
                    'priority' => $key,
                ], [
                    'id' => $value['id'],
                ]);
            }
        }
        return $this->success('操作成功！');
    }
}
