<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MetricHistoryRun extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'accesibility_metric', 'pwa_metric', 'performance_metric', 'seo_metric', 'best_practices_metric'];

    // Each run is done with one strategy only
    public function strategy() : BelongsTo
    {
        return $this->belongsTo(Strategy::class, 'strategy_id');
    }
}
