<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{:$router->buildUrl('/ebcms/cms/web/index')}">主页</a></li>
        {foreach $position as $vo}
        <li class="breadcrumb-item"><a href="{$vo['url']??'#'}">{$vo.title}</a></li>
        {/foreach}
    </ol>
</nav>