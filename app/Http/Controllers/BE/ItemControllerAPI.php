<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\ItemCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemControllerAPI extends Controller
{
    public function dt()
    {
        $data = Item::all();

        return datatables($data)
            ->addIndexColumn()
            ->editColumn('image', function ($db) {
                return '<img id="image-preview" src="' . $db->image_path . '" style="max-height: 60px; width: auto;"/>';
            })
            ->editColumn('item_desc', function ($db) {
                return '<span>' . Str::limit($db->item_desc, 180) . '</span>';
            })
            ->editColumn('updated_at', function ($db) {
                return Carbon::parse($db->updated_at)->format('d M Y, H:i:s');
            })
            ->addColumn('categories', function ($db) {
                $categories = ItemCategory::where('item_id', $db->id)->get();
                $html = '<td>';
                foreach ($categories as $key => $value) {
                    $category = Category::find($value->category_id);
                    $html .= '<span>' . $category->category_name . '</span>';
                    if ($key == count($categories) - 1) {
                        $html .= '</td>';
                    } else {
                        $html .= '<span>, </span>';
                    }
                }
                return $html;
            })
            ->addColumn('detail', function ($db) {
                return '<a href="' .  url('item/' . $db->id) . '" title="Lihat Data" target="_blank" class="btn btn-sm btn-icon btn-warning"><i class="bx bx-show"></i></a>';
            })
            ->addColumn('action', function ($db) {
                return '<a href="item/' . $db->id . '" title="Edit Data" class="btn btn-sm btn-icon btn-primary"><i class="bx bx-edit"></i></a>
                        <a href="javascript:delItem(\'' . $db->id . '\')" title="Delete Data" class="btn btn-sm btn-icon btn-danger"><i class="bx bx-trash"></i></a>';
            })
            ->escapeColumns([])
            ->rawColumns(['detail', 'file_path', 'action'])->toJson();

    }

    public function save(Request $request)
    {
        try {
            $inp = $request->inp;

            if (!empty($inp['image'])) {
                if ($request->hidden_image) {
                    Storage::delete($request->hidden_image);
                }
                $image = $inp['image'];
                $extension = $inp['image']->extension();
                $imageName = $inp['id'];
                $imageName = time() . '_' . $imageName . '.' . $extension;
                $imagePath = 'images/item';
                Storage::putFileAs($imagePath, $image, $imageName);
                $inp['image'] = $imagePath . '/' . $imageName;
            } else {
                $inp['image'] = $request->hidden_image;
            }

            $dbs = Item::find($inp['id']) ?? new Item();

            $check = Item::where('item_name', 'ILIKE', $inp['item_name'])->withTrashed()->first();
            if ($check && $check->id != $inp['id'] && $check->deleted_at == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Item sudah ada!',
                ]);
            } else if (($check && $check->id == $inp['id']) || ($check && $check->deleted_at != null)) {
                $check->restore();
                $dbs = $check;
                $inp['id'] = $check->id;
            }

            foreach ($inp as $key => $value) {
                $dbs[$key] = $value;
            }
            $dbs->save();

            $categories = $request->category_ids;
            if ($inp['id']) {
                $item_categories = ItemCategory::where('item_id', $inp['id'])->get();
                foreach ($item_categories as $key => $value) {
                    if (!in_array($value->category_id, $categories)) {
                        $value->delete();
                    }
                }
            }

            foreach ($categories as $key => $value) {
                if (Category::find($value)) {
                    $category_id = $value;
                } else {
                    //check if unique is soft deleted
                    $old = Category::where('category_name', $value)->withTrashed()->first();
                    if ($old) {
                        $old->restore();
                        $category_id = $old->id;
                    } else {
                        $category = Category::create([
                            'category_name' => $value,
                        ]);
                        $category_id = $category->id;
                    }
                }

                $item_categories = ItemCategory::where([
                    ['item_id',  $dbs['id']],
                    ['category_id',  $category_id]
                ])->first();
                if (!$item_categories) {
                    ItemCategory::create([
                        "item_id" => $dbs['id'],
                        "category_id" => $category_id,
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan produk',
                'data' => $inp
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menyimpan produk',
        ]);
    }

    public function getById($id)
    {
        return Item::find($id)->toJson();
    }

    public function delete($id)
    {
        try {
            $item = Item::find($id);

            if ($item->image)
                Storage::delete($item->image);

            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus produk',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal menghapus produk',
        ]);
    }

    //-----------------------------------------------------------------------
    // Custom Function Place HERE !
    //-----------------------------------------------------------------------

}
