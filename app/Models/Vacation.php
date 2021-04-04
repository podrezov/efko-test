<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vacation
 * @package App\Models
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property boolean $fixed
 */
class Vacation extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'fixed' => 'boolean'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function scopeSearchByDate(Builder $query, Carbon $startDate, Carbon $endDate): Builder
    {
        return $query
            ->where(function (Builder $query) use ($startDate, $endDate) {
                return $query
                    ->whereDate('start_date', '<=', $startDate)
                    ->whereDate('end_date', '>=', $startDate);
            })->orWhere(function (Builder $query) use ($startDate, $endDate) {
                return $query
                    ->whereDate('start_date', '>=', $startDate)
                    ->whereDate('end_date', '<=', $endDate);
            })->orWhere(function (Builder $query) use ($startDate, $endDate) {
                return $query
                    ->whereDate('start_date', '>=', $startDate)
                    ->whereDate('start_date', '<=', $endDate);
            });
    }
}
