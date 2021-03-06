{include common/header@ebcms/admin}
<div class="my-4 display-4">内容管理</div>
<div class="my-3">
    <form id="form_2" class="form-inline" action="{:$router->buildUrl('/ebcms/cms/admin/content/index')}" method="GET">

        <label class="mr-2">栏目</label>
        <select class="custom-select mr-sm-2" name="category_id" onchange="document.getElementById('form_2').submit();">
            <option {if $input->get('category_id')=='' }selected{/if} value="">不限</option>
            {function mulu($datas, $pid=0, $curid=0, $level=0)}
            {foreach $datas as $vo}
            {if $vo['pid']==$pid}
            {if $vo['type']=='channel'}
            <option {if $curid==$vo['id'] }selected{/if} value="{$vo['id']}" disabled>{:str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level)}▼ {$vo.title}</option>
            {:mulu($datas, $vo['id'], $curid, $level+1)}
            {elseif $vo['type'] == 'list'}
            <option {if $curid==$vo['id'] }selected{/if} value="{$vo['id']}">{:str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level)}┣ {$vo.title}</option>
            {else}
            <!-- <option {if $curid==$vo['id'] }selected{/if} value="{$vo['id']}" disabled>{:str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level)}┣ {$vo.title}</option> -->
            {/if}
            {/if}
            {/foreach}
            {/function}
            {:mulu($categorys, 0, $input->get('category_id'), 0)}
        </select>

        <label class="mr-2">状态</label>
        <select class="custom-select mr-sm-2" name="state" onchange="document.getElementById('form_2').submit();">
            <option {if $input->get('state')=='' }selected{/if} value="">不限</option>
            <option {if $input->get('state')=='2' }selected{/if} value="2">待审</option>
            <option {if $input->get('state')=='1' }selected{/if} value="1">发布</option>
        </select>

        <label class="mr-2">分页</label>
        <select class="custom-select mr-sm-2" name="page_num" onchange="document.getElementById('form_2').submit();">
            <option {if $input->get('page_num')=='20' }selected{/if} value="20">20</option>
            <option {if $input->get('page_num')=='50' }selected{/if} value="50">50</option>
            <option {if $input->get('page_num')=='100' }selected{/if} value="100">100</option>
            <option {if $input->get('page_num')=='500' }selected{/if} value="500">500</option>
        </select>

        <label class="mr-2">搜索</label>
        <input type="search" class="form-control" name="q" value="{:$input->get('q')}" onchange="document.getElementById('form_2').submit();">
        <input type="hidden" name="page" value="1">
    </form>
</div>
{if $input->get('category_id')}
<div class="my-3">
    <a href="{:$router->buildUrl('/ebcms/cms/admin/content/create', ['category_id'=>$input->get('category_id')])}" class="btn btn-primary">发布</a>
</div>
{else}
<div class="my-3">
    <button type="button" class="btn btn-primary disabled" onclick="alert('请先选择栏目')">发布</button>
