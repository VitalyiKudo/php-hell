<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SearchResult
 *
 * @property int $id
 * @property int $search_id
 * @property string $result_id
 * @property string $seller_id
 * @property string $seller_name
 * @property string $seller_icao
 * @property string $lift_id
 * @property string $aircraft_category
 * @property string $aircraft_type
 * @property float $price
 * @property string $currency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Search $search
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SearchResultSegment[] $segments
 * @property-read int|null $segments_count
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereAircraftCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereAircraftType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereLiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereSearchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereSellerIcao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereSellerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResult whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SearchResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'result_id',
        'seller_id',
        'seller_name',
        'seller_icao',
        'lift_id',
        'aircraft_category',
        'aircraft_type',
        'price',
        'currency',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Get the search of the result.
     */
    public function search()
    {
        return $this->belongsTo('App\Models\Search');
    }

    /**
     * Get all of the segments for the search result.
     */
    public function segments()
    {
        return $this->hasMany('App\Models\SearchResultSegment');
    }
}
