<?php

declare(strict_types=1);

namespace App\Ebcms\Cms\Model;

use Ebcms\Database\Model;

class Category extends Model
{
    public function getTable(): string
    {
        return 'ebcms_cms_category';
    }

    public function all(): array
    {
        static $categorys;
        if ($categorys == null) {
            $categorys = $this->select('*', [
                'state' => 1,
                'ORDER' => [
                    'priority' => 'DESC',
                    'id' => 'ASC'
                ],
            ]);
        }
        return $categorys;
    }

    public function subdata($id): array
    {
        $res = [];
        foreach ($this->all() as $value) {
            if ($value['pid'] == $id) {
                $res[] = $value;
                foreach ($this->subdata($value['id']) as $sub) {
                    $res[] = $sub;
                }
            }
        }
        return $res;
    }

    public function subid($id): array
    {
        $res = [];
        foreach ($this->subdata($id) as $value) {
            $res[] = $value['id'];
        }
        return $res;
    }

    public function hasSubList($id): bool
    {
        foreach ($this->subdata($id) as $value) {
            if ($value['type'] == 'list') {
                return true;
            }
        }
        return false;
    }

    public function getItem($id): ?array
    {
        foreach ($this->all() as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return null;
    }

    public function pdata($id): array
    {
        $res = [];
        return $this->_pdata($id, $res);
    }

    private function _pdata($id, array &$res = []): array
    {
        foreach ($this->all() as $vo) {
            if ($vo['id'] == $id) {
                $this->_pdata($vo['pid'], $res);
                $res[] = $vo;
            }
        }
        return $res;
    }
}
