<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\User;

interface CategoryRepositoryInterface
{
    public function getAllByUser(User $user);

    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);

    public function getPosts($id);
}
