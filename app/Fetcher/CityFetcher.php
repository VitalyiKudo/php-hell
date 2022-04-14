<?php

namespace App\Fetcher;

use Illuminate\Database\Connection;

class CityFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findCityByName(string $name): ?string
    {
        return $this->connection->table('cities as c')
            ->selectRaw('c.name as city, r.name as region')
            ->join('regions AS r', function ($join) {
                $join->on('c.iso_region', '=', 'r.region_id')
                    ->on('c.iso_country', '=', 'r.country_id');
            })
            ->where('c.geonameid', $name)
            ->first();
    }
}
