<?php
return [
    'lunbo' => [
        'type' => 'content',
        'title' => '轮播',
        'template' => (function () {
            $template = <<<'str'
{php $contents = array_slice($contents, 0, 6)}
<div id="frament_{:md5($fragment['id'])}" class="carousel slide mb-3" data-ride="carousel">
    <ol class="carousel-indicators">
        {foreach $contents as $key=>$vo}
        <li data-target="#frament_{:md5($fragment['id'])}" data-slide-to="{$key}" class="{$key==0?'active':''}"></li>
        {/foreach}
    </ol>
    <div class="carousel-inner bg-dark">
        {foreach $contents as $key=>$vo}
        <div class="carousel-item {$key==0?'active':''}">
            <a href="{$vo.redirect_uri}" target="_blank">
                <img src="{$vo.cover}" class="d-block w-100" alt="{$vo.title}">
                <div class="carousel-caption d-none d-md-block">
                    <h5>{$vo.title}</h5>
                    <p>{$vo.description}</p>
                </div>
            </a>
        </div>
        {/foreach}
    </div>
</div>
str;
            return htmlspecialchars($template);
        })(),
    ],
    'product' => [
        'type' => 'content',
        'title' => '产品滚动',
        'template' => (function () {
            $template = <<<'str'
<div class="card mb-3 bg-light">
    <div class="card-header">{$fragment['title']}</div>
    <div class="card-body">
        <marquee direction="left" behavior="alternate" scrollamoun="1" scrolldelay="50" onMouseOver="this.stop()" onMouseOut="this.start()">
            <ul class="list-inline my-0" style="word-spacing: nowarp;">
                {foreach $contents as $vo}
                <li class="list-inline-item">
                    <a href="{$vo.redirect_uri}" class="text-decoration-none"><img src="{$vo.cover}" class="img-thumbnail" style="width:200px;height:150px;" alt="{$vo.title}">
                    <div class="py-2 text-truncate" style="max-width:180px;">{$vo['title']}</div></a>
                </li>
                {/foreach}
            </ul>
        </marquee>
    </div>
</div>
str;
            return htmlspecialchars($template);
        })(),
    ],
    'toutiao' => [
        'type' => 'content',
        'title' => '首页：头条',
        'template' => (function () {
            $template = <<<'str'
{php $contents = array_slice($contents, 0, 11)}
<div class="card mb-3 bg-light">
    <div class="card-body">
        {if $contents}
        <div class="text-center position-relative mb-4 mt-3">
            <div class="h1 mb-4 text-danger text-nowrap text-truncate">{$contents[0]['title']}</div>
            <div text-nowrap text-truncate>{$contents[0]['description']} <a href="{$contents[0]['redirect_uri']}" class="stretched-link">[详情]</a></div>
        </div>
        <hr>
        {php unset($contents[0])}
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled mb-0">
                    {foreach $contents as $k => $vo}
                    {if $k%2 == 1}
                    <li class="py-1 text-nowrap text-truncate">
                        <a class="text-decoration-none" href="{$vo.redirect_uri}">▪ {$vo.title}</a>
                    </li>
                    {/if}
                    {/foreach}
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled mb-0">
                    {foreach $contents as $k => $vo}
                    {if $k%2 == 0}
                    <li class="py-1 text-nowrap text-truncate">
                        <a class="text-decoration-none" href="{$vo.redirect_uri}">▪ {$vo.title}</a>
                    </li>
                    {/if}
                    {/foreach}
                </ul>
            </div>
        </div>
        {/if}
    </div>
</div>
str;
            return htmlspecialchars($template);
        })(),
    ],
    'zuixin' => [
        'type' => 'template',
        'title' => '最新发布',
        'template' => (function () {
            $template = <<<'str'
<div class="card mb-3 bg-light">
    <div class="card-header">{$fragment['title']}</div>
    <div class="list-group list-group-flush">
        {php $contents = $content_model->select('*', ['LIMIT'=>10,'ORDER'=>['id'=>'DESC']])}
        {foreach $contents as $vo}
        <a class="list-group-item list-group-item-action text-nowrap text-truncate" href="{:$router->buildUrl('/ebcms/cms/web/content', ['id'=>$vo['alias']?:$vo['id']])}">▪ {$vo.title}</a>
        {/foreach}
    </div>
</div>
str;
            return htmlspecialchars($template);
        })(),
    ],
];
