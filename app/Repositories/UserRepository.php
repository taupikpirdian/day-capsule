<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function query()
    {
        return new User();
    }

    public function getAll()
    {
        return $this->query()->orderBy('created_at', 'desc');
    }

    public function store($dto)
    {
        return $this->query()->create($dto);
    }

    public function findOne($id)
    {
        return $this->query()->where('id', $id)->first();;
    }

    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();;
    }

    public function update($dto)
    {
        $data = $this->findOne($dto['id']);
        if($data){
            if(isset($dto['name'])){
                $data->name = $dto['name'];
            }
            if(isset($dto['email'])){
                $data->name = $dto['email'];
            }
            if($dto['password']){
                $data->password = $dto['password'];
            }
            $data->save();
        }
        return $data;
    }
}
