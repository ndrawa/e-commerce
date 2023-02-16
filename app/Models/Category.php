<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUlids;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($data) {
            $data->item()->delete();
        });

        static::restored(function ($data) {
            $data->item()->restore();
        });
    }

    public function item()
    {
        return $this->hasMany(ItemCategory::class, 'category_id');
    }
}