</div>
{/if}
<?php
function gl_format_date($time)
{
    $today = strtotime(date('Y-m-d 23:59:59', time()));
    if ($today - 86400 < $time) {
        if (time() - $time < 3600) {
            return '刚刚';
        }
        return '今天';
    }
    if ($today - 2 * 86400 < $time) {
        return '昨天';
    }
    if ($today - 3 * 86400 < $time) {
        return '前天';
    }
    return date('Y年m月d日', $time);
}
?>
<div class="table-responsive">
    <table class="table table-bordered" id="tablexx">
        <thead>
            <tr>
                <th class="text-nowrap">ID</th>
                <th class="text-nowrap">时间</th>
                <th class="text-nowrap">标题</th>
                <th class="text-nowrap">点击量</th>
                <th class="text-nowrap">管理</th>
            </tr>
        </thead>
        <tbody>
            {foreach $data as $vo}
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="ids[]" value="{$vo.id}" class="custom-control-input" id="checkbox_{$vo.id}">
                        <label class="custom-control-label" for="checkbox_{$vo.id}">{$vo.id}</label>
                    </div>
                </td>
                <td>
                    <span class="text-muted text-nowrap" title="{:date('Y-m-d H:i:s', $vo['create_time'])}">{:gl_format_date($vo['create_time'])}</span>
                </td>
                <td class="text-nowrap text-truncate align-middle" style="max-width: 30em;">
                    {if $vo['state'] != 1}
                    <svg t="1602909618337" class="icon" viewBox="0 0 2252 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="19610" width="50" height="20">
                        <path d="M1500.384256 957.2864c4.1984 4.864 7.3216 3.2768 9.4208-1.536 9.4208-34.4576-94.9248-22.9888-101.12-21.248 3.072 4.864 6.1952 8.192 10.3936 9.728-25.0368-3.2768-67.7888-18.0736-97.9968-18.0736-11.52 0-99.0208 4.9152-100.1472 3.328-5.1712-3.328-36.5568-21.1968-32.3584-6.6048-16.6912-8.192-41.728 4.864-59.4432 8.192-11.52 1.536-20.8384 0-31.232 0-6.1952 0-24.064 13.0048-24.064 13.0048-35.4304-3.328 1.024-19.6608-17.7152-24.4736-7.3216-1.536-84.48 14.7456-83.4048 24.4736-12.4928-6.6048-15.616 60.4672-52.1728 29.3888 2.1504-14.7968 21.9648-45.8752 16.7424-50.7392-2.048-1.5872-10.3936 4.864-8.2944 11.4688-2.0992-6.656-31.232-19.6608-33.3312-6.656-1.024-4.8128-31.232-22.8864-27.136 0-7.3216-4.8128-46.9504 24.576-44.8512 29.3888-26.0608-13.0048-17.7152 1.536-25.088 29.3888 2.1504 4.864-7.2704 13.0048 2.1504 18.0736 2.0992 1.536 40.6528-14.7968 43.7248-18.0736 4.2496-16.384 19.8656 27.8016 16.7424 26.2144 4.1984 3.328 9.4208-6.6048 7.3216-11.4688 1.024 0 91.8016-4.864 91.8016-1.536 4.1984-1.5872 41.7792-8.192 40.6528-9.728 18.7392-9.9328 40.6528 6.5536 53.1456 0-3.072 4.8128 7.3216 4.8128 8.3456 9.728-1.024 0-4.2496 11.4176 0 13.0048-2.1504-1.536 19.8144-18.0736 17.7152-16.3328-2.0992 9.728 59.4432 6.656 62.5664 3.328-1.024 3.2768-3.072 13.0048 1.024 16.3328 0.9728 0 37.5296-21.248 38.5024-21.248 11.52-4.8128 46.9504 22.9888 53.1968 1.5872 16.6912 8.192 22.8864 1.536 34.4064 3.328 11.52 1.536 37.5808 18.0736 42.752 18.0736 17.7152 0 14.6432-26.2656 47.9744-18.0736 15.616 3.2768 49.0496 16.3328 50.0736 24.4736 1.024-42.5472 25.0368-31.0784 43.7248-18.0736l3.072-14.7456s34.5088 26.2144 32.3584 6.6048c0 0 2.1504 1.536 0 3.2768 20.992 3.6352 8.448-30.72 10.5472-43.776z m64.5632 35.9424l12.4928-8.192c-6.144-8.1408-10.3936-1.536-12.4928 8.192z m84.48-39.2704c-24.0128-14.7456-8.2944 31.1296-7.2704 29.3888 0 1.7408 29.184-16.3328 7.3216-29.3888z m-108.3904 26.2656c1.024-6.656 12.4928-39.2704 3.072-40.8576 0 1.536-3.072 13.056-3.072 14.7968-20.8384-14.7968-11.52 32.6656 9.4208 34.4064a20.992 20.992 0 0 0-9.4208-8.3456z m196.0448-14.7968c1.024-3.2768-38.5536 42.5984-33.3312 19.6608 10.3936 4.864-35.4816-4.864-17.7664-6.6048-5.1712 0-14.592-19.6608-20.7872-11.4688-32.3584 45.8752 39.6288 42.5472 51.0464 42.5472 0 3.328 18.8416 6.656 17.7152 9.728 16.7424 6.656 0-27.7504-5.2224-21.1968 1.024-1.536 1.024-8.192 2.1504-9.8816 0.9728 3.4816 28.1088-11.264 6.144-22.784z m-228.352 44.1344c0 6.656 0.9728 8.192 5.12 9.728l3.1232-9.728c-3.072-3.2768-6.144-3.2768-8.2944 0z m311.7568-39.2704c-6.2464-21.1968-1.024-13.0048-14.6432-24.4736 0 0-38.5536-19.6608-28.16 6.6048 2.1504 4.864 22.9376 6.6048 25.088 4.864-1.024 3.2768 9.3696 29.3376 5.1712 29.3376 20.9408 3.328 7.3216 3.328 12.544-16.3328z m-183.552 35.9936c-10.3936-4.864-15.616-26.2656-21.9136-27.8016-7.3216-3.328-22.9376 13.056-36.5568 6.6048 5.2224 3.2768 19.8144 16.3328 25.0368 14.7456 12.4928 4.864 27.136 13.056 39.6288 19.6608 25.1392-1.7408-3.072-42.5984-6.144-13.2096z" fill="#d81e06" p-id="19611"></path>
                        <path d="M1789.459456 970.5472c-3.072 10.752-6.2464 20.1216-8.192 32.256 14.336 6.656 20.6336-26.8288 8.192-32.256z m-482.2528 43.008c-4.1472-3.9424-7.2704-2.6624-10.3424 2.7648-1.0752 9.216 10.3424 9.216 10.3424-2.7136z m258.7136-15.7696c-3.072-1.8432-5.12-3.8912-8.192-5.6832l8.192 5.632zM1626.899456 101.376c-0.9728-7.9872-4.1472-9.4208-8.192-3.9936 1.024 7.9872 3.072 9.216 8.192 3.9936zM1793.555456 8.704c4.1472-2.7136 5.12-5.4272 0.9728-7.9872-4.096 1.28-5.0688 3.9936-1.024 7.9872z" fill="#d81e06" p-id="19612"></path>
                        <path d="M2206.432256 74.4448c5.1712-58.9824-32.1024-44.288-62.1056-42.9056-17.5616 0-78.6944-22.784-87.9104-3.9936-10.3424 0-52.736 5.4272-54.8352-2.6624-8.2432-3.9936-35.1744-1.28-48.6912-1.28-22.7328 0-44.544 2.6624-69.3248 3.9424-40.3456 0-85.9648-5.376-126.3104-2.6624-41.4208 2.6624-81.7664 0-125.184 1.28-22.7328 1.28-62.1056-10.752-82.7392-3.9936-1.024 0-39.3728 2.7136-42.4448 3.9936-19.6608 6.656-19.6608 17.408-37.2224 18.7904 0.9728 0-60.0064-28.2112-45.5168 1.28-1.024 0-43.4176-37.632-40.3456-18.7904-16.5888-6.7072-46.592 2.7136-65.1776 3.9936-10.2912 0-91.136-14.848-87.9104-3.9936-4.1472-1.28-45.4656 0-45.4656 1.28-17.6128-7.9872-49.664-2.7136-73.5744-1.28-7.2192 0-80.64-6.7072-79.6672 0-8.192-3.9936-98.3552 3.9936-100.352-2.7136 0 0-3.072-1.28 0-2.7136-9.3184-2.7136-70.2976 14.848-72.3968 3.9936-3.072-1.28-55.808 6.656-55.808-3.9936 0-13.4144-23.8592 1.28-18.5856 3.9936-8.2432 3.9936-71.4752-9.4208-73.5232 1.28 2.048 3.9936-53.8624-14.848-45.568-10.7008C664.902656 15.36 593.427456 22.016 591.379456 27.2896c0.9728 0 0.9728 1.28 2.048 1.28-14.4896-24.064-18.5344-1.28-24.832 1.28 0 0-82.7392-16.0768-80.64-6.656 2.048 1.2288-7.2704-2.7648 0-2.7648-9.3696-3.9936-8.2432 9.4208-10.3424 10.7008 2.048-7.9872-109.6704-9.4208-116.9408-10.7008C325.446656 16.4352 275.782656 37.888 242.707456 23.1424c-20.6848 9.4208-49.664-1.28-72.448 1.28-20.6336 1.28-45.5168 2.7136-65.1776 5.4272C87.571456 32.5632 69.907456 21.8624 50.297856 25.856c-31.0272 6.656-33.1264 9.4208-41.472 33.4848 0-1.28-1.024 38.912-7.2704 38.912 5.1712 0 5.1712 79.2064 6.144 73.7792 0 1.28 1.024 0 1.024 2.7136-11.4688-6.656-4.1984 45.568-1.024 33.4848 1.024 6.656 2.0992 22.784 2.0992 24.2176-2.048-5.4272-5.12 50.9952-1.024 34.9184 0 2.6624 1.024 0 1.024 1.28-12.3904-6.7072 8.2432 34.8672 8.2432 26.7776 0 3.9936-21.76 42.8544-10.3424 38.912-9.3184 36.1472 7.2704 72.3456 8.2432 91.136 1.024 13.4144-21.76 83.2-7.2192 99.328 2.048 3.9936-4.1984 75.0592-4.1984 79.2064 0 29.4912-4.1472 47.0016-3.072 76.4928 0 30.9248-3.072 87.1936 5.12 115.4048-8.192 20.0704-9.3184 44.288 0 57.7024-8.192 2.7136 2.1504 60.416 1.024 60.416-1.024 0-7.2192 61.696-5.12 65.6896 15.4624 30.8736 51.712 6.656 72.3968 14.7968 13.4144-6.656 22.7328-16.0768 42.3936-14.848 12.4416 1.3312 11.4688 14.848 31.0272 14.848-1.024 0 10.3424 0 9.3184 2.7136 12.4416 9.4208 4.1984-8.1408 9.3696-8.1408 23.808 9.4208 44.544 9.4208 68.2496 9.4208 19.6608 0 47.616-8.1408 66.2528-5.4272 12.4416 1.28 44.544 8.1408 54.8352 5.4272 7.2704 1.28 30.0032-3.9936 44.544-2.7136 3.072 0 48.64 0 47.616-5.4272 2.048 1.28 33.024 9.4208 33.024 8.1408 18.5856-10.7008 13.4144 2.7136 21.76 6.656 5.1712 2.7648 6.144-10.6496 5.1712-9.3696 4.1984-1.28 8.2432 10.7008 13.4144-1.28 1.024 0-2.048 0-1.024-1.28-3.072 1.28 37.2736 5.4272 27.9552 1.28 0 0 0-1.28 1.024-1.28-3.072 9.4208 51.712-3.9936 51.712 2.7136 0-1.28 102.4 6.656 101.4272-1.28 9.3696 3.9936 78.6944 9.3696 78.6944 5.4272 0 2.6624 8.2432-10.752 7.2704-22.8352 0-1.28-21.76-9.3696-21.76-10.6496-3.072-12.1344 36.2496-6.7072 37.2736-12.1344 3.072-9.4208-23.8592-20.0704-21.76-18.7904-13.4144-9.4208 0 12.0832-10.3424 9.3696-23.8592-5.376 3.072-6.656-9.3696-16.0768-7.2192-5.4272-7.2192 6.656-8.192 9.4208-3.072-12.1344-9.3696 9.3696-10.3424 9.3696 11.4176-20.0704-30.0032-1.28-25.856-3.9936 0 1.28-31.0784-24.064-26.9312 0-2.048 0-0.9728-1.28 0-1.28-19.6608-3.9936-37.2224 3.9936-54.784-2.6624-5.2224 2.6624-43.52-6.7072-46.592 1.28-7.3216-2.7136-45.568-5.4272-52.7872 2.6624-5.1712-5.376-9.3696-3.9424-11.4688 2.7136-17.5616-13.3632-39.3216-9.3696-51.712-1.28 4.1472-16.0768-20.6848-10.6496-18.5856-10.6496-13.4144-3.9936-2.0992 13.3632-18.5856 5.376 0-1.28 4.1472-9.3696 0-12.0832-3.072-1.28-29.0304 14.848-36.2496 16.0768-16.64 2.7136-15.5136-2.7136-27.9552 1.28 0 0-38.2464-22.784-35.1744-8.0896-31.0784-13.4144-86.8864 1.28-126.2592-2.7136a272.896 272.896 0 0 0-73.5232 1.28c-11.4176 2.7136-24.832 1.28-34.2016 8.0896 1.024-1.28-30.0032 24.064-20.6336 28.2112-2.048-6.656-14.4896-5.376-16.5888-8.0896 1.024 3.9936 4.1472-72.3968-9.3696-26.7776-2.048-6.7072 17.6128 5.376-8.192-5.4272l-6.144-24.064c2.048 1.28 15.4624-37.632 3.072-33.4848 11.3664-47.0528 4.096-111.4112 4.096-155.5968 0-18.7904 3.072-185.0368 2.1504-185.0368-2.0992 5.376-1.024-61.696-1.024-60.416-7.2192-41.6256-22.7328-6.7072-32.1024-24.064-0.9728 0 12.4416-67.1232 12.4416-67.1232 0 1.28-1.024 0 0 0 4.1984-18.7904 8.2432-28.2112 11.4176-40.192 1.024-2.7136 7.2704-30.9248 8.2432-30.9248 10.3424 0 1.024-22.784-3.072-24.064 7.2704-16.0768-1.024-32.2048 0-36.1984-7.2704-32.2048 7.2704-69.7856 5.1712-107.264-1.024-13.4144-13.4144-32.2048-7.2704-47.0016 4.1984-12.1344 27.9552-12.1344 27.9552-24.064l7.2192 17.3568c4.1984 2.7136 8.2432-5.4272 7.2704-9.4208 16.5888 7.9872 51.712-1.28 70.3488-1.28 23.808 0 36.2496 3.9936 48.64 10.7008-0.9728 0 49.664-18.7904 50.688-10.7008 14.5408 5.4272 13.4144-3.9936 19.6608-3.9936-4.1472 5.4272 35.1744 1.28 35.1744 7.9872 0 6.656 42.4448-3.9936 47.616-5.4272 19.6608-1.28 37.2224 1.28 45.4656 10.7008 5.1712 6.656 19.712-14.848 17.6128-13.4144-6.144 21.504 64.1536-1.28 67.2768-1.28 13.3632-1.28 51.712 1.28 60.0064 3.9936 8.192-3.9936 21.76 0 25.8048-2.7136-2.048 6.7072 68.2496 0 56.9344-6.656 7.2704-3.9936 24.832 14.7968 34.2016 16.0768 16.5888 1.28 21.76-7.9872 27.904-10.7008-5.1712 18.8416 35.1744-2.6624 27.904 0 2.048-3.9936 70.3488-1.28 72.448 0 9.3184-2.6624 78.6944 12.1344 78.6944 5.4272 0 2.7136 23.808 13.4144 21.76-3.9936 15.4624 5.4272 152.064-2.7136 154.1632 1.28 14.4896 7.9872 152.064 0 152.064 2.7136 0 1.28 33.1264 21.504 27.9552-1.28h1.024c4.1472 13.4144 34.1504 2.7136 38.1952-2.7136 14.5408-7.9872 38.2464 14.848 52.736 3.9936 0 0 25.856-42.8544 24.8832-44.288-1.024 0 10.3424 14.848 13.4144 1.28 81.7664 42.8544-1.024 1.28 9.3184 3.9936 0 1.28 0 1.28 1.024 1.28-6.2976 6.656 22.7328 41.5744 30.0032 42.8544 0 0 23.808-30.9248 23.808-17.408 0 26.8288 86.9376 13.4144 78.6944 0 20.6848-1.2288 34.2016 17.408 56.9344 14.848 6.144-1.28 29.0304-9.3696 24.832-10.6496 3.072-1.3312 6.2976 3.9424 9.3696 2.6624-1.024 3.9936-4.1984 12.1344 1.024 14.848 3.072 1.28 23.808-13.4144 17.5616-17.408 13.3632-5.376 44.4928 29.4912 53.8112 2.7136-2.048-1.28 29.0304 13.4144 25.856 1.28 4.1472 1.28 35.1744 3.9936 26.9312 0 0.9728 0 0 0 3.072-2.7136-3.072 10.7008 23.8592-3.9936 27.904 2.7136-1.024 0-3.072 9.4208 0 10.7008 2.048 1.28 16.5888-13.4144 18.5856-14.848-3.072 9.4208 14.4896 2.7136 14.4896 9.4208 0 9.4208 44.544-3.9936 49.664-12.0832 4.1984 2.7136 48.6912 20.0704 54.8352 3.9936-2.048-1.28-2.048-1.28 0-2.7136-5.12 14.848 34.2016 5.376 27.9552 2.7136 6.144 1.28 18.5344 10.6496 23.808 1.28-2.048 0-0.9728 0 1.024-1.28-1.024 2.6624 38.2464 26.7776 36.2496 5.376 18.688 7.9872 50.688 1.28 65.1776-6.656-4.1984 12.0832 54.8352 3.9424 52.736 3.9424 1.024 0 46.592 1.28 45.568-1.28 36.1984 16.128 20.6336 111.4112 21.7088 151.6032 1.024 50.9952 1.024 104.6016 1.024 154.3168 0 41.5744-7.2704 84.48-7.2704 126.0544 0 26.7776 7.2192 50.9952 7.2192 72.3968 0 6.656 2.0992 53.7088 4.1984 48.2816-1.024-1.28 0 30.9248 1.024 34.9184-12.4416-8.1408-7.2704 49.5616-2.1504 30.9248 0 2.7136 1.024 1.28 2.0992 5.4272-11.4176-6.7072-7.2192 50.9952-2.048 30.8736 0.9728 3.9936 0.9728 0 2.048 5.4272-3.072-3.9936-13.4144 25.4976-5.12 33.4848 0.9728-3.9936 2.048-2.7136 3.072 1.28-7.2704-5.4272-13.4144 40.192-3.072 34.9184-13.4656 33.4848 8.192 93.8496 3.072 113.9712 7.2192 44.288-40.3456-2.7136-40.3456 22.784-23.8592 2.7136-54.8352-3.9936-81.7664-6.656-8.2432-1.3312-30.0032 7.936-37.2736 7.936-7.2704 0-47.616 0-44.544 1.28-30.976 16.128-70.2976-37.5808-41.4208 26.7776-9.3184-5.4272-0.9728 21.504 2.0992 12.1344 0 1.28 1.024 2.7136 2.0992 3.9936-8.2432-3.9936 26.9312 36.1984 32.1024 12.0832 1.024 2.7136 0 2.7136 2.048 3.9936-5.12-2.7136-6.144 7.9872-2.048 10.7008 2.048 1.28 7.2192-7.9872 4.1472-9.4208 14.5408 2.7136 5.1712-1.28 15.5136-8.0896 8.2432 2.6624 18.688 13.3632 26.9312 14.7968 3.072 0 35.1744-5.4272 32.1024-6.656 5.12-1.3312 58.9824-5.4784 58.9824-10.752 6.144 5.4272 23.8592 14.848 26.9312 3.9936 5.1712 16.128 44.544-1.28 51.7632-1.28 3.072 0 14.5408 1.28 17.6128 0-10.3424 5.4272 49.664-10.6496 15.4624-14.7968 0-21.504-5.12-224.1024 0-225.3824v-1.28c4.1984-1.28-3.072-79.2064 5.1712-79.2064-0.9728-2.7136 6.144-20.1216-6.2464-16.128v-1.28 1.28c-2.048-18.7904 6.2464-221.3888-1.024-221.3888 3.072 0 0-151.552 0-162.304 0-8.0896 6.2976-191.8464 9.3696-190.464-1.024-2.816-2.9696-8.0896-8.192-9.5232z" fill="#d81e06" p-id="19613"></path>
                        <path d="M1062.931456 532.8896c-9.5744-5.7344 5.2736 15.4112 3.1232 13.568 2.1504-7.7824 0-11.6736-3.1232-13.568z m156.8256 30.8224c-1.024-5.7344-8.448-3.9424-10.5984 0-4.2496 13.5168 22.3232 34.6624 25.4464 9.6256-4.2496-3.6864-9.5744-5.7344-14.848-9.6256z m-55.04-50.3296c8.448-42.496-10.5984 3.9424-7.4752 5.7856 4.1984 4.096 6.3488 2.048 7.4752-5.7856z m194.9696 46.3872c6.4512-32.8192-13.7216-67.6864-21.1456-73.472-5.3248-3.8912-56.1664 1.8432-58.368 9.6768 0 0 29.7472 63.7952 29.7472 75.3152 0 21.3504 21.1968-48.2304 22.3232-50.2784 5.2736 13.5168 10.5472 19.3024 14.848 11.6736-10.5984 38.6048 10.5984 69.632 18.0224 38.6048 1.024-7.5776-1.1264-11.52-5.4272-11.52z m-449.4336 19.5072l4.4544 13.568c3.072-7.7824 0-11.6736-4.4544-13.568z" fill="#d81e06" p-id="19614"></path>
                        <path d="M559.942656 362.5984H463.072256V304.5888h96.8704V235.8784h67.072c4.8128 0 8.1408 0.3584 9.8304 1.1264s2.56 2.048 2.56 3.9424a35.84 35.84 0 0 1-2.304 9.5744c-4.5056 12.8-6.7584 30.7712-6.7584 54.0672h113.2032v58.0096h-113.152v54.0672h148.6336V474.112h-81.1008v46.7456h65.3312v60.2624h-65.3312v114.8928c0 16.5376-2.816 29.0816-8.448 37.7344-5.632 8.6528-16.3328 15.3088-32.1024 19.968-15.7696 4.7104-39.7824 8.192-72.0896 10.4448a160.768 160.768 0 0 0-24.2176-74.9056c24.064 2.6112 40.2944 3.9424 48.7424 3.9424 8.448 0 13.824-1.2288 16.3328-3.6864 2.4064-2.4064 3.6352-7.0144 3.6352-13.7728V581.12h-87.8592c16.128 27.8016 30.208 55.552 42.24 83.3536l-64.768 25.9072a413.4912 413.4912 0 0 0-39.936-87.296l52.8896-21.9648H437.779456v-60.2624H629.779456V474.112H434.349056v-36.608l-33.2288 43.3664v277.6576h-68.096v-202.1888c-15.0528 15.0016-28.416 27.392-40.0384 37.1712a238.4896 238.4896 0 0 0-45.568-54.0672c28.16-16.128 56.576-40.96 85.2992-74.3424a552.6528 552.6528 0 0 0 73.472-109.824c40.96 21.4016 62.6176 32.6656 65.024 33.792 2.4576 1.1264 3.6864 3.4816 3.6864 7.0656s-2.56 7.0144-7.5776 10.3936a175.7696 175.7696 0 0 0-13.824 10.1376h106.496V362.5984z m-180.224-125.5936l62.5152 36.608c5.632 3.3792 8.448 6.8608 8.448 10.4448 0 3.584-3.84 7.0144-11.52 10.3936-7.68 3.3792-22.3744 18.4832-43.9296 45.312-21.6064 26.88-51.5584 56.9856-89.856 90.4192-10.1376-12.3904-27.5968-27.392-52.3776-45.056 51.456-35.328 93.696-84.6848 126.72-148.1216z m659.5072 47.3088c-4.096-15.36-9.216-29.8496-15.2064-43.3664l91.2384-15.2064c3.7376 18.432 7.168 37.888 10.1376 58.5728h205.0048v114.3296H1254.419456V346.8288h-346.368v51.8144h-74.3424V284.3136h205.568z m-86.1696 357.632v28.16h-70.9632V405.9648h163.328v-50.688h68.1472c9.0112 0 13.5168 1.536 13.5168 4.5056a23.6032 23.6032 0 0 1-2.2528 9.5744c-1.536 3.3792-2.9184 8.8064-4.1984 16.3328a118.784 118.784 0 0 0-1.9968 20.2752h167.8336v258.5088h-73.216v-22.528h-95.744v121.088h-72.0896v-121.088h-92.3648z m92.3648-177.9712h-92.3648v36.0448h92.3648v-36.0448z m167.8336 36.0448v-36.0448h-95.744v36.0448h95.744z m0 89.5488v-36.0448h-95.744v36.0448h95.744z m-260.1984-36.0448v36.0448h92.3648v-36.0448h-92.3648z m747.3664-250.0608a241.664 241.664 0 0 0-21.9648-58.0096l85.0432-14.08c5.9904 16.5376 11.6224 40.5504 16.896 72.0896h121.6512v60.8256h-154.88c-23.6544 33.024-44.1344 61.3888-61.3888 85.0432 12.8-0.768 32.256-2.4576 58.5728-5.0688 16.128-20.6336 29.696-41.1136 40.5504-61.3888l60.2624 30.976c5.632 3.0208 8.448 6.1952 8.448 9.5744s-2.6112 6.9632-7.8848 10.7008a178.5856 178.5856 0 0 0-37.7344 37.7344c-24.4224 30.7712-55.1936 62.3104-92.3648 94.6176a676.6592 676.6592 0 0 1-113.152 80.5376 239.5648 239.5648 0 0 0-49.6128-47.872c48.7936-22.528 95.9488-55.552 141.3632-99.1232-34.1504 3.3792-63.6416 7.68-88.4224 12.9536l-17.408-62.5152c18.3296-5.632 32.9728-16.7936 43.8784-33.536 10.9056-16.6912 20.6336-34.2528 29.2864-52.6336h-65.3312v47.3088H1536.531456v36.608l30.4128-13.5168c18.432 37.1712 33.28 71.3216 44.544 102.5024l-53.5552 20.8384c-2.6112-12.032-9.728-31.8976-21.4016-59.6992v260.7616h-64.2048V524.8c-18.0224 49.5616-35.84 86.7328-53.504 111.5136a324.352 324.352 0 0 0-47.872-52.3776 407.6544 407.6544 0 0 0 46.7456-76.5952c11.264-24.7808 22.016-56.6784 32.1024-95.744h-58.0096V346.2656h80.5376V243.7632H1530.899456c8.2432 0 12.3904 1.6896 12.3904 5.0688a33.28 33.28 0 0 1-2.2528 11.264c-3.0208 8.2432-4.5056 22.7328-4.5056 43.3664v42.8032h43.3664v-42.8032h120.5248z m58.0096 359.8848c-39.424 32.256-93.1328 64.9728-161.0752 97.9968a530.944 530.944 0 0 0-52.3776-59.6992c55.1936-15.36 110.08-44.9536 164.7616-88.6784 54.6304-43.776 95.6416-89.856 123.0336-138.2912 31.1808 18.432 50.176 30.208 57.1904 35.4816 6.912 5.2736 10.3936 9.3696 10.3936 12.3904 0 4.096-3.584 8.0896-10.7008 11.8272-7.168 3.7376-19.6096 15.9744-37.4272 36.608-17.8688 20.6336-32.256 36.0448-43.1104 46.1824a1078.7328 1078.7328 0 0 1 97.4336 94.0544l-64.2048 44.4928a770.8672 770.8672 0 0 0-83.9168-92.3648z" fill="#d81e06" p-id="19615"></path>
                    </svg>
                    {/if}
                    {if $vo['top']==1}
                    <svg t="1602826160384" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="35370" width="20" height="20">
                        <path d="M847.030961 65.290005 176.966992 65.290005c-61.683874 0-111.677499 49.992601-111.677499 111.677499l0 670.063969c0 61.684898 49.992601 111.678522 111.677499 111.678522l670.063969 0c61.683874 0 111.678522-49.992601 111.678522-111.678522L958.709483 176.967504C958.709483 115.282606 908.715859 65.290005 847.030961 65.290005zM434.99365 228.704842l363.875404 0 0 73.131601L641.614521 301.836443l-10.69662 57.060577 151.34187 0 0 271.715425-79.710436 0L702.549336 430.247045 518.857686 430.247045l0 204.527187-79.675644 0L439.182043 358.89702l102.272291 0 10.679223-57.060577L434.99365 301.836443 434.99365 228.704842zM373.188003 683.528632c0 24.167422-4.223185 43.293015-12.651135 57.365522-8.42795 14.07353-19.839861 22.903639-34.323737 26.462698-14.44806 3.576455-46.991244 5.339612-97.508801 5.339612-2.791579-23.774473-7.328919-49.539276-13.644765-77.284177 18.216897 1.989307 36.016285 2.966565 53.465702 2.966565 15.879666 0 23.783683-8.699126 23.783683-26.148543L292.308951 316.694849l-76.079746 0 0-81.445964 209.865775 0 0 81.445964-52.906977 0L373.188003 683.528632zM758.475066 792.921088c-39.663348-32.893154-89.289606-70.654176-148.933007-113.248274-26.786063 44.583404-82.361823 83.122139-166.81733 115.620297-12.267395-23.382547-28.14706-49.13814-47.550992-77.283154 42.787502-11.691273 78.435397-26.960025 106.879216-45.778626 28.442796-18.819624 47.254234-44.627407 56.501852-77.432557 9.195429-32.806173 13.820774-75.364455 13.820774-127.687124l78.486562 0c0 58.063417-4.674463 106.328677-13.95892 144.770198 55.874565 35.282574 113.24725 74.221422 172.087357 116.825752L758.475066 792.921088z" p-id="35371" fill="#d4237a"></path>
                    </svg>
                    {/if}
                    {if $vo['cover']}
                    <svg t="1602825819135" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="31699" width="20" height="20">
                        <path d="M829.64898 849.502041H194.35102c-43.885714 0-79.412245-35.526531-79.412244-79.412245V253.910204c0-43.885714 35.526531-79.412245 79.412244-79.412245h635.29796c43.885714 0 79.412245 35.526531 79.412244 79.412245v516.179592c0 43.885714-35.526531 79.412245-79.412244 79.412245z" fill="#D2F4FF" p-id="31700"></path>
                        <path d="M909.061224 656.195918l-39.706122-48.065306L626.416327 365.714286c-19.330612-19.330612-50.677551-19.330612-70.008164 0L419.526531 502.073469c-2.612245 2.612245-5.22449 3.134694-6.791837 3.134694-1.567347 0-4.702041-0.522449-6.791837-3.134694L368.326531 464.979592c-19.330612-19.330612-50.677551-19.330612-70.008164 0l-143.673469 143.673469-39.706122 48.065306v113.893878c0 43.885714 35.526531 79.412245 79.412244 79.412245h635.29796c43.885714 0 79.412245-35.526531 79.412244-79.412245v-114.416327" fill="#16C4AF" p-id="31701"></path>
                        <path d="M273.763265 313.469388m-49.632653 0a49.632653 49.632653 0 1 0 99.265306 0 49.632653 49.632653 0 1 0-99.265306 0Z" fill="#E5404F" p-id="31702"></path>
                        <path d="M644.179592 768h-365.714286c-11.493878 0-20.897959-9.404082-20.897959-20.897959s9.404082-20.897959 20.897959-20.897959h365.714286c11.493878 0 20.897959 9.404082 20.897959 20.897959s-9.404082 20.897959-20.897959 20.897959zM461.322449 670.82449h-182.857143c-11.493878 0-20.897959-9.404082-20.897959-20.897959s9.404082-20.897959 20.897959-20.89796h182.857143c11.493878 0 20.897959 9.404082 20.897959 20.89796s-9.404082 20.897959-20.897959 20.897959z" fill="#0B9682" p-id="31703"></path>
                    </svg>
                    {/if}
                    {if $vo['redirect_uri']}
                    <svg t="1602815375380" class="icon" viewBox="0 0 1638 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="20186" width="20" height="20">
                        <path d="M768 716.8h-51.2v-102.4h51.2a256 256 0 0 0 0-512H358.4a256 256 0 0 0 0 512h51.2v102.4H358.4A358.4 358.4 0 0 1 358.4 0h409.6a358.4 358.4 0 0 1 0 716.8z" fill="#54C3F1" p-id="20187"></path>
                        <path d="M1280 1024h-409.6a358.4 358.4 0 0 1 0-716.8h51.2v102.4h-51.2a256 256 0 0 0 0 512h409.6a256 256 0 0 0 0-512h-51.2V307.2h51.2a358.4 358.4 0 0 1 0 716.8z" fill="#54C3F1" p-id="20188"></path>
                    </svg>
                    {/if}
                    <a href="{:$router->buildUrl('/ebcms/cms/web/content', ['id'=>$vo['alias']?:$vo['id']])}" target="_blank">
                        <span>{$vo.title}</span>
                    </a>
                </td>
                <td>{$vo.click}</td>
                <td class="text-nowrap">
                    <a href="{:$router->buildUrl('/ebcms/cms/admin/content/update', ['id'=>$vo['id']])}">编辑</a>
                    <a href="{:$router->buildUrl('/ebcms/cms/admin/content/create', ['category_id'=>$vo['category_id'], 'copyfrom'=>$vo['id']])}">复制</a>
                </td>
            </tr>
            {/foreach}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <form>
                        <div class="form-row align-items-center">
                            <div class="col-auto my-1 ml-1">
                                <button class="btn btn-light" type="button" id="fanxuan">全选/反选</button>
                            </div>
                            <div class="col-auto my-1">
                                <label class="mr-sm-2 sr-only" for="inlinestate">状态变更</label>
                                <select class="custom-select mr-sm-2" id="inlinestate">
                                    <option value="-1" selected>设置为...</option>
                                    <option value="1">通过审核</option>
                                    <option value="2">待审</option>
                                </select>
                            </div>
                            <div class="col-auto my-1">
                                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">移动</label>
                                {function test($datas, $pid=0, $level=0)}
                                {foreach $datas as $vo}
                                {if $vo['pid']==$pid}
                                {if $vo['type']=='channel'}
                                <option value="{$vo.id}" disabled>{:str_repeat('&nbsp;&nbsp;&nbsp;', $level)}▼ {$vo.title}</option>
                                {elseif $vo['type']=='list'}
                                <option value="{$vo.id}">{:str_repeat('&nbsp;&nbsp;&nbsp;', $level)}┣ {$vo.title}</option>
                                {else}
                                <!-- <option value="{$vo.id}" disabled>{:str_repeat('&nbsp;&nbsp;&nbsp;', $level)}┣ {$vo.title}</option> -->
                                {/if}
                                {:test($datas, $vo['id'], $level+1)}
                                {/if}
                                {/foreach}
                                {/function}
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                    <option value="-1" selected>移动到...</option>
                                    {:test($categorys)}
                                </select>
                            </div>
                            <div class="col-auto my-1">
                                <label class="mr-sm-2 sr-only" for="inline_fragment">推送</label>
                                <select class="custom-select mr-sm-2" id="inline_fragment">
                                    <option value="" selected>推送到...</option>
                                    {foreach $fragments as $group=>$items}
                                    <optgroup label="{$group}">
                                        {foreach $items as $item}
                                        {if $item['type']=='content'}
                                        <option value="{$item.id}">┣ {$item.title}</option>
                                        {/if}
                                        {/foreach}
                                    </optgroup>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="col-auto my-1">
                                <button type="button" class="btn btn-warning" id="delete">删除</button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<nav class="my-3">
    <ul class="pagination">
        {foreach $pagination as $v}
        {if $v=='...'}
        <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">{$v}</a></li>
        {elseif isset($v['current'])}
        <li class="page-item active"><a class="page-link" href="javascript:void(0);">{$v.page}</a></li>
        {else}
        <li class="page-item"><a class="page-link" href="{:$router->buildUrl('/ebcms/cms/admin/content/index', array_merge($_GET, ['page'=>$v['page']]))}">{$v.page}</a></li>
        {/if}
        {/foreach}
    </ul>
