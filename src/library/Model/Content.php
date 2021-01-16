<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Model;

use Ebcms\Database\Model;

class Content extends Model
{
    public function getTable(): string
    {
        return 'ebcms_cms_content';
    }
}
