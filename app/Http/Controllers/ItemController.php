<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        // TODO: データをすべて取得
        // SELECT * FROM items;
        $items = Item::get();
        $data['items'] = $items;

        // views/item/index.blade.php
        return view('item.index', $data);
    }

    public function create()
    {
        // views/item/create.blade.php
        return view('item.create');
    }

    public function store(ItemRequest $request)
    {
        $data = $request->all();
        Item::create($data);
        return redirect(route('item.index'));
    }

    public function show(int $id)
    {
        // $items[1] = "コーヒー";
        // $items[2] = "紅茶";
        // $items[3] = "ほうじ茶";
        $items = [
            1 => 'コーヒー',
            2 => '紅茶',
            3 => 'ほうじ茶',
        ];
        $item = "";
        if ($id > 0 && in_array($id, array_keys($items))) {
            $item = $items[$id];
        }
        // ビューに受け渡すデータ生成
        $data = ['item' => $item];

        // reources/views/item/show.blade.php を表示
        // データを受け渡す
        return view('item.show', $data);
    }

    public function edit(int $id)
    {
        //商品IDから商品データを取得
        // SELECT * FROM items WHERE id = xx;
        $item = Item::find($id);
        $data['item'] = $item;
        //編集画面を表示
        return view('item.edit', $data);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->all();
        // dd($data);
        // UPDATE items SET price = xxx WHERE id = xx;
        // 1. Query Builder
        // unset($data['_token']);
        // Item::where('id', $id)->update($data);
        // DB::table('items')->where('id', $id)->update($data);
        // 2. Eloquent
        // SELECT * FROM items WHERE id = xx;
        // UPDATE items SET price = xxx WHERE id = xx;
        Item::find($id)->fill($data)->save();

        //リダイレクト
        return redirect(route('item.edit', $id));
    }

    public function destroy(int $id)
    {
        // DELETE FROM items WHERE id = xx;
        Item::destroy($id);
        // 一覧画面にリダイレクト
        return redirect(route('item.index'));
    }
}