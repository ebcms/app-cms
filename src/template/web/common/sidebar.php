{if $category['type']=='channel'}
<div class="card">
    <div class="card-header">
        <a href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$category['alias']?:$category['id']])}">{$category['title']}</a>
    </div>
    <div class="list-group list-group-flush">
        {foreach $category_model->all() as $item}
        {if $item['pid']==$category['id']}
        <a class="list-group-item {if $category['id']==$item['id']}active{/if}" href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$item['alias']?:$item['id']])}">{$item.title}</a>
        {/if}
        {/foreach}
    </div>
</div>
{else}
<div class="card">
    <div class="card-header">
        {php $parent = $category_model->getItem($category['pid'])}
        {if $parent}
        <a href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$parent['alias']?:$parent['id']])}">{$parent['title']}</a>
        {else}
        导航
        {/if}
    </div>
    <div class="list-group list-group-flush">
        {foreach $category_model->all() as $item}
        {if $item['pid']==$category['pid']}
        <a class="list-group-item {if $category['id']==$item['id']}active{/if}" href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$item['alias']?:$item['id']])}">{$item.title}</a>
        {/if}
        {/foreach}
    </div>
</div>
{/if}