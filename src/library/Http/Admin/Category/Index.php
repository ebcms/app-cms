<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Category;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Category;
use Ebcms\Template;

class Index extends Common
{

    public function get(
        Category $categoryModel,
        Template $template
    ) {
        return $this->html($template->renderFromFile('admin/category/index@ebcms/cms', [
            'categorys' => $categoryModel->select('*', [
                'ORDER' => [
                    'priority' => 'DESC',
                    'id' => 'ASC',
                ],
            ]),
        ]));
    }
}
