<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;


class BuyItem extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'buy_items';
    protected $primaryKey = 'id';

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
