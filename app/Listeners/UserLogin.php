<?php

namespace App\Listeners;

use Aacotroneo\Saml2\Events\Saml2Event;
use Aacotroneo\Saml2\Events\Saml2LoginEvent;
use App\Models\Role;
use App\Models\User;
use App\Models\Users;
use App\Models\UserRole;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class UserLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Saml2LoginEvent  $event)
    {
        $messageId = $event->getSaml2Auth()->getLastMessageId();
        // Add your own code preventing reuse of a $messageId to stop replay attacks

        // assign data dari message saml
        $user = $event->getSaml2User();
        $userData = [
            'id' => $user->getUserId(),
            'attributes' => $user->getAttributes(),
            'assertion' => $user->getRawSamlAssertion()
        ];

        // find or create role
        $id = $userData['attributes']['USERID'][0];
        $oracleUser = User::findOrFail($id);

        $laravelUser = Users::find($id) ?? new Users();
        foreach ($laravelUser->getFillable() as $key) {
            if (isset($oracleUser[$key])) {
                $laravelUser[$key] = $oracleUser[$key];
            }
        }
        $laravelUser->use_oracle = true;
        $laravelUser->is_local = false;
        // $laravelUser->save();

        if ($laravelUser->getActiveRole() == null) {
            $laravelUser->createDefaultRole();
        }

        // assign role user
        $role = Role::where('name', Role::getRole('USER'))->firstOrFail();
        if ($laravelUser->hasRoleId($role->id) == false) {
            $role->user_roles()->create([
                'id_user' => $laravelUser['id']
            ]);
        }

        // set roles and active role
        $roles = $laravelUser->getRoles();
        $laravelUser->setRoles($roles);
        $laravelUser->setActiveRole($laravelUser->getActiveRole());

        // save cache and login
        Users::saveCache($laravelUser);
        Auth::login($laravelUser);
    }
}
