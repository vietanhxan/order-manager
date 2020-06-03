<?php

namespace VCComponent\Laravel\Order\Traits;

trait OrderQuery
{
    public function where($column, $value)
    {
        $this->query = $this->query->where($column, $value);

        return $this;
    }

    public function findOrFail($id)
    {
        return $this->query->findOrFail($id);
    }

    public function toSql()
    {
        return $this->query->toSql();
    }

    public function get()
    {
        return $this->query->get();
    }

    public function paginate($perPage)
    {
        return $this->query->paginate($perPage);
    }

    public function limit($value)
    {
        return $this->query->limit($value);
    }

    public function orderBy($column, $direction = 'asc')
    {
        return $this->query->orderBy($column, $direction);
    }

    public function with($relations)
    {
        $this->query->with($relations);

        return $this;
    }

    public function first()
    {
        return $this->query->first();
    }

    public function create(array $attributes = [])
    {
        return $this->query->create($attributes);
    }

    public function firstOrCreate(array $attributes, array $values = [])
    {
        return $this->query->firstOrCreate($attributes, $values);
    }

    public function update(array $values)
    {
        return $this->query->update($values);
    }

    public function delete()
    {
        return $this->query->delete();
    }
}
