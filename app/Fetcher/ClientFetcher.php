<?php

namespace App\Fetcher;

use App\Models\User;
use Illuminate\Database\Connection;

class ClientFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findUserById(int $userId): ?User
    {
        return User::where('id', $userId)->first();
    }
}
