<?php
namespace App\Traits;

use App\Models\City;

trait SearchCityTrait {
    /**
     * @param $keyword
     *
     * @return mixed
     */
    public function SearchCityNameLike($keyword)
    {
        return City::with('regionCountry', 'country')
            ->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "{$keyword}%")
                ->orWhereHas('regionCountry', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->orWhereHas('country', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })
            ->get();
    }
}

