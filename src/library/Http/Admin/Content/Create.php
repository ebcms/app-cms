<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Http\Admin\Content;

use App\Ebcms\Admin\Http\Common;
use App\Ebcms\Cms\Model\Content;
use App\Ebcms\Cms\Model\Category;
use App\Ebcms\Cms\Model\Tag;
use LogicException;
use Ebcms\Router;
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

class Create extends Common
{
    public function get(
        Category $categoryModel,
        Content $contentModel,
        RequestFilter $input,
        Router $router
    ) {
        if (!$category = $categoryModel->get('*', [
            'id' => $input->get('category_id'),
            'type' => 'list'
        ])) {
            return $this->failure('操作错误！');
        }

        $data = $contentModel->get('*', [
            'id' => $input->get('copyfrom')
        ]) ?: [];

        $form = new Builder('创建内容');
        $form->addRow(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Hidden('category_id', $category['id'])),
                    (new Text('标题', 'title', $data['title'] ?? ''))->set('help', '一般不超过80个字符')->set('required', 1),
                    ...(function () use ($router, $category, $data): array {
                        $res = [];
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
                            $tmp = new Radio($field['label'], $field['name'], '', (function () use ($field): array {
                                $res = [];
                                foreach (array_filter(explode('|', $field['options'])) as $value) {
                                    $res[] = [
                                        'label' => $value,
                                        'value' => $value,
                                    ];
                                }
                                return $res;
                            })());

                            $field['value'] = $data[$field['name']] ?? ($field['value'] ?? '');
                            $field['inline'] = $field['inline'] ?? 1;

                            unset($field['label']);
                            unset($field['name']);
                            unset($field['options']);
                            foreach ($field as $key => $value) {
                                $tmp->set($key, $value);
                            }
                            $res[] = $tmp;
                        }
                        // 自定义字段
                        foreach (array_filter(explode(PHP_EOL, $category['fields'])) as $val) {
                            $field = [];
                            $extdata = isset($data['body']) ? unserialize($data['body']) : [];
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
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $tmp = (new Summernote($field['label'], 'body[' . $field['name'] . ']'));
                                    break;
                                case 'simplemde':
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $tmp = (new SimpleMDE($field['label'], 'body[' . $field['name'] . ']'));
                                    break;
                                case 'text':
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $tmp = (new Text($field['label'], 'body[' . $field['name'] . ']'));
                                    break;
                                case 'textarea':
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $tmp = (new Textarea($field['label'], 'body[' . $field['name'] . ']'));
                                    break;
                                case 'cover':
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $tmp = (new Cover($field['label'], 'body[' . $field['name'] . ']'));
                                    break;
                                case 'pics':
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $tmp = (new Pics($field['label'], 'body[' . $field['name'] . ']'));
                                    break;
                                case 'textupload':
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $tmp = (new TextUpload($field['label'], 'body[' . $field['name'] . ']'));
                                    break;
                                case 'files':
                                    $field['upload_url'] = $field['upload_url'] ?? $router->buildUrl('/ebcms/admin/upload');
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $tmp = (new Files($field['label'], 'body[' . $field['name'] . ']'));
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
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $field['inline'] = $field['inline'] ?? 1;
                                    $tmp = (new Radio($field['label'], 'body[' . $field['name'] . ']'));
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
                                    $field['value'] = $extdata[$field['name']] ?? array_filter(explode('|', $field['value']));
                                    $field['inline'] = $field['inline'] ?? 1;
                                    $tmp = (new Checkbox($field['label'], 'body[' . $field['name'] . ']'));
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
                                    $field['value'] = $extdata[$field['name']] ?? ($field['value'] ?? '');
                                    $tmp = (new Select($field['label'], 'body[' . $field['name'] . ']'));
                                    break;

                                default:
                                    throw new LogicException('类型' . $field['type'] . '不支持');
                                    break;
                            }
                            unset($field['type']);
                            unset($field['label']);
                            unset($field['name']);
                            foreach ($field as $key => $value) {
                                $tmp->set($key, $value);
                            }
                            $res[] = $tmp;
                        }
                        $res[] = (new Radio('状态', 'state', $data['state'] ?? '1'))->set('options', [
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
                    (new Text('别名', 'alias')),
                    (new Cover('频道图', 'cover', $data['cover'] ?? '', $router->buildUrl('/ebcms/admin/upload'))),
                    (new Radio('是否置顶', 'top', $data['top'] ?? '0'))->set('options', [
                        [
                            'label' => '是',
                            'value' => 1,
                        ], [
                            'label' => '否',
                            'value' => 0,
                        ],
                    ])->set('inline', true),
                    (new Text('标签', 'tags', $data['tags'] ?? ''))->set('help', '多个标签用空格分割'),
                    (new Summary('元数据设置'))->addItem(
                        new Text('关键词', 'keywords', $data['keywords'] ?? ''),
                        new Textarea('简介', 'description', $data['description'] ?? '')
                    ),
                    (new Summary('其他参数设置'))->addItem(
                        new Text('模板', 'tpl', $data['tpl'] ?? ''),
                        (new Number('优先级', 'priority', $data['priority'] ?? '50', 1, 100))->set('help', '越大越靠前'),
                        new Text('重定向地址', 'redirect_uri', $data['redirect_uri'] ?? '')
                    )
                )
            )
        );
        return $form;
    }

    public function post(
        RequestFilter $input,
        Content $contentModel,
        Tag $tagModel
    ) {
        $data = [
            'category_id' => $input->post('category_id'),
            'title' => $input->post('title'),
            'keywords' => $input->post('keywords'),
            'description' => $input->post('description'),
            'cover' => $input->post('cover'),
            'body' => serialize($input->post('body')),
            'state' => $input->post('state', 0, ['intval']),
            'tpl' => $input->post('tpl'),
            'alias' => $input->post('alias'),
            'tags' => $input->post('tags'),
            'redirect_uri' => $input->post('redirect_uri'),
            'priority' => $input->post('priority'),
            'top' => $input->post('top'),
            'filter0' => $input->post('filter0'),
            'filter1' => $input->post('filter1'),
            'filter2' => $input->post('filter2'),
            'filter3' => $input->post('filter3'),
            'filter4' => $input->post('filter4'),
            'filter5' => $input->post('filter5'),
            'create_time' => time(),
            'update_time' => time(),
        ];
        $data['tags'] = implode(',', array_unique(array_filter(explode(',', str_replace([' ', '|', ',', '，'], ',', $data['tags'])))));
        $content_id = $contentModel->insert($data);

        if ($data['state'] && $data['tags']) {
            $tags = explode(',', $data['tags']);
            $inserts = [];
            foreach ($tags as $tag) {
                $inserts[] = [
                    'content_id' => $content_id,
                    'tag' => $tag,
                ];
            }
            $tagModel->insert($inserts);
        }
        return $this->success('操作成功！', 'javascript:history.go(-2)');
    }
}
