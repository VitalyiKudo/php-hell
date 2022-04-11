<?php
namespace App\Http\Traits;

use App\Models\Airport;

trait SearchAirportTrait {
    /**
     * @param $keyword
     *
     * @return void
     */
    public function SearchAirportNameLike($keyword)
    {
        return Airport::with('cities')
            ->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "{$keyword}%")
                ->orWhere('iata', 'like', "{$keyword}%")
                ->orWhere('icao', 'like', "{$keyword}%")
                ->orWhereHas('cities', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })
            ->get();
    }
}

