<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUlids;

    protected $table = "items";
    protected $primaryKey = 'id';
    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        $driver = env('FILESYSTEM_DISK');
        if (!empty($this->image)) {
            $storage_url = ($driver ?? 'public') == 'minio' ? Storage::temporaryUrl($this->image, Carbon::now()->addMinutes(20)) : Storage::url($this->image);
        }
        return $storage_url ?? url('images/no-preview.jpeg');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($data) {
            $data->categories()->delete();
        });

        static::restored(function ($data) {
            $data->categories()->restore();
        });
    }

    public function categories()
    {
        return $this->hasMany(ItemCategory::class, 'item_id');
    }
}
