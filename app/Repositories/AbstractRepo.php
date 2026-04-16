<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

abstract class AbstractRepo
{
    protected $model;
    protected $withRelations = [];

    public function getModel()
    {
        return $this->model;
    }

    public function getByID($id)
    {
        $item = $this->model->with($this->withRelations)->find($id);
        return $this->mapItem($item);
    }

    public function getBySlug($slug)
    {
        $item = $this->model->where('slug', $slug)->with($this->withRelations)->first();
        return $this->mapItem($item);
    }

    public function getByUserID($user_id)
    {
        $item = $this->model->where('user_id', $user_id)->with($this->withRelations)->first();
        return $this->mapItem($item);
    }

    public function setRelations(array $relations)
    {
        $this->withRelations = $relations;
        return $this;
    }

    public function getAll($filter = [], $paginate = 20, array $sorting = [])
    {
        $query = $this->applyFilter($this->model->with($this->withRelations), $filter);
        $query = $this->applySorting($query, $sorting);
        $items = $query->paginate($paginate);
        return $this->mapItems($items);
    }

    public function getFirst($filter = [], array $sorting = [])
    {
        $query = $this->applyFilter($this->model->with($this->withRelations), $filter);
        $query = $this->applySorting($query, $sorting);
        return $this->mapItem($query->first());
    }

    public function count($filter = [])
    {
        return $this->applyFilter($this->model->newQuery(), $filter)->count();
    }

    public function exists($filter = [])
    {
        return $this->applyFilter($this->model->newQuery(), $filter)->exists();
    }

    public function create($data)
    {
        $data = $this->beforeCreate($data);
        $item = $this->model->create($data);
        return $this->mapItem($item);
    }

    public function beforeCreate($data)
    {
        return $data;
    }

    public function update($id, $data)
    {
        $item = $this->model->find($id);
        if (!$item) return null;
        $data = $this->beforeUpdate($data, $item);
        $item->update($data);
        return $this->mapItem($item->fresh());
    }

    public function beforeUpdate($data, $item = null)
    {
        return $data;
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if (!$item) return false;
        $item->delete();
        return true;
    }

    public function mapItems($items)
    {
        if (empty($items)) return null;

        if ($items instanceof Collection) {
            $itemsMapped = $items->map(fn($item) => $this->mapItem($item));
        } else {
            $itemsMapped = $items->getCollection()->map(fn($item) => $this->mapItem($item));
        }

        return ['items' => $itemsMapped, 'Model' => $items];
    }

    public function mapItem($item)
    {
        if (empty($item)) return null;
        return ['id' => $item->id, 'Model' => $item];
    }

    protected function applyFilter($query, array $filter)
    {
        foreach ($filter as $field => $value) {
            if (is_array($value)) {
                if (isset($value['operator'])) {
                    $operator = $value['operator'];
                    $val = $value['value'];

                    switch (strtoupper($operator)) {
                        case 'BETWEEN':
                            $query->whereBetween($field, $val);
                            break;
                        case 'IN':
                            $query->whereIn($field, $val);
                            break;
                        case 'NOT IN':
                            $query->whereNotIn($field, $val);
                            break;
                        case 'NULL':
                            $query->whereNull($field);
                            break;
                        case 'NOT NULL':
                            $query->whereNotNull($field);
                            break;
                        case 'LIKE':
                            $query->where($field, 'LIKE', $val);
                            break;
                        default:
                            $query->where($field, $operator, $val);
                            break;
                    }
                } else {
                    $query->whereIn($field, $value);
                }
            } else {
                $query->where($field, $value);
            }
        }

        return $query;
    }

    protected function applySorting($query, array $sorting)
    {
        if (empty($sorting)) {
            return $query->orderBy('id', 'desc');
        }

        foreach ($sorting as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}
