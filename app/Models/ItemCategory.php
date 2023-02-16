<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;


class ItemCategory extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUlids;

    protected $table = 'item_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_id',
        'category_id',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id')->withTrashed();
    }
}