</nav>
<script>
    $(document).ready(function() {
        $("#fanxuan").on("click", function() {
            $("#tablexx td :checkbox").each(function() {
                $(this).prop("checked", !$(this).prop("checked"));
            });
        });
        $("#delete").bind('click', function() {
            if (confirm('确定删除吗？删除后不可恢复！')) {
                var ids = [];
                $.each($('#tablexx input:checkbox:checked'), function() {
                    ids.push($(this).val());
                });
                $.ajax({
                    type: "POST",
                    url: "{:$router->buildUrl('/ebcms/cms/admin/content/delete')}",
                    data: {
                        ids: ids
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.code) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        });
        $("#inlineFormCustomSelect").bind('change', function() {
            var category_id = $(this).val();
            if (category_id >= 0) {
                if (confirm('确定移动吗？若字段不一样会造成数据错乱！')) {
                    var ids = [];
                    $.each($('#tablexx input:checkbox:checked'), function() {
                        ids.push($(this).val());
                    });
                    $.ajax({
                        type: "POST",
                        url: "{:$router->buildUrl('/ebcms/cms/admin/content/move')}",
                        data: {
                            ids: ids,
                            category_id: category_id,
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.code) {
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }
            }
        });
        $("#inline_fragment").bind('change', function() {
            var fragment_id = $(this).val();
            if (fragment_id) {
                if (confirm('确定推送吗？')) {
                    var ids = [];
                    $.each($('#tablexx input:checkbox:checked'), function() {
                        ids.push($(this).val());
                    });
                    $.ajax({
                        type: "POST",
                        url: "{:$router->buildUrl('/ebcms/cms/admin/content/fragment')}",
                        data: {
                            ids: ids,
                            fragment_id: fragment_id,
                        },
                        dataType: "JSON",
                        success: function(response) {
                            alert(response.message);
                            if (response.code) {
                                location.reload();
                            }
                        }
                    });
                }
            }
        });
        $("#inlinestate").bind('change', function() {
            var state = $(this).val();
            if (state >= 0) {
                var ids = [];
                $.each($('#tablexx input:checkbox:checked'), function() {
                    ids.push($(this).val());
                });
                $.ajax({
                    type: "POST",
                    url: "{:$router->buildUrl('/ebcms/cms/admin/content/state')}",
                    data: {
                        ids: ids,
                        state: state,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.code) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        });
    });
</script>
{include common/footer@ebcms/admin}