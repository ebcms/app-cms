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

    public function getAll(): array
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

    public function getAllSub($id): array
    {
        $res = [];
        foreach ($this->getAll() as $value) {
            if ($value['pid'] == $id) {
                $res[] = $value;
                foreach ($this->getAllSub($value['id']) as $sub) {
                    $res[] = $sub;
                }
            }
        }
        return $res;
    }

    public function getAllSubId($id): array
    {
        $res = [];
        foreach ($this->getAllSub($id) as $value) {
            $res[] = $value['id'];
        }
        return $res;
    }

    public function hasSubList($id): bool
    {
        foreach ($this->getAllSub($id) as $value) {
            if ($value['type'] == 'list') {
                return true;
            }
        }
        return false;
    }

    public function getItem($id): ?array
    {
        foreach ($this->getAll() as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return null;
    }

    public function getParentsAndSelf($id): array
    {
        $res = [];
        return $this->_pdata($id, $res);
    }

    private function _pdata($id, array &$res = []): array
    {
        foreach ($this->getAll() as $vo) {
            if ($vo['id'] == $id) {
                $this->_pdata($vo['pid'], $res);
                $res[] = $vo;
            }
        }
        return $res;
    }
}
