{include web/common/header@ebcms/cms}
<div class="row">
    <div class="col-md-9">
        {include web/common/nav@ebcms/cms}
        <h1 class="h1 mt-3">{$content.title}</h1>
        <hr>
        <div class="mb-3 text-muted text-monospace"><span class="mr-2">更新时间：{:date('Y-m-d H:i', $content['update_time'])}</span><span>浏览：{$content.click}</span></div>
        <div class="my-3">
            {:htmlspecialchars_decode($content['body'])}
        </div>
        {if $relations=$content_model->getRelationContents($content['tags'])}
        <div class="bg-light p-3">
            <div class="h4">相关内容</div>
            <ol class="list-unstyled" style="margin-bottom: 0;">
                {foreach $relations as $vo}
                <li><a href="{:$router->buildUrl('/ebcms/cms/web/content', ['id'=>$vo['alias']?:$vo['id']])}">{$vo.title}</a></li>
                {/foreach}
            </ol>
        </div>
        {/if}
    </div>
    <div class="col-md-3">
        {include web/common/sidebar@ebcms/cms}
    </div>
</div>
{include web/common/footer@ebcms/cms}