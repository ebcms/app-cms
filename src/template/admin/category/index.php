{include common/header@ebcms/admin}
<div class="my-4 display-4">栏目管理</div>
<div class="my-3">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            新建
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{:$router->buildUrl('/ebcms/cms/admin/category/create', ['type'=>'channel'])}">频道</a>
            <a class="dropdown-item" href="{:$router->buildUrl('/ebcms/cms/admin/category/create', ['type'=>'list'])}">栏目</a>
            <a class="dropdown-item" href="{:$router->buildUrl('/ebcms/cms/admin/category/create', ['type'=>'page'])}">页面</a>
        </div>
    </div>
</div>
<script>
    function priority(id, type) {
        $.ajax({
            type: "POST",
            url: "{:$router->buildUrl('/ebcms/cms/admin/category/priority')}",
            data: {
                id: id,
                type: type,
            },
            dataType: "JSON",
            success: function(response) {
                if (!response.code) {
                    alert(response.message);
                } else {
                    location.reload();
                }
            }
        });
    }
</script>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>标题</th>
                <th>排序</th>
                <th>管理</th>
            </tr>
        </thead>
        <tbody>
            {function test($categorys, $router, $pid=0, $level=0)}
            {foreach $categorys as $vo}
            {if $vo['pid'] == $pid}
            <tr>
                <td>{$vo.id}</td>
                <td>
                    <a href="{:$router->buildUrl('/ebcms/cms/web/category', ['id'=>$vo['alias']?:$vo['id']])}" target="_blank" class="d-inline-block text-decoration-none" style="margin-left: {$level*2}0px;">
                        {if $vo['type'] == 'channel'}
                        <svg t="1606737546524" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="14524" width="20" height="20">
                            <path d="M480 128c19.2 0 44.8 12.8 51.2 32l64 96H768c38.4 0 64 25.6 64 64H268.8c-32 0-57.6 19.2-64 44.8L64 729.6V192c0-38.4 25.6-64 64-64h352z" fill="#9EADCC" p-id="14525"></path>
                            <path d="M300.8 384h633.6c38.4 0 64 25.6 64 64 0 6.4 0 12.8-6.4 25.6l-140.8 384c-6.4 25.6-32 38.4-57.6 38.4h-640c-38.4 0-64-25.6-64-64 0-6.4 0-12.8 6.4-25.6l140.8-384c12.8-19.2 38.4-38.4 64-38.4z" fill="#C0CCE5" p-id="14526"></path>
                        </svg>
                        {elseif $vo['type']=='list'}
                        <svg t="1606737219250" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1270" width="20" height="20">
                            <path d="M409.6 294.4a38.4 38.4 0 0 1 0-76.8h460.8a38.4 38.4 0 1 1 0 76.8H409.6zM409.6 550.4a38.4 38.4 0 0 1 0-76.8h460.8a38.4 38.4 0 1 1 0 76.8H409.6zM409.6 806.4a38.4 38.4 0 1 1 0-76.8h460.8a38.4 38.4 0 1 1 0 76.8H409.6z" fill="#2E3344" p-id="1271"></path>
                            <path d="M204.8 256m-51.2 0a51.2 51.2 0 1 0 102.4 0 51.2 51.2 0 1 0-102.4 0Z" fill="#2E3344" p-id="1272"></path>
                            <path d="M204.8 512m-51.2 0a51.2 51.2 0 1 0 102.4 0 51.2 51.2 0 1 0-102.4 0Z" fill="#2E3344" p-id="1273"></path>
                            <path d="M204.8 768m-51.2 0a51.2 51.2 0 1 0 102.4 0 51.2 51.2 0 1 0-102.4 0Z" fill="#2E3344" p-id="1274"></path>
                        </svg>
                        {elseif $vo['type']=='page'}
                        <svg t="1604994173305" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="53495" width="20" height="20">
                            <path d="M851.6 926.2H171.9V109.4l432.7-0.4 247 247v570.2z m-628.4-51.4h577V377.3L583.3 160.4l-360.1 0.3v714.1z" fill="#838383" p-id="53496"></path>
                            <path d="M810.7 390.8H552.5V141.9h51.4v197.6h206.8z" fill="#838383" p-id="53497"></path>
                        </svg>
                        {/if}
                        {$vo.title}
                        {if $vo['state'] != 1}
                        <svg t="1602830494680" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="107862" width="20" height="20">
                            <path d="M504.064 950.4768c227.2256 0 411.392-184.8832 411.392-412.8768 0-227.9936-184.1664-412.8768-411.392-412.8768-227.328 0-411.4432 184.8832-411.4432 412.8768 0 227.9936 184.1664 412.8768 411.4432 412.8768z m0-90.112c-177.4592 0-321.3312-144.4352-321.3312-322.7648s143.872-322.7648 321.3312-322.7648c177.408 0 321.28 144.4352 321.28 322.7648s-143.872 322.7648-321.28 322.7648z" fill="#F34747" p-id="107863"></path>
                            <path d="M228.0448 329.0112l67.072-60.5696 444.1088 495.4624-67.0208 60.5696z" fill="#F34747" p-id="107864"></path>
                        </svg>
                        {/if}
                        {if $vo['nav'] != 1}
                        <svg t="1602830112026" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="89686" width="20" height="20">
                            <path d="M510.193366 194.39379c-24.570219 0-49.140438 2.16796-73.710656 5.781228-5.781228 5.058574-10.839802 10.117149-16.62103 15.898376-39.023289 39.745942-69.374735 86.718419-90.331687 137.304164 44.081863-51.308398 108.398024-83.105152 180.663373-83.105152 132.245589 0 239.198306 108.398024 239.198307 242.088921s-106.952717 242.08892-239.198307 242.08892c-72.265349 0-136.58151-32.519407-180.663373-83.105152 20.234298 50.585745 50.585745 97.558222 90.331687 137.304164 5.058574 5.058574 10.839802 10.839802 16.62103 15.898377 24.570219 3.613267 49.140438 5.781228 73.710656 5.781228 197.284404 0 375.057163-117.069866 498.630911-279.666902 16.62103-21.679605 16.62103-53.476359 0-75.155963-123.573747-164.764996-301.346507-281.112209-498.630911-281.112209z" fill="#F5AC00" p-id="89687"></path>
                            <path d="M513.806634 194.39379C315.799577 194.39379 138.026817 310.741002 14.45307 474.060692-2.16796 495.740296-2.16796 527.53705 14.45307 549.216655c123.573747 162.597036 301.346507 279.666902 498.63091 279.666902 24.570219 0 49.140438-2.16796 73.710657-5.781228 5.781228-5.058574 10.839802-10.117149 16.62103-15.898377 39.023289-39.745942 69.374735-86.718419 90.331687-137.304164-44.081863 51.308398-108.398024 83.105152-180.663374 83.105152-132.245589 0-239.198306-108.398024-239.198306-242.08892S380.838391 268.8271 513.08398 268.8271c72.265349 0 136.58151 32.519407 180.663374 83.105151-20.234298-50.585745-51.308398-97.558222-90.331687-137.304163-5.058574-5.058574-10.839802-10.839802-16.62103-15.898377-23.847565-2.890614-48.417784-4.335921-72.988003-4.335921z" fill="#F5AC00" p-id="89688"></path>
                            <path d="M512.361327 373.611856c75.155963 0 136.58151 62.1482 136.58151 138.749471s-61.425547 138.749471-136.58151 138.74947C436.48271 650.388144 375.779817 588.239944 375.779817 512.361327c0-18.788991 3.613267-36.855328 10.117148-53.476359 6.503881 31.0741 33.964714 54.921665 66.484122 54.921666 37.577982 0 67.929428-31.0741 67.929428-69.374736 0-30.351447-19.511644-56.366972-46.249823-65.761468 13.007763-2.890614 25.292872-5.058574 38.300635-5.058574z" fill="#FFCE6C" p-id="89689"></path>
                            <path d="M161.874382 878.746648l-16.62103-16.62103c-5.781228-5.781228-5.781228-15.175723 0-20.234298l696.637968-696.637968c5.781228-5.781228 15.175723-5.781228 20.234298 0l16.62103 16.62103c5.781228 5.781228 5.781228 15.175723 0 20.234298l-696.637968 696.637968c-5.058574 5.781228-14.45307 5.781228-20.234298 0z" fill="#F5AC00" p-id="89690"></path>
                        </svg>
                        {/if}
                        {if $vo['redirect_uri']}
                        <svg t="1602815375380" class="icon" viewBox="0 0 1638 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="20186" width="20" height="20">
                            <path d="M768 716.8h-51.2v-102.4h51.2a256 256 0 0 0 0-512H358.4a256 256 0 0 0 0 512h51.2v102.4H358.4A358.4 358.4 0 0 1 358.4 0h409.6a358.4 358.4 0 0 1 0 716.8z" fill="#54C3F1" p-id="20187"></path>
                            <path d="M1280 1024h-409.6a358.4 358.4 0 0 1 0-716.8h51.2v102.4h-51.2a256 256 0 0 0 0 512h409.6a256 256 0 0 0 0-512h-51.2V307.2h51.2a358.4 358.4 0 0 1 0 716.8z" fill="#54C3F1" p-id="20188"></path>
                        </svg>
                        {/if}
                    </a>
                </td>
                <td class="text-nowrap">
                    <a href="#" onclick="priority('{$vo.id}', 'up')">上移</a>
                    <a href="#" onclick="priority('{$vo.id}', 'down')">下移</a>
                </td>
                <td class="text-nowrap">
                    <a href="{:$router->buildUrl('/ebcms/cms/admin/category/update', ['id'=>$vo['id']])}">编辑</a>
                    <a href="{:$router->buildUrl('/ebcms/cms/admin/category/delete', ['id'=>$vo['id']])}" onclick="return confirm('删除后无法恢复，确定删除？');">删除</a>
                </td>
            </tr>
            {:test($categorys, $router, $vo['id'], $level+1)}
            {/if}
            {/foreach}
            {/function}
            {:test($categorys, $router, 0, 0)}
        </tbody>
    </table>
</div>
{include common/footer@ebcms/admin}