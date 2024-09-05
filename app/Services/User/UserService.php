<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\BaseRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->baseRepository   = new BaseRepository(new User());;
    }

    public function create(array $data, array $options = []): Builder|Model
    {
        return $this->baseRepository->create($data, $options);
    }
}
