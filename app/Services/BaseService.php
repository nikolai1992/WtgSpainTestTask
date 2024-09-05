<?php

namespace App\Services;

use App\Services\BaseRepository;
use App\Services\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
abstract class BaseService
{
    /**
     * @var BaseRepository
     */
    public BaseRepositoryInterface $baseRepository;

    /**
     * @param array|null $attr
     * @return Model|Builder
     */
    public function index(array $attr = null): Model|Builder
    {
        return $this->baseRepository->index($attr);
    }

    /**
     * @param $id
     * @return Model|Collection|Builder|array|null
     */
    public function getById($id): Model|Collection|Builder|array|null
    {
        return $this->baseRepository->getById($id);
    }

    /**
     * @param array $data
     * @param array $options
     * @return Model|Builder
     */
    public function create(array $data, array $options = []): Model|Builder
    {
        return $this->baseRepository->create($data, $options);
    }

    /**
     * @param $id
     * @param array $input
     * @param array $options
     * @return bool
     */
    public function update($id, array $input, array $options = []): bool
    {
        return $this->baseRepository->update($id, $input, $options);
    }

    /**
     * @param array $attr
     * @param array $data
     * @param array $options
     * @return Model|Builder
     */
    public function updateOrCreate(array $attr, array $data, array $options = []): Model|Builder
    {
        return $this->baseRepository->updateOrCreate($attr, $data, $options);
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
        return $this->baseRepository->upsert($data, $uniqueFields, $updatedFields, $options);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id): bool
    {
        return $this->baseRepository->deleteById($id);
    }


    /**
     * @param string $uuid
     * @return Model|Collection|Builder|array|null
     */
    public function getByUuid(string $uuid): Model|Collection|Builder|array|null
    {
        return $this->baseRepository->getByUuid($uuid);
    }

    /**
     * @param string $uuid
     * @return bool
     */
    public function deleteByUuid(string $uuid): bool
    {
        return $this->baseRepository->deleteByUuid($uuid);
    }

    /**
     * для подгрузки данных при скролле с сортировкой
     * @param Builder $query
     * @param array $orderData
     * $orderData = [
     *  [
     *      'column_name'     => 'planned_arrival_date', - название столбца
     *      'column_value'    => $this->lastContainerDate, - значение столбца column_name по последней полученной записи
     *      'column_operator' => '>', - оператор сравнения
     *  ]
     * ];
     * @param array $secondOrderData
     * $secondOrderData = [
     *      'column_name'     => 'id', - название столбца
     *      'column_value'    => $this->lastContainerId, - значение столбца column_name по последней полученной записи
     *      'column_operator' => '>', - оператор сравнения
     * ];
     * @return Builder
     */
    public function customCursorOrderBy(Builder $query, array $orderData, array $secondOrderData): Builder
    {
        foreach($orderData as $data) {
            $query->where(function ($query) use ($data, $secondOrderData) {
                //фильтрация строк, где значение $data['column_name'] не null
                $query->whereNotNull($data['column_name'])
                    ->where(function ($query) use ($data, $secondOrderData) {
                        //проверка на последнее полученое значение c $orderData
                        $query->when(!is_null($data['column_value']), function ($query) use ($data, $secondOrderData) {
                            //если $data['column_value'] не null, применяем условие по $orderData
                            $query->where($data['column_name'], $data['column_operator'], $data['column_value']);
                        }, function ($query) use ($secondOrderData) {
                            //если $data['column_value'] = null - применяем условие по $secondOrderData
                            $query->where($secondOrderData['column_name'], $secondOrderData['column_operator'], $secondOrderData['column_value']);
                        });
                    });
            })
                //если $data['column_name'] = null - применяем условие только по $secondOrderData
                ->orWhere(function ($query) use ($data, $secondOrderData) {
                    $query->whereNull($data['column_name'])
                        ->where($secondOrderData['column_name'], $secondOrderData['column_operator'], $secondOrderData['column_value']);
                });
        }

        return $query;
    }
    /**
     * @return Builder
     */
    public function onlyTrashed(): Builder
    {
        return $this->baseRepository->onlyTrashed();
    }
}
