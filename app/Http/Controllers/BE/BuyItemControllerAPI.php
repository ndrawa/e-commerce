<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\BuyItem;
use App\Models\ItemCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuyItemControllerAPI extends Controller
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

    public function save($id, $qty)
    {
        try {
            $item = Item::find($id);
            if (!$item) {
                if ($qty > $item->item_stock) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Stok tidak mencukupi',
                    ]);
                }
            } else {
                $dbs = new BuyItem();
                $dbs->user_id = auth()->user()->id;
                $dbs->item_id = $id;
                $dbs->quantity = $qty;
                $dbs->save();

                $item->item_stock = $item->item_stock - $qty;
                $item->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil melakukan pembelian',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal melakukan pembelian',
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
