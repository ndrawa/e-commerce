<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use HasUlids;

    protected $table = 'users';
    protected $guarded = [];
    protected $primaryKey = "id";
    // protected $fillable = [
    //     'id',
    //     'username',
    //     'name',
    //     // 'email',
    //     'email_user',
    //     'role_user_siterpadu',
    //     'nomor induk',
    //     'photo'
    // ];

    /**
     * @return Role[]
     */
    public function getRoles()
    {
        if ($this->roles && count($this->roles) > 0) return $this->roles;
        $roles = Role::get_roles_by_userid($this->id);
        return $roles;
    }

    public function setRoles($roles)
    {
        $this->setRelation('roles', $roles);
    }

    public function getActiveRole(): ?Role
    {
        if ($this->active_role != null) return $this->active_role;

        $roles = $this->getRoles();
        foreach ($roles as $role) {
            return $role;
        }
        return null;
    }

    public function setActiveRole(?Role $role)
    {
        $this->getCurrentPlace();
        $this->setAttribute('active_role', $role);
    }

    public function createDefaultRole()
    {
        $role = Role::where('name', Role::getRole('USER'))->firstOrFail();
        $role->user_roles()->create([
            'id_user' => $this->id
        ]);
    }

    public function hasRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $key) {
                if ($this->getActiveRole() && $this->getActiveRole()->key == $key) {
                    return true;
                }
            }
        } else {
            if ($this->getActiveRole() && $this->getActiveRole()->key == $roles) {
                return true;
            }
        }

        return false;
    }

    public function hasRoleId($role_id)
    {
        $roles = $this->getRoles();
        foreach ($roles as $role) {
            if ($role->id == $role_id) {
                return true;
            }
        }
        return false;
    }

    public function getPlaces()
    {
        $places = null;

        $role = $this->getActiveRole();
        if ($role->key == 'ADMIN_TUK') {
            $user_role = UserRole::where([['id_user', $this->id], ['id_role', $role->id]])->first();
            if ($user_role) {
                $place_ids = UserPlace::where('user_role_id', $user_role->id)->pluck('place_id');
                $places = Place::whereIn('id', $place_ids)->get();
            }
        }
        return $places;
    }

    public function getCurrentPlace()
    {
        $places = $this->getPlaces();
        if ($places && count($places) > 0) {
            if ($this->current_place != null) {
                return $this->current_place;
            }

            $this->setCurrentPlace($places[0]);
            return $places[0];
        }

        $this->unsetCurrentPlace();
        return null;
    }

    public function hasPlaceId($place_id)
    {
        $places = $this->getPlaces();
        if ($places && count($places) > 0) {
            foreach ($places as $place) {
                if ($place->id == $place_id) {
                    return true;
                }
            }
        }
        return false;
    }

    public function setCurrentPlace(?Place $place)
    {
        $this->setAttribute('current_place', $place);
    }

    public function unsetCurrentPlace()
    {
        unset($this->current_place);
    }

    public static function saveCache(Users $user)
    {
        return Cache::put(sprintf(Users::cacheKey($user->id)), $user, now()->addHours(8));
    }

    public static function forgetCache($user)
    {
        if ($user != null) {
            return Cache::forget(sprintf(Users::cacheKey($user->id)));
        }
    }

    public static function cacheKey($userId)
    {
        return sprintf('user:%d', $userId);
    }
}
