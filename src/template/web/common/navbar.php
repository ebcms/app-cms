<nav class="navbar navbar-expand-lg navbar-light mb-3 shadow-sm border bg-light rounded">
    <!-- <a class="navbar-brand" href="{:$router->buildUrl('/ebcms/cms/web/index')}">首页</a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{:$router->buildUrl('/ebcms/cms/web/index')}">首页 <span class="sr-only">(current)</span></a>
            </li>
            {foreach $category_model->getAll() as $vo}
            {if $vo['pid']==0 && $vo['nav']==1}
            {if $vo['type']=='channel'}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$vo['alias']?:$vo['id']])}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {$vo.title}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {foreach $category_model->getAll() as $sub}
                    {if $sub['pid']==$vo['id'] && $sub['nav']==1}
                    <a class="dropdown-item" href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$sub['alias']?:$sub['id']])}">{$sub.title}</a>
                    {/if}
                    {/foreach}
                </div>
            </li>
            {else}
            <li class="nav-item">
                <a class="nav-link" href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$vo['alias']?:$vo['id']])}">{$vo.title}</a>
            </li>
            {/if}
            {/if}
            {/foreach}
        </ul>
        <form class="form-inline my-2 my-lg-0" action="{:$router->buildUrl('/ebcms/cms/web/search')}">
            <input class="form-control mr-sm-2" type="search" name="q" placeholder="搜索" aria-label="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit">搜索</button>
        </form>
    </div>
</nav>