<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Role extends Model
{
    // use SoftDeletes;
    use HasUlids;

    protected $table = 'role';
    protected $guarded = ['id'];

    public function user_roles()
    {
        return $this->hasMany(UserRole::class, 'id_role', 'id');
    }

    public static function getRole(string $key)
    {
        $role = Role::where('key', $key)->first();
        return $role->name;
    }

    public static function get_roles_by_userid($userId)
    {
        return Role::select('role.*')
            ->join('user_role', 'role.id', 'user_role.id_role')
            ->where('user_role.id_user', $userId)
            ->get();
    }
}
