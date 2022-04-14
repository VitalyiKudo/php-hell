<?php

namespace App\Fetcher;

use App\Models\Search;
use DomainException;
use Illuminate\Database\Connection;

class SearchFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getSearchLastByUserId(int $userId): Search
    {
        $search = Search::where('user_id', $userId)
            ->latest()
            ->first();

        if (!$search) {
            throw new DomainException('Search not exists.');
        }

        return $search;
    }
}
