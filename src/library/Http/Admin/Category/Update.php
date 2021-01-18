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
use Ebcms\Xss;

class Update extends Common
{
    public function get(
        Router $router,
        Category $categoryModel,
        RequestFilter $input
    ) {
        $data = $categoryModel->get('*', [
            'id' => $input->get('id', 0, ['intval']),
        ]);

        $form = new Builder('更新栏目');
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Hidden('id', $data['id'])),
                    (new Select('上级栏目', 'pid', $data['pid'], (function () use ($categoryModel, $data): array {
                        $getsub = function ($datas, $pid = 0, $level = 0, $thisid = -1) use (&$getsub) {
                            $res = [];
                            foreach ($datas as $value) {
                                if ($value['pid'] == $pid) {
                                    $res[] = [
                                        'label' => str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . '├&nbsp;' . $value['title'],
                                        'value' => $value['id'],
                                        'disabled' => $value['id'] == $thisid,
                                    ];
                                    foreach ($getsub($datas, $value['id'], $level + 1, $thisid) as $v) {
                                        $res[] = $v;
                                    }
                                }
                            }
                            return $res;
                        };
                        $level = $getsub($categoryModel->select('*', [
                            'type' => 'channel',
                            'ORDER' => [
                                'priority' => 'DESC',
                                'id' => 'ASC'
                            ]
                        ]), 0, 0, $data['id']);
                        return array_merge([['label' => '顶级栏目', 'value' => 0]], $level);
                    })()))->set('inline', true),
                    (new Text('标题', 'title', $data['title']))->set('help', '一般不超过20个字符')->set('required', 1),
                    ...(function () use ($data, $router): array {
                        $res = [];
                        switch ($data['type']) {
                            case 'channel':
                                $res[] = new Text('频道模板', 'tpl_category', $data['tpl_category']);
                                break;
                            case 'list':
                                $res[] = (new Textarea('筛选项设置', 'filters', $data['filters']))->set('help', '用空格分割');
                                $res[] = (new Textarea('扩展字段设置', 'fields', $data['fields']))->set('help', '用空格分割');
                                $res[] = new Text('栏目模板', 'tpl_category', $data['tpl_category']);
                                $res[] = new Text('内容模板', 'tpl_content', $data['tpl_content']);
                                $res[] = new Number('栏目分页大小', 'page_num', $data['page_num'], 1, 500);
                                break;
                            case 'page':
                                $res[] = (new Summernote('内容', 'body', $data['body'], $router->buildUrl('/ebcms/admin/upload')))->set('help', '一般用于单页面显示');
                                $res[] = (new Text('渲染模板', 'tpl_category', $data['tpl_category']));
                                break;

                            default:
                                # code...
                                break;
                        }
                        return $res;
                    })()
                ),
                (new Col('col-md-3'))->addItem(
                    (new Text('别名', 'alias', $data['alias']))->set('help', '一般用英文'),
                    (new Radio('是否发布', 'state', $data['state'], [
                        [
                            'label' => '是',
                            'value' => 1,
                        ], [
                            'label' => '否',
                            'value' => 2,
                        ],
                    ]))->set('inline', true),
                    (new Radio('导航显示', 'nav', $data['nav'], [
                        [
                            'label' => '是',
                            'value' => 1,
                        ], [
                            'label' => '否',
                            'value' => 0,
                        ],
                    ]))->set('inline', true),
                    (new Summary('元数据设置'))->addItem(
                        new Text('关键词', 'keywords', $data['keywords']),
                        new Textarea('简介', 'description', $data['description'])
                    ),
                    (new Summary('其他参数设置'))->addItem(
                        (new Url('重定向地址', 'redirect_uri', $data['redirect_uri']))
                    )
                )
            )
        );
        return $form;
    }

    public function post(
        RequestFilter $input,
        Category $categoryModel,
        Xss $xss
    ) {
        $update = array_intersect_key($input->post(), [
            'pid' => '',
            'title' => '',
            'filters' => '',
            'fields' => '',
            'state' => '',
            'nav' => '',
            'priority' => '',
            'redirect_uri' => '',
            'keywords' => '',
            'description' => '',
            'tpl_category' => '',
            'tpl_content' => '',
            'alias' => '',
            'page_num' => '',
        ]);
        if ($input->has('post.body')) {
            $update['body'] = $input->post('body', '', [[$xss, 'clear']]);
        }

        $categoryModel->update($update, [
            'id' => $input->post('id', 0, ['intval']),
        ]);

        return $this->success('操作成功！', 'javascript:history.go(-2)');
    }
}
