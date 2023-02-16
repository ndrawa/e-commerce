<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Role;
use App\Models\UserRole;

class AdminControllerAPI extends Controller
{
    public function dt()
    {
        $role = Role::where('name', Role::getRole('ADMIN'))->first();
        $user_roles = UserRole::where('id_role', $role->id)->orderBy('id_user', 'asc')->get();

        return datatables($user_roles)
            ->addIndexColumn()
            ->editColumn('id_user', function ($db) {
                $name = $db->user->name ?? '';
                $nomor_induk = $db->user['nomor induk'] ?? '';
                return $name . ' - ' . explode("-", $nomor_induk)[0];
            })
            ->editColumn('email', function ($db) {
                
                return $db->user->email ?? '';
            })
            ->addColumn('action', function ($db) {
                return '<a href="javascript:edit(\'' . $db->user->id . '\')" title="Edit Data" class="btn btn-sm btn-icon btn-primary"><i class="bx bx-edit"></i></a>
                        <a href="javascript:del(\'' . $db->user->id . '\')" title="Delete Data" class="btn btn-sm btn-icon btn-danger"><i class="bx bx-trash"></i></a>';
            })
            ->rawColumns(['action'])->toJson();
    }

    public function save(Request $request)
    {
        try {
            $inp = $request->inp;
            $role = Role::where('name', Role::getRole('ADMIN'))->first();

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
            $dbs->save();

            $user_role = UserRole::where([['id_user', $inp['id']], ['id_role', $role->id]])->first() ?? new UserRole();
            $user_role['id_role'] = $role->id;
            $user_role['id_user'] = $dbs->id;
            $user_role['description'] = $role->key;

            if ($user_role->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menyimpan Admin',
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal assign Admin',
        ]);
    }

    public function getById($id)
    {
        return Users::find($id)->toJson();
    }

    public function delete($id)
    {
        try {
            $userRole = UserRole::findOrFail($id);
            $userRole->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus Admin',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus Admin',
            ]);
        }
    }

    //-----------------------------------------------------------------------
    // Custom Function Place HERE !
    //-----------------------------------------------------------------------

}
