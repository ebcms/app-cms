{include web/common/header@ebcms/cms}
<div class="row">
    <div class="col-md-9">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{:$router->buildUrl('/ebcms/cms/web/index')}">主页</a></li>
                {foreach $category_model->pdata($category['id']) as $vo}
                <li class="breadcrumb-item"><a href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$vo['alias']?:$vo['id']])}">{$vo.title}</a></li>
                {/foreach}
                <li class="breadcrumb-item" aria-current="page"><a href="{:$router->buildUrl('/ebcms/cms/web/content', ['id'=>$content['alias']?:$content['id']])}">{$content.title}</a></li>
            </ol>
        </nav>
        <h1 class="h1 mt-3">{$content.title}</h1>
        <hr>
        <div class="mb-3 text-muted text-monospace"><span class="mr-2">更新时间：{:date('Y-m-d H:i', $content['update_time'])}</span><span>浏览：{$content.click}</span></div>
        <div class="my-3">
            <div class="alert alert-warning my-3">
                <h2>说明</h2>
                <p>这是默认模板，没有任何意义，通常你可以根据自定义的字段进行页面调用展示。</p>
            </div>
            <h5 class="my-3">自定义筛选项</h5>
            <?php
            $filters = [];
            foreach (array_filter(explode(PHP_EOL, $category['filters'])) as $val) {
                $field = [];
                foreach (array_filter(explode(';', trim($val))) as $tmp) {
                    list($k, $v) = explode('=', trim($tmp));
                    $field[trim($k)] = trim($v);
                }
                $filters[] = $field;
            }
            ?>
            <table class="table table-bordered table-dark table-striped table-sm">
                <tr>
                    <th>名字</th>
                    <th>字段</th>
                    <th>调用方式</th>
                </tr>
                {foreach $filters as $vo}
                <tr>
                    <td>{$vo.label}</td>
                    <td>{$vo.name}</td>
                    <td><code>{literal}{$content['{/literal}{$vo.name}{literal}']??'默认值'}{/literal}</code></td>
                </tr>
                {/foreach}
            </table>
            <h5 class="my-3">自定义字段</h5>
            <?php
            $fields = [];
            foreach (array_filter(explode(PHP_EOL, $category['fields'])) as $val) {
                $field = [];
                foreach (array_filter(explode(';', trim($val))) as $tmp) {
                    list($k, $v) = explode('=', trim($tmp));
                    $field[trim($k)] = trim($v);
                }
                $fields[] = $field;
            }
            ?>
            <table class="table table-bordered table-dark table-striped table-sm">
                <tr>
                    <th>名字</th>
                    <th>字段</th>
                    <th>类型</th>
                    <th>调用方式</th>
                </tr>
                {foreach $fields as $vo}
                <tr>
                    <td>{$vo.label}</td>
                    <td>{$vo.name}</td>
                    <td>{$vo.type}</td>
                    <td><code>{literal}{$content['body']['{/literal}{$vo.name}{literal}']??'默认值'}{/literal}</code></td>
                </tr>
                {/foreach}
            </table>
        </div>
    </div>
    <div class="col-md-3">
        {include web/common/sidebar@ebcms/cms}
    </div>
</div>
{include web/common/footer@ebcms/cms}