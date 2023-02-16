<?php

namespace App\Providers;

use App\Models\Users;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheUserProvider
 * @package App\Auth
 */
class CacheUserProvider extends EloquentUserProvider
{
    /**
     * CacheUserProvider constructor.
     * @param HasherContract $hasher
     */
    public function __construct(HasherContract $hasher)
    {
        parent::__construct($hasher, Users::class);
    }

    /**
     * @param mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $key = Users::cacheKey($identifier);

        $user = Cache::get($key) ?? parent::retrieveById($identifier);
        $user->setRoles($user->getRoles());
        $user->setActiveRole($user->getActiveRole());

        Users::saveCache($user);

        return $user;
    }
}
