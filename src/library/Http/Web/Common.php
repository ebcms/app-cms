<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Web;

use App\Ebcms\Cms\Model\Category;
use App\Ebcms\Cms\Model\Content;
use App\Ebcms\Cms\Model\Tag;
use App\Ebcms\Web\Http\Common as HttpCommon;
use Ebcms\Template;

abstract class Common extends HttpCommon
{
    public function __construct(
        Template $template,
        Category $modelCategory,
        Content $modelContent,
        Tag $modelTag
    ) {
        $data = [];
        $data['category_model'] = $modelCategory;
        $data['content_model'] = $modelContent;
        $data['tag_model'] = $modelTag;
        $template->assign($data);
        parent::__construct();
    }
}
