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
        <h1 class="h1 mt-3">{$category.title}</h1>
        <hr>
        <div class="body">
            {$category.body}
        </div>
    </div>
    <div class="col-md-3">
        {include web/common/sidebar@ebcms/cms}
    </div>
</div>
{include web/common/footer@ebcms/cms}