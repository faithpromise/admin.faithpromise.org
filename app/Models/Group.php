<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;

class Group extends Model {

    use PostgisTrait;

    public $incrementing = false;
    protected $fillable = ['id'];
    protected $postgisFields = ['location' => Point::class];

    public function scopeStale($query) {
        $query->where(function ($query) {
            $stale_after = Carbon::today()->subDays(2);
            $query->whereNull('detail_last_updated')->orWhere('detail_last_updated', '<', $stale_after);
        })->orderBy('detail_last_updated', 'desc')->limit(5);
    }

}
