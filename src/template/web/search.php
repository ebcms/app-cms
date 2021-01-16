{include web/common/header@ebcms/cms}
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{:$router->buildUrl('/ebcms/cms/web/index')}">主页</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{:$router->buildUrl('/ebcms/cms/web/search')}">搜索</a></li>
    </ol>
</nav>

<div class="my-4">
    <form method="GET">
        <div class="input-group mb-3">
            <input type="text" name="q" value="{:$input->get('q')}" class="form-control" style="max-width: 250px;" placeholder="请输入关键词，最少2个字符！" aria-label="请输入关键词，最少2个字符！" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" id="button-addon2">搜索</button>
            </div>
        </div>
    </form>
</div>

<div class="card mb-3 bg-light">
    <div class="card-header">检索：{:$input->get('q')}</div>
    <div class="list-group list-group-flush">
        {foreach $contents as $item}
        <a class="list-group-item list-group-item-action text-nowrap text-truncate" href="{:$router->buildUrl('/ebcms/cms/web/content', ['id'=>$item['alias']?:$item['id']])}"><span class="text-muted float-right d-none d-sm-block">{:date('Y-m-d H:i', $item['create_time'])}</span>▪ {$item.title}</a>
        {/foreach}
    </div>
</div>

<nav class="my-3">
    <ul class="pagination">
        {foreach $pagination as $v}
        {if $v=='...'}
        <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">{$v}</a></li>
        {elseif isset($v['current'])}
        <li class="page-item active"><a class="page-link" href="javascript:void(0);">{$v.page}</a></li>
        {else}
        <li class="page-item"><a class="page-link" href="{:$router->buildUrl('/ebcms/cms/web/category', array_merge($_GET, ['page'=>$v['page']]))}">{$v.page}</a></li>
        {/if}
        {/foreach}
    </ul>
</nav>
{include web/common/footer@ebcms/cms}