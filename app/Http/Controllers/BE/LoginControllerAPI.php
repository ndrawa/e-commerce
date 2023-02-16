<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Users;
use Illuminate\Support\Facades\Auth;

class LoginControllerAPI extends Controller
{
    public function exe(Request $request)
    {
        // get username & password
        $username = $request->post('username');
        $password = $request->post('password');

        // hash password
        $pass = '$BSSVPRNHGB$' . substr(md5(md5($password)), 0, 50);
        // dd($pass);

        // Use SSO API ? 1: Use | 0: Not Use
        $use_sso = 0;

        // by pass SSO API
        $byPassArr = [
            "@btp.or.id",
            "@ib.btp.or.id"
        ];

        foreach ($byPassArr as $item) {
            if (strpos($username, $item))
                $use_sso = 0;
        }

        // use SSO API
        if ($use_sso) {
            // sso api code here
        }

        // not use SSO API
        else {
            $data = Users::where('user_username', $username)->first();

            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email tidak ditemukan'
                ]);
            }

            if ($data->password != $pass) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password salah',
                ]);
            }
        }

        // Set Roles
        $roles = [];
        // dd($data->user_role);
        foreach ($data->user_role as $user_role) {
            array_push($roles, $user_role->role->role_name);
        }
        if (empty($roles)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda belum mempunyai akses kedalam Aplikasi. Silahkan hubungi admin kami.',
            ]);
        }

        Session::flush();
        Session::put('login', true);
        Session::put('userId', $data->id);
        Session::put('names', $data->name);
        Session::put('userRoles', $roles[0]);

        // dd(session()->all());

        return redirect(route('dashboard.index'));
    }

    public function login(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');
        $pass = '$BSSVPRNHGB$' . substr(md5(md5($password)), 0, 50);
        // dd($pass);

        $data = Users::where('email', $email)->first();
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak ditemukan'
            ]);
        }
        if ($data->password != $pass) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password salah',
            ]);
        }

        if ($data->use_oracle) {
            $oracleUser = User::find($data->id);
            if ($oracleUser) {
                foreach ($data->getFillable() as $key) {
                    if (isset($oracleUser[$key])) {
                        $data[$key] = $oracleUser[$key];
                    }
                }
            }
            $data->use_oracle = true;
            $data->is_local = true;
            $data->save();
        }
        if ($data->getActiveRole() == null) {
            $data->createDefaultRole();
        }
        // assign role user
        $role = Role::where('name', Role::getRole('USER'))->firstOrFail();
        if ($data->hasRoleId($role->id) == false) {
            $role->user_roles()->create([
                'id_user' => $data['id']
            ]);
        }
        // set roles and active role
        $roles = $data->getRoles();
        $data->setRoles($roles);
        $data->setActiveRole($data->getActiveRole());

        // save cache and login
        Users::saveCache($data);
        Auth::login($data);

        // set session with named 'login'
        Session::put('login', true);

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
        ]);
    }

    public function logout()
    {
        // Session::flush();
        Users::forgetCache(Auth::user());
        Auth::logout();
        Session::save();
        return redirect('/');
    }
}
