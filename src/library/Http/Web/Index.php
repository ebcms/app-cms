<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Web;

use Ebcms\Config;
use Ebcms\Template;

class Index extends Common
{

    public function get(
        Config $config,
        Template $template
    ) {
        $data = [];
        $data['meta'] = [
            'title' => $config->get('meta.title@ebcms.web'),
            'keywords' => $config->get('meta.keywords@ebcms.web'),
            'description' => $config->get('meta.description@ebcms.web'),
        ];
        return $this->html($template->renderFromFile('web/index@ebcms/cms', $data));
    }
}
