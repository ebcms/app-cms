<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Category;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Category;
use Ebcms\Router;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Hidden;
use Ebcms\FormBuilder\Field\Number;
use Ebcms\FormBuilder\Field\Radio;
use Ebcms\FormBuilder\Field\Select;
use Ebcms\FormBuilder\Field\Text;
use Ebcms\FormBuilder\Field\Textarea;
use Ebcms\FormBuilder\Field\Url;
use Ebcms\FormBuilder\Other\Summernote;
use Ebcms\FormBuilder\Row;
use Ebcms\FormBuilder\Summary;
use Ebcms\RequestFilter;

class Create extends Common
{
    public function get(
        Router $router,
        Category $categoryModel,
        RequestFilter $input
    ) {
        $type = $input->get('type');

        $form = new Builder('创建栏目');
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Hidden('type', $input->get('type'))),
                    (new Select('上级栏目', 'pid', 0, (function () use ($categoryModel): array {
                        $getsub = function ($datas, $pid = 0, $level = 0) use (&$getsub) {
                            $res = [];
                            foreach ($datas as $value) {
                                if ($value['pid'] == $pid) {
                                    $res[] = [
                                        'label' => str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . '├&nbsp;' . $value['title'],
                                        'value' => $value['id'],
                                    ];
                                    foreach ($getsub($datas, $value['id'], $level + 1) as $v) {
                                        $res[] = $v;
                                    }
                                }
                            }
                            return $res;
                        };
                        $lavel = $getsub($categoryModel->select('*', [
                            'type' => 'channel',
                            'ORDER' => [
                                'priority' => 'DESC',
                                'id' => 'ASC'
                            ]
                        ]));
                        return array_merge([['label' => '顶级栏目', 'value' => 0]], $lavel);
                    })()))->set('inline', true),
                    (new Text('标题', 'title'))->set('help', '一般不超过20个字符')->set('required', 1),
                    ...(function () use ($type, $router): array {
                        $res = [];
                        switch ($type) {
                            case 'channel':
                                $res[] = (new Text('频道模板', 'tpl_category'));
                                break;
                            case 'list':
                                $res[] = (new Textarea('筛选项设置', 'filters'))->set('help', '用空格分割');
                                $res[] = (new Textarea('扩展字段设置', 'fields'))->set('help', '用空格分割');
                                $res[] = new Text('栏目模板', 'tpl_category');
                                $res[] = new Text('内容模板', 'tpl_content');
                                $res[] = new Number('栏目分页大小', 'page_num', '20', 1, 500);
                                break;
                            case 'page':
                                $res[] = (new Summernote('内容', 'body', '', $router->buildUrl('/ebcms/admin/upload')))->set('help', '一般用于单页面显示');
                                $res[] = (new Text('渲染模板', 'tpl_category'));
                                break;

                            default:
                                # code...
                                break;
                        }
                        return $res;
                    })()
                ),
                (new Col('col-md-3'))->addItem(
                    (new Text('别名', 'alias'))->set('help', '一般用英文'),
                    (new Radio('是否发布', 'state', 1, [
                        [
                            'label' => '是',
                            'value' => 1,
                        ], [
                            'label' => '否',
                            'value' => 2,
                        ],
                    ]))->set('inline', true),
                    (new Radio('导航显示', 'nav', 1, [
                        [
                            'label' => '是',
                            'value' => 1,
                        ], [
                            'label' => '否',
                            'value' => 0,
                        ],
                    ]))->set('inline', true),
                    (new Summary('元数据设置'))->addItem(
                        new Text('关键词', 'keywords'),
                        new Textarea('简介', 'description')
                    ),
                    (new Summary('其他参数设置'))->addItem(
                        (new Url('重定向地址', 'redirect_uri'))
                    )
                )
            )
        );
        return $form;
    }

    public function post(
        RequestFilter $input,
        Category $categoryModel
    ) {
        $categoryModel->insert([
            'pid' => $input->post('pid'),
            'type' => $input->post('type'),
            'title' => $input->post('title'),
            'filters' => $input->post('filters'),
            'fields' => $input->post('fields'),
            'body' => $input->post('body'),
            'state' => $input->post('state'),
            'nav' => $input->post('nav'),
            'priority' => 0,
            'redirect_uri' => $input->post('redirect_uri'),
            'keywords' => $input->post('keywords'),
            'description' => $input->post('description'),
            'tpl_category' => $input->post('tpl_category'),
            'tpl_content' => $input->post('tpl_content'),
            'alias' => $input->post('alias'),
            'page_num' => $input->post('page_num'),
        ]);
        return $this->success('操作成功！', 'javascript:history.go(-2)');
    }
}
