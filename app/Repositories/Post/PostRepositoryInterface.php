<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Models\User;

interface PostRepositoryInterface
{
    public function getAllByUser();

    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);
}
