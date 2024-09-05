<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * The model instance.
     *
     * @var Model
     */
    protected Model $model;

    /**
     * Create a new BaseRepository instance.
     *
     * @param Model $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @param array|null $attr
     * @return Builder
     */
    public function index(array $attr = null): Builder
    {
        return $attr ? $this->model->query()->select($attr) : $this->model->query();
    }

    /**
     * Create a new instance of the model.
     *
     * @param array $data
     * @param array $options
     * @return Model|Builder
     */
    public function create(array $data, array $options = []): Model|Builder
    {
        $model = $this->index()->create($data);
        return $model->refresh();
    }

    /**
     * Update the model in the database.
     *
     * @param int $id
     * @param array $data
     * @param array $options
     * @return bool
     */
    public function update(int $id, array $data, array $options = []): bool
    {
        $model = $this->index()->find($id);

        if (!$model) {
            return false;
        }

        return $model->fill($data)->save();
    }

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param array $attr
     * @param array $data
     * @param array $options
     * @return Model|Builder
     */
    public function updateOrCreate(array $attr, array $data, array $options = []): Model|Builder
    {
        return $this->model->query()->updateOrCreate($attr, $data);
    }

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param array $data
     * @param array $uniqueFields
     * @param $updatedFields
     * @param array $options
     * @return int
     */
    public function upsert(array $data, array $uniqueFields, $updatedFields, array $options = []): int
    {
        return $this->model->query()->upsert($data, $uniqueFields, $updatedFields);
    }

    /**
     * Delete a record from the database.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        $model = $this->index()->find($id);

        if (!$model) {
            return false;
        }

        return $model->delete();
    }

    /**
     * Find a model by its primary key.
     *
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getById(int $id): Model|Collection|Builder|array|null
    {
        return $this->index()->find($id);
    }

    /**
     * @param string $uuid
     * @return Model|Collection|Builder|array|null
     */
    public function getByUuid(string $uuid): Model|Collection|Builder|array|null
    {
        return $this->index()->where('uuid', $uuid)->first();
    }

    /**
     * @param string $uuid
     * @return bool
     */
    public function deleteByUuid(string $uuid): bool
    {
        $model = $this->index()->where('uuid', $uuid)->first();

        if (!$model) {
            return false;
        }

        return $model->delete();
    }

    /**
     * Create or ignore a record matching the attributes, and fill it with values.
     *
     * @param array $attr
     * @param array $data
     * @return Model|Builder
     */
    public function firstOrCreate(array $attr, array $data): Model|Builder
    {
        return $this->model->query()->firstOrCreate($attr, $data);
    }

    /**
     * @return Builder
     */
    public function onlyTrashed(): Builder
    {
        return $this->model->query()->onlyTrashed();
    }
}
