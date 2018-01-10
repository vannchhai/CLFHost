<?php

namespace App\Http\Controllers\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\Item;
use App\Models\ItemCategory;

class ItemsController extends FrontController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['listItem'] = Item::select('item.*', 'users.name', 'type.type_name', 'item_category.category_name')
        ->join('users', 'users.id', '=', 'item.user_id')
        ->join('type', 'type.id','=','item.item_type_id')
        ->join('item_category', 'item_category.id', '=', 'item.item_category_id')->get();
        return view('item.index', $data);
    }

    public function block($id)
    {
        if (isset($id)) {
            $arr = Item::where('id', $id)->first();
            $data = array(
                'id' => $arr->id,
                'item_name' => $arr->item_name,
                'item_type_id' => $arr->item_type_id,
                'item_category_id' => $arr->item_category_id,
                'item_description' => $arr->item_description,
                'contact_number' => $arr->contact_number,
                'user_id' => $arr->user_id,
                'location_id' => $arr->location_id,
                'item_gallery_id' => $arr->item_gallery_id,
                'active' => 0,
                );
            Item::where('id', $id)->update($data);
            session()->flash('msg','Item has been Block successfully');
        }
        return redirect()->to('/item');
    }

    public function reblock($id)
    {
        if (isset($id)) {
            $arr = Item::where('id', $id)->first();
            $data = array(
                'id' => $arr->id,
                'item_name' => $arr->item_name,
                'item_type_id' => $arr->item_type_id,
                'item_category_id' => $arr->item_category_id,
                'item_description' => $arr->item_description,
                'contact_number' => $arr->contact_number,
                'user_id' => $arr->user_id,
                'location_id' => $arr->location_id,
                'item_gallery_id' => $arr->item_gallery_id,
                'active' => 1,
                );
            Item::where('id', $id)->update($data);
            session()->flash('msg','Item has Availble successfully');
        }
        return redirect()->to('/item');
    }

    public function itemCategory()
    {
        $data['listCateogry'] = ItemCategory::all();
        return view('item.list_category', $data);
    }

    public function createCategory(){
        $data['categoryModel'] = [];
        return view('item.create_category', $data);
    }

    public function detailCategory($id){
        $data['categoryModel'] = ItemCategory::where('id', $id)->first();
         return view('item.detail_category', $data);
    }

    public function editCategory($id){
        $data['categoryModel'] = [];
        if (isset($id)) {
            $data['categoryModel'] = ItemCategory::where('id' , $id)->first();
        }
        return view('item.create_category', $data);
    }

    public function deleteCategory($id){
        ItemCategory::where('id', $id)->delete();
        session()->flash('msg','Category has Deleted successfully');
        return redirect()->to('itemCategory');
    }

    public function categoryInsert(Request $request){
        $arr = array(
            'category_name' => $request->input('name'),
            'active' => $request->input('active') == "on" ? 1 : 0
            );
        $insert = new ItemCategory($arr);
        $insert->save();
        session()->flash('msg','Category has inserted successfully');
        return redirect()->to('itemCategory');
    }

    public function categoryUpdate(Request $request){
        $arr = array(
            'category_name' => $request->input('name'), 
            'active' => $request->input('active') == "on" ? 1 : 0, 
            );
        ItemCategory::where('id', $request->input('id'))->update($arr);
        session()->flash('msg','Category has updated successfully');
        return redirect()->to('itemCategory');
    }
}
