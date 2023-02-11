<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Item::query();

        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%");
        }

        $items = $query->get();

        return view('items.index', compact('items', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'max:100',
            'price' => 'integer | required',
            'quantity' => 'required',
        ]);
            
            // 記述方法：Validator::make('値の配列', '検証ルールの配列');
            
        if ($validator->fails()) {
            return redirect('/items/create')
            ->withErrors($validator)
            ->withInput();
        } else {
            $item = new Item;
            // フォームから送られてきたデータをそれぞれ代入
            $item->name = $request->name;
            $item->description = $request->description;
            $item->price = $request->price;
            $item->quantity = $request->quantity;
            $item->image = $request->image;

            if(request('image')) {
                $name = request()->file('image')->getClientOriginalName();
                request()->file('image')->storeAs('public/images',$name);
                $item->image = $name;
            }
            // データベースに保存
            $item->save();
            // indexの変数用
            $keyword = $request->input('keyword');
            $query = Item::query();
            $items = $query->get();
            // indexに遷移
            return view('items.index', ['msg' => 'OK'],compact('keyword','items'));
        }
        
        // 記述方法：if($validator->fails()) {失敗時の処理} else {成功時の処理}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id); // idでItemを探し出す
        return view('items.show', ['item' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return view('items.edit', ['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->save();
        return redirect('items/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect('/items');
    }

    public function postValidates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'max:100',
            'price' => 'integer | required',
            'quantity' => 'required',
        ]);
            
            // 記述方法：Validator::make('値の配列', '検証ルールの配列');
            
        if ($validator->fails()) {
            return redirect('/errorpage')
            ->withErrors($validator)
            ->withInput();
        } else {
            $item = new Item;
            // フォームから送られてきたデータをそれぞれ代入
            $item->name = $request->name;
            $item->description = $request->description;
            $item->price = $request->price;
            $item->quantity = $request->quantity;
            // データベースに保存
            $item->save();
            $keyword = $request->input('keyword');
            $query = Item::query();
            $items = $query->get();
            return view('items.index', ['msg' => 'OK'],compact('keyword','items'));
        }
        
        // 記述方法：if($validator->fails()) {失敗時の処理} else {成功時の処理}
    }
}
