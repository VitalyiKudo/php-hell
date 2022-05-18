<?php
namespace App\Traits;

use App\Models\Operator;

trait SearchOperatorTrait {
    /**
     * @param $keyword
     *
     * @return void
     */
    public function SearchOperatorNameLike($keyword)
    {
        return Operator::where('name', 'like', "{$keyword}%")
                ->orWhere('email', 'like', "{$keyword}%")
                ->get();
    }
}

