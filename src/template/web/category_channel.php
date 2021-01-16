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
        {if $category_model->hasSubList($category['id'])}
        <div class="row">
            {foreach $category_model->all() as $vo}
            {if $vo['pid']==$category['id'] && ($vo['type']=='list' || $category_model->hasSubList($vo['id']))}
            {php $ids = $category_model->subid($vo['id'])}
            {php $ids[]=$vo['id']}
            <div class="col-md-6">
                <div class="card mb-3 bg-light">
                    <div class="card-header"><a href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$vo['alias']?:$vo['id']])}">{$vo['title']}</a></div>
                    {php $contents = $content_model->select('*', ['category_id'=>$ids, 'state'=>1,'LIMIT'=>5,'ORDER'=>['id'=>'DESC']])}
                    {if $content=array_shift($contents)}
                    <div class="card-body">
                        <div class="media position-relative">
                            {if $content['cover']}
                            <img src="{$content.cover}" style="width:90px;height:90px;" class="mr-3" alt="...">
                            {else}
                            <svg t="1610434793151" class="icon mr-3" viewBox="0 0 1574 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="7899" width="90" height="90">
                                <path d="M994.927445 125.981073h-613.753943c-48.454259 0-87.217666 38.763407-87.217666 87.217665v613.753943c0 48.454259 38.763407 87.217666 87.217666 87.217666h613.753943c48.454259 0 87.217666-38.763407 87.217665-87.217666v-613.753943c0-48.454259-38.763407-87.217666-87.217665-87.217665z m-468.391167 206.73817c38.763407 0 71.066246 32.302839 71.066246 71.066246 0 38.763407-32.302839 71.066246-71.066246 71.066246-38.763407 0-71.066246-32.302839-71.066246-71.066246 0-38.763407 32.302839-71.066246 71.066246-71.066246z m-145.362776 449.009464l155.053627-197.047319 109.829653 132.44164 155.053628-197.047318 197.047319 261.652997H381.173502z" fill="#C3DEFA" p-id="7900"></path>
                                <path d="M1169.362776 235.810726h-613.753943c-48.454259 0-87.217666 38.763407-87.217666 87.217665v613.753943c0 48.454259 38.763407 87.217666 87.217666 87.217666h613.753943c48.454259 0 87.217666-38.763407 87.217666-87.217666V323.028391c0-48.454259-38.763407-87.217666-87.217666-87.217665z m-468.391167 206.73817c38.763407 0 71.066246 32.302839 71.066246 71.066246s-32.302839 71.066246-71.066246 71.066246c-38.763407 0-71.066246-32.302839-71.066246-71.066246s32.302839-71.066246 71.066246-71.066246z m-145.362776 449.009464l155.053628-197.047319 109.829653 132.44164 155.053627-197.047318 197.047319 261.652997H555.608833z m0 0" fill="#3A95F2" p-id="7901"></path>
                                <path d="M177.665615 784.958991H122.750789v-54.914827c0-12.921136-9.690852-22.611987-22.611988-22.611987-12.921136 0-22.611987 9.690852-22.611987 22.611987v54.914827H22.611987c-12.921136 0-22.611987 9.690852-22.611987 22.611987 0 12.921136 9.690852 22.611987 22.611987 22.611987h54.914827v54.914827c0 12.921136 9.690852 22.611987 22.611987 22.611987 12.921136 0 22.611987-9.690852 22.611988-22.611987v-54.914827h54.914826c12.921136 0 22.611987-9.690852 22.611988-22.611987 0-12.921136-9.690852-22.611987-22.611988-22.611987z m0 0M100.138801 432.858044h122.750789v122.750789H100.138801zM1288.883281 93.678233c0 35.533123 29.072555 61.375394 61.375394 61.375395 35.533123 0 61.375394-29.072555 61.375394-61.375395 0-35.533123-29.072555-61.375394-61.375394-61.375394-35.533123 0-61.375394 25.842271-61.375394 61.375394z m0 0" fill="#C3DEFA" p-id="7902"></path>
                                <path d="M1569.917981 794.649842l-93.678233-93.678233c-6.460568-6.460568-16.15142-6.460568-22.611988 0l-96.908517 93.678233c-6.460568 6.460568-6.460568 16.15142 0 22.611988l93.678233 93.678233c6.460568 6.460568 16.15142 6.460568 22.611988 0l93.678233-93.678233c9.690852-6.460568 9.690852-16.15142 3.230284-22.611988z m-106.599369 80.757098L1392.252366 807.570978l71.066246-71.066246 71.066246 71.066246-71.066246 67.835962zM303.646688 12.921136C297.18612 6.460568 290.725552 0 281.0347 0H45.223975C35.533123 0 29.072555 6.460568 22.611987 12.921136c-3.230284 9.690852 0 19.381703 6.460568 25.842271l119.520505 119.520505c3.230284 3.230284 9.690852 6.460568 16.151419 6.460567s9.690852-3.230284 12.921136-9.690851l119.520505-119.520505c6.460568-3.230284 6.460568-12.921136 6.460568-22.611987z m-138.902209 96.908517l-64.605678-64.605678h132.441641l-67.835963 64.605678z" fill="#3A95F2" p-id="7903"></path>
                            </svg>
                            {/if}
                            <div class="media-body">
                                <h5 class="mt-0">{$content.title}</h5>
                                <a href="{:$router->buildUrl('/ebcms/cms/web/content', ['id'=>$content['alias']?:$content['id']])}" class="stretched-link">[详情]</a>
                            </div>
                        </div>
                    </div>
                    {/if}
                    <div class="list-group list-group-flush">
                        {foreach $contents as $item}
                        <a class="list-group-item list-group-item-action text-nowrap text-truncate" href="{:$router->buildUrl('/ebcms/cms/web/content', ['id'=>$item['alias']?:$item['id']])}">▪ {$item.title}</a>
                        {/foreach}
                    </div>
                </div>
            </div>
            {/if}
            {/foreach}
        </div>
        {else}
        <div class="card mb-3 bg-light">
            <div class="list-group list-group-flush">
                {foreach $category_model->all() as $vo}
                {if $vo['pid']==$category['id']}
                <a class="list-group-item list-group-item-action text-nowrap text-truncate" href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$vo['alias']?:$vo['id']])}">▪ {$vo.title}</a>
                {/if}
                {/foreach}
            </div>
        </div>
        {/if}
    </div>
    <div class="col-md-3">
        {include web/common/sidebar@ebcms/cms}
    </div>
</div>
{include web/common/footer@ebcms/cms}