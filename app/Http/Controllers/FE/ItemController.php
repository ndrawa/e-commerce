<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return view('oa.item.index');
    }

    public function home(Request $request)
    {
        $items = $this->searchItemandCategory($request);
        $categories = Category::all();
        $times = Item::select('updated_at')->distinct()->get();
        $parCategory = null;
        if ($request->has('category')) {
            $parCategory = Category::find($request->category);
            $parCategory = (!empty($parCategory)) ? $parCategory->category_name : null;
        }


        return view('landing-page.item', [
            'items' => $items,
            'categories' => $categories,
            'times' => $times,
            'parCategory' => $parCategory,
        ]);
    }

    public function searchItemandCategory(Request $request)
    {
        if ($request->has('search')) {
            return Item::where('item_name', 'ilike', "%" . $request->search . "%")->paginate(8);
        } else if ($request->has('category')) {
            $category = Category::find($request->category);
            if ($category) {
                $item_id = ItemCategory::select('item_id')->where('category_id', $category->id)->distinct()->get()->toArray();
                return Item::whereIn('id', array_column($item_id, 'item_id'))->paginate(8);
            }
        }

        return Item::orderBy('updated_at', 'desc')->paginate(8);
    }

    public function detail($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return back();
            // return redirect()->route('home.item');
        }

        return view('landing-page.item_detail', [
            'item' => $item
        ]);
    }

    public function add()
    {
        $item = new Item();
        $categories = Category::all();
        return view('oa.item.add_item', [
            'item' => $item,
            'categories' => $categories,
        ]);
    }

    public function edit($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return back();
        }
        $categories = Category::all();
        return view('oa.item.add_item', [
            'item' => $item,
            'categories' => $categories,
        ]);
    }
}
