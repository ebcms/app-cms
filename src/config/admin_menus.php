<?php

use Ebcms\App;
use Ebcms\Router;

return App::getInstance()->execute(function (
    Router $router
): array {
    $res = [];
    $res[] = [
        'title' => '栏目管理',
        'url' => $router->buildUrl('/ebcms/cms/admin/category/index'),
        'icon' => '<svg t="1609654132427" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="19787" width="20" height="20"><path d="M754.4 264.1m-200 0a200 200 0 1 0 400 0 200 200 0 1 0-400 0Z" fill="#50E067" p-id="19788"></path><path d="M754.4 759.6m-200 0a200 200 0 1 0 400 0 200 200 0 1 0-400 0Z" fill="#FF7800" p-id="19789"></path><path d="M265.4 759.6m-200 0a200 200 0 1 0 400 0 200 200 0 1 0-400 0Z" fill="#59A6FF" p-id="19790"></path><path d="M265.4 128.1c36.3 0 70.5 14.1 96.2 39.8 25.7 25.7 39.8 59.8 39.8 96.2s-14.1 70.5-39.8 96.2c-25.7 25.7-59.8 39.8-96.2 39.8S195 386 169.3 360.3c-25.7-25.7-39.8-59.8-39.8-96.2s14.1-70.5 39.8-96.2 59.8-39.8 96.1-39.8m0-64c-110.5 0-200 89.5-200 200s89.5 200 200 200 200-89.5 200-200-89.5-200-200-200z" fill="#A6A7A8" p-id="19791"></path></svg>',
        'priority' => 61,
    ];
    $res[] = [
        'title' => '内容管理',
        'url' => $router->buildUrl('/ebcms/cms/admin/content/index'),
        'icon' => '<svg t="1606136827208" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="20606" width="20" height="20"><path d="M926.250667 0.810667H296.981333A62.656 62.656 0 0 0 234.453333 63.232v56.192h487.616c11.584 0.085333 23.104 1.493333 34.368 4.16a162.858667 162.858667 0 0 1 32.192 12.16c4.309333 1.962667 8.405333 4.373333 12.181334 7.210667 9.6 6.4 18.368 13.973333 26.090666 22.549333 7.253333 8.384 13.653333 17.429333 19.136 27.072 11.008 20.138667 17.173333 42.538667 18.048 65.450667 0.853333 18.048 0 36.586667 0 54.250666v512h62.058667a62.784 62.784 0 0 0 62.528-62.528V63.232A62.656 62.656 0 0 0 926.144 0.810667h0.106667z" fill="#F67A15" p-id="20607"></path><path d="M724.501333 195.136H95.466667a62.784 62.784 0 0 0-62.528 62.528v698.154667a62.656 62.656 0 0 0 62.528 62.421333h629.034666a62.656 62.656 0 0 0 62.549334-62.421333V257.664a62.784 62.784 0 0 0-62.549334-62.528zM190.186667 854.506667a39.381333 39.381333 0 1 1 0-78.741334 39.381333 39.381333 0 0 1 0 78.741334z m0-202.24a39.488 39.488 0 1 1-0.213334-78.997334 39.488 39.488 0 0 1 0.213334 78.997334z m0-214.656a39.488 39.488 0 1 1-0.213334-78.997334 39.488 39.488 0 0 1 0.213334 78.997334z m438.869333 416.896H348.672a39.381333 39.381333 0 1 1 0-78.741334h280.384a39.381333 39.381333 0 1 1 0 78.741334z m0-202.24H348.672a39.488 39.488 0 0 1 0-78.869334h280.384a39.488 39.488 0 1 1 0 78.869334z m0-214.677334H348.672a39.488 39.488 0 0 1 0-78.869333h280.384a39.488 39.488 0 1 1 0 78.869333z" fill="#4898FF" p-id="20608"></path></svg>',
        'priority' => 60,
    ];
    return $res;
});