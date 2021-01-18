{include web/common/header@ebcms/cms}
<div class="row">
    <div class="col-md-9">
        {include web/common/nav@ebcms/cms}
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