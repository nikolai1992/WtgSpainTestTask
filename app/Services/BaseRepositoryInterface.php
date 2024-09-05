<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
interface BaseRepositoryInterface
{
    /**
     * @param array|null $attr
     * @return Builder
     */
    public function index(array $attr = null): Builder;

    /**
     * @param array $data
     * @param array $options опции нужны для расширения данного метода, в случае если нужно дописать дополнительную логику по текущему методу
     * @return Model|Builder
     */
    public function create(array $data, array $options = []): Model|Builder;

    /**
     * @param int $id
     * @param array $data
     * @param array $options опции нужны для расширения данного метода, в случае если нужно дописать дополнительную логику по текущему методу
     * @return bool
     */
    public function update(int $id, array $data, array $options = []): bool;

    /**
     * @param array $attr
     * @param array $data
     * @param array $options опции нужны для расширения данного метода, в случае если нужно дописать дополнительную логику по текущему методу
     * @return Model|Builder
     */
    public function updateOrCreate(array $attr, array $data, array $options = []): Model|Builder;

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param array $data
     * @param array $uniqueFields
     * @param $updatedFields
     * @param array $options опции нужны для расширения данного метода, в случае если нужно дописать дополнительную логику по текущему методу
     * @return int
     */
    public function upsert(array $data, array $uniqueFields, $updatedFields, array $options = []): int;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getById(int $id): Model|Collection|Builder|array|null;

    /**
     * @param string $uuid
     * @return Model|Collection|Builder|array|null
     */
    public function getByUuid(string $uuid): Model|Collection|Builder|array|null;

    /**
     * @param string $uuid
     * @return bool
     */
    public function deleteByUuid(string $uuid): bool;

    /**
     * @return Builder
     */
    public function onlyTrashed(): Builder;
}
