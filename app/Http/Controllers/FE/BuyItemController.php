<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\BuyItem;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class BuyItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('oa.buy.index', [
            'items' => $items,
        ]);
    }

    public function history()
    {
        $buyItems = BuyItem::all();
        return view('oa.buy.history', [
            'buyItems' => $buyItems,
        ]);
    }

    public function detail($id)
    {
        $buyItem = BuyItem::find($id);
        return view('oa.buy.history_detail', [
            'buyItem' => $buyItem,
        ]);
    }
}
