<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Room
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Administrator[] $administrators
 * @property-read int|null $administrators_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUserId($value)
 * @mixin \Eloquent
 */
class Room extends Model
{
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function administrators(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Administrator::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class);
    }
}
