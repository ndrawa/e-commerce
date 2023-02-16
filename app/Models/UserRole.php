<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class UserRole extends Model
{
    use Notifiable;
    use HasUlids;

    protected $table = 'user_role';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }
}
