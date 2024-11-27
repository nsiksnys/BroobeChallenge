<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Strategy extends Model
{
    use HasFactory;

    // inverse of One-To-One relationship
    public function metricHistoryRuns() : HasMany
    {
        return $this->HasMany(MetricHistoryRun::class);
    }
}
