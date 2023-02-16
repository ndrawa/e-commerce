<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ItemCategory;
use Illuminate\Http\Request;


class CategoryControllerAPI extends Controller
{
    public function dt()
    {
        $data = Category::all();

        return datatables($data)
            ->addColumn('action', function ($db) {
                return '<a href="javascript:edit(\'' . $db->id . '\')" title="Edit Data" class="btn btn-sm btn-icon btn-primary"><i class="bx bx-edit"></i></a>
                        <a href="javascript:del(\'' . $db->id . '\')" title="Delete Data" class="btn btn-sm btn-icon btn-danger"><i class="bx bx-trash"></i></a>';
            })
            ->rawColumns(['action'])->toJson();
    }

    public function save(Request $request)
    {
        try {
            $inp = $request->inp;
            $dbs = Category::find($inp['id']) ?? new Category();

            $check = Category::where('category_name', 'ILIKE', $inp['category_name'])->withTrashed()->first();
            if ($check && $check->id != $inp['id'] && $check->deleted_at == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kategori item sudah ada!',
                ]);
            } else if (($check && $check->id == $inp['id']) || ($check && $check->deleted_at != null)) {
                $check->restore();
                $dbs = $check;
                $inp['id'] = $check->id;
            }

            foreach ($inp as $key => $value) {
                $dbs[$key] = $value;
                if ($key == 'category_name') {
                    $dbs[$key] = ucfirst($value);
                }
            }

            if ($dbs->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menyimpan kategori item',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menyimpan kategori item',
        ]);
    }

    public function getById($id)
    {
        return Category::find($id)->toJson();
    }

    public function delete($id)
    {
        try {
            Category::find($id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus kategori item',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menghapus kategori item',
        ]);
    }

    //-----------------------------------------------------------------------
    // Custom Function Place HERE !
    //-----------------------------------------------------------------------

}
