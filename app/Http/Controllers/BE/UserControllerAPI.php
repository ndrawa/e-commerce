<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Users;
use App\Models\ViewUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserControllerAPI extends Controller
{
    public function dt()
    {
        $data = Users::all();

        return datatables($data)
            ->addColumn('action', function ($db) {
                return '<a href="javascript:edit(\''.$db->user_id.'\')" title="Edit Data" class="btn btn-sm btn-icon btn-primary"><i class="bx bx-edit"></i></a>
                        <a href="javascript:del(\''.$db->user_id.'\')" title="Delete Data" class="btn btn-sm btn-icon btn-danger"><i class="bx bx-trash"></i></a>';
            })
            ->addColumn('roles', function ($db) {
                return '<a href="javascript:role(\''.$db->user_id.'\')" title="Role" class="btn btn-sm btn-icon btn-primary">'.$db->user_role->count().'</a>';
            })
            ->rawColumns(['action', 'roles'])->toJson();
    }

    public function save(Request $request)
    {
        try {
            $inp = $request->inp;
            $dbs = Users::find($inp['id']) ?? new Users();

            if ($inp['password'] != $request['password']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password tidak sama',
                ]);
            }
            
            $check = Users::where('email', $inp['email'])->withTrashed()->first();
            if ($check && $check->id != $inp['id'] && $check->deleted_at == null) {
                if ($check['email'] == $inp['email']) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Email sudah ada',
                    ]);
                }
            } else if (($check && $check->id == $inp['id']) || ($check && $check->deleted_at != null)) {
                $check->restore();
                $dbs = $check;
                $inp['id'] = $check->id;
            }

            foreach ($inp as $key => $value) {
                if ($value)
                    $dbs[$key] = $value;
            }

            $dbs->password = '$BSSVPRNHGB$' . substr(md5(md5($inp['password'])), 0, 50);

            if ($dbs->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menyimpan user',
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menyimpan user',
        ]);
    }

    public function edit(Request $request)
    {
        try {
            $inp = $request->inp;
            $dbs = Users::find($inp['id']) ?? new Users();

            if ($inp['password'] != $request['password']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password tidak sama',
                ]);
            }
            
            $check = Users::where('email', $inp['email'])->withTrashed()->first();
            if (($check && $check->id == $inp['id']) || ($check && $check->deleted_at != null)) {
                $check->restore();
                $dbs = $check;
                $inp['id'] = $check->id;
            }

            foreach ($inp as $key => $value) {
                if ($value)
                    $dbs[$key] = $value;
            }

            if ($inp['password']) {
                $dbs->password = '$BSSVPRNHGB$' . substr(md5(md5($inp['password'])), 0, 50);
            }

            if ($dbs->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menyimpan user',
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menyimpan user',
        ]);
    }

    public function getById($id)
    {
        return Users::find($id)->toJson();
    }

    public function delete($id)
    {
        try {
            Users::find($id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus users',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menghapus users',
        ]);
    }

    public function changeRole($id_role)
    {
        $check = Role::find($id_role);
        if (!$check) {
            return redirect(url()->previous());
        }

        $user = Auth::user();
        if ($user->hasRoleId($id_role) == false) {
            return redirect(url()->previous());
        }

        $roles = $user->getRoles();

        $activeRole = null;

        foreach ($roles as $role) {
            if ($role->id == $id_role) $activeRole = $role;
        }

        $user->setActiveRole($activeRole);
        Users::saveCache($user);

        return redirect(url()->previous());
    }
}
