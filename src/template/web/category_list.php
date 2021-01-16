{include web/common/header@ebcms/cms}
<div class="row">
    <div class="col-md-9">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{:$router->buildUrl('/ebcms/cms/web/index')}">主页</a></li>
                {foreach $category_model->pdata($category['id']) as $vo}
                <li class="breadcrumb-item"><a href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$vo['alias']?:$vo['id']])}">{$vo.title}</a></li>
                {/foreach}
            </ol>
        </nav>
        <div class="card mb-3 bg-light">
            <div class="card-header"><a href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$category['alias']?:$category['id']])}">{$category['title']}</a></div>
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
    </div>
    <div class="col-md-3">
        {include web/common/sidebar@ebcms/cms}
    </div>
</div>
{include web/common/footer@ebcms/cms}