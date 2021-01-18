<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Model;

use Ebcms\App;
use Ebcms\Database\Model;

class Content extends Model
{
    public function getTable(): string
    {
        return 'ebcms_cms_content';
    }

    public function getRelationContents(string $tags): array
    {
        if ($tags = explode(',', $tags)) {
            return App::getInstance()->execute(function (
                Tag $tag
            ) use ($tags): array {
                if ($content_ids = $tag->select('content_id', [
                    'tag' => $tags,
                    'LIMIT' => 10,
                    'ORDER' => [
                        'id' => 'DESC',
                    ],
                ])) {
                    return $this->select('*', [
                        'state' => 1,
                        'id' => $content_ids,
                    ]);
                }
                return [];
            });
        }
        return [];
    }
}
