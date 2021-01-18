<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Content;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Content;
use App\Ebcms\Cms\Model\Category;
use App\Ebcms\Cms\Model\Tag;
use Ebcms\Router;
use LogicException;
use Ebcms\FormBuilder\Builder;
use Ebcms\FormBuilder\Col;
use Ebcms\FormBuilder\Field\Checkbox;
use Ebcms\FormBuilder\Field\Hidden;
use Ebcms\FormBuilder\Field\Number;
use Ebcms\FormBuilder\Field\Radio;
use Ebcms\FormBuilder\Field\Select;
use Ebcms\FormBuilder\Field\Text;
use Ebcms\FormBuilder\Field\Textarea;
use Ebcms\FormBuilder\Other\Cover;
use Ebcms\FormBuilder\Other\Files;
use Ebcms\FormBuilder\Other\Pics;
use Ebcms\FormBuilder\Other\SimpleMDE;
use Ebcms\FormBuilder\Other\Summernote;
use Ebcms\FormBuilder\Other\TextUpload;
use Ebcms\FormBuilder\Row;
use Ebcms\FormBuilder\Summary;
use Ebcms\RequestFilter;
use Ebcms\Xss;

class Update extends Common
{
    public function get(
        Category $categoryModel,
        Content $contentModel,
        Router $router,
        RequestFilter $input
    ) {
        $data = $contentModel->get('*', [
            'id' => $input->get('id', 0, ['intval']),
        ]);

        if (!$category = $categoryModel->get('*', [
            'id' => $data['category_id'],
            'type' => 'list'
        ])) {
            return $this->failure('内容错误，请删除！');
        }

        $form = new Builder('编辑内容');
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Hidden('id', $data['id'])),
                    (new Text('标题', 'title', $data['title']))->set('help', '一般不超过80个字符')->set('required', 1),
                    (new Summernote('内容', 'body', $data['body'], $router->buildUrl('/ebcms/admin/upload'))),
                    ...(function () use ($router, $category, $data): array {
                        $res = [];
                        $extra = unserialize($data['extra']);
                        // 筛选项
                        foreach (array_filter(explode(PHP_EOL, $category['filters'])) as $val) {
                            $field = [];
                            foreach (array_filter(explode(';', trim($val))) as $tmp) {
                                list($k, $v) = explode('=', trim($tmp));
                                $field[trim($k)] = trim($v);
                            }
                            if (!isset($field['name']) || !isset($field['label']) || !isset($field['options'])) {
                                throw new LogicException('扩展字段每一行的name label options必须设置');
                            }
                            $tmp = new Radio($field['label'], $field['name'], $data[$field['name']] ?? '', (function () use ($field): array {
                                $res = [];
                                foreach (array_filter(explode('|', $field['options'])) as $value) {
                                    $res[] = [
                                        'label' => $value,
                                        'value' => $value,
                                    ];
                                }
                                return $res;
                            })());
                            $field['inline'] = $field['inline'] ?? 1;
                            unset($field['label']);
                            unset($field['name']);
                            unset($field['options']);
                            unset($field['value']);
                            foreach ($field as $key => $value) {
                                $tmp->set($key, $value);
                            }
                            $res[] = $tmp;
                        }
                        // 自定义字段
                        foreach (array_filter(explode(PHP_EOL, $category['fields'])) as $val) {
                            $field = [];
                            foreach (array_filter(explode(';', trim($val))) as $tmp) {
                                list($k, $v) = explode('=', trim($tmp));
                                $field[trim($k)] = trim($v);
                            }
                            if (!isset($field['name']) || !isset($field['label']) || !isset($field['type'])) {
                                throw new LogicException('扩展字段每一行的name label type必须设置');
                            }
                            switch ($field['type']) {
                                case 'summernote':
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $tmp = (new Summernote($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;
                                case 'simplemde':
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $tmp = (new SimpleMDE($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;
                                case 'text':
                                    $tmp = (new Text($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;
                                case 'textarea':
                                    $tmp = (new Textarea($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;
                                case 'cover':
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $tmp = (new Cover($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;
                                case 'pics':
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $tmp = (new Pics($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;
                                case 'textupload':
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $tmp = (new TextUpload($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;
                                case 'files':
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $tmp = (new Files($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;
                                case 'radio':
                                    $field['options'] = (function () use ($field): array {
                                        $res = [];
                                        foreach (array_filter(explode('|', $field['options'])) as $value) {
                                            $res[] = [
                                                'label' => $value,
                                                'value' => $value,
                                            ];
                                        }
                                        return $res;
                                    })();
                                    $field['inline'] = $field['inline'] ?? 1;
                                    $tmp = (new Radio($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;
                                case 'checkbox':
                                    $field['options'] = (function () use ($field): array {
                                        $res = [];
                                        foreach (array_filter(explode('|', $field['options'])) as $value) {
                                            $res[] = [
                                                'label' => $value,
                                                'value' => $value,
                                            ];
                                        }
                                        return $res;
                                    })();
                                    $field['value'] = array_filter(explode('|', $field['value']));
                                    $field['inline'] = $field['inline'] ?? 1;
                                    $tmp = (new Checkbox($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? []));
                                    break;
                                case 'select':
                                    $field['options'] = (function () use ($field): array {
                                        $res = [];
                                        foreach (array_filter(explode('|', $field['options'])) as $value) {
                                            $res[] = [
                                                'label' => $value,
                                                'value' => $value,
                                            ];
                                        }
                                        return $res;
                                    })();
                                    $tmp = (new Select($field['label'], 'extra[' . $field['name'] . ']', $extra[$field['name']] ?? ''));
                                    break;

                                default:
                                    throw new LogicException('类型' . $field['type'] . '不支持');
                                    break;
                            }
                            unset($field['type']);
                            unset($field['label']);
                            unset($field['name']);
                            unset($field['value']);
                            foreach ($field as $key => $value) {
                                $tmp->set($key, $value);
                            }
                            $res[] = $tmp;
                        }
                        $res[] = (new Radio('状态', 'state', $data['state']))->set('options', [
                            [
                                'label' => '发布',
                                'value' => 1,
                            ], [
                                'label' => '待审',
                                'value' => 2,
                            ],
                        ])->set('inline', true);
                        return $res;
                    })()
                ),
                (new Col('col-md-3'))->addItem(
                    (new Text('别名', 'alias', $data['alias'])),
                    (new Cover('频道图', 'cover', $data['cover'], $router->buildUrl('/ebcms/admin/upload'))),
                    (new Radio('置顶', 'top', $data['top']))->set('options', [
                        [
                            'label' => '三级置顶',
                            'value' => 3,
                        ], [
                            'label' => '二级置顶',
                            'value' => 2,
                        ], [
                            'label' => '一级置顶',
                            'value' => 1,
                        ], [
                            'label' => '不置顶',
                            'value' => 0,
                        ],
                    ])->set('inline', true),
                    (new Text('标签', 'tags', $data['tags']))->set('help', '多个标签用空格分割'),
                    (new Summary('元数据设置'))->addItem(
                        new Text('关键词', 'keywords', $data['keywords']),
                        new Textarea('简介', 'description', $data['description'])
                    ),
                    (new Summary('其他参数设置'))->addItem(
                        new Text('模板', 'tpl', $data['tpl']),
                        new Text('重定向地址', 'redirect_uri', $data['redirect_uri'])
                    )
                )
            )
        );
        return $this->html($form->__toString());
    }
    public function post(
        Xss $xss,
        RequestFilter $input,
        Content $contentModel,
        Tag $tagModel
    ) {
        $update = array_intersect_key($input->post(), [
            'title' => '',
            'cover' => '',
            'keywords' => '',
            'description' => '',
            'tpl' => '',
            'alias' => '',
            'tags' => '',
            'state' => '',
            'redirect_uri' => '',
            'top' => '',
            'filter0' => '',
            'filter1' => '',
            'filter2' => '',
            'filter3' => '',
            'filter4' => '',
            'filter5' => '',
        ]);
        $update['update_time'] = time();
        $update['extra'] = serialize($input->post('extra'));
        if ($input->has('post.body')) {
            $update['body'] = $input->post('body', '', [[$xss, 'clear']]);
        }
        $update['tags'] = implode(',', array_unique(array_filter(explode(',', str_replace([' ', '|', ',', '，'], ',', $update['tags'])))));

        $contentModel->update($update, [
            'id' => $input->post('id', 0, ['intval']),
        ]);

        $tagModel->delete([
            'content_id' => $input->post('id', 0, ['intval']),
        ]);

        if ($update['state'] && $update['tags']) {
            $tags = explode(',', $update['tags']);
            $inserts = [];
            foreach ($tags as $tag) {
                $inserts[] = [
                    'content_id' => $input->post('id', 0, ['intval']),
                    'tag' => $tag,
                ];
            }
            $tagModel->insert($inserts);
        }

        return $this->success('操作成功！', 'javascript:history.go(-2)');
    }
}
