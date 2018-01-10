<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\FrontController;

class UsersController extends FrontController
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
        $data['listUser'] = User::where('id', '!=' , 1)->get();
        return view('user.index', $data);
    }

    public function create()
    {
        $data['userModel'] = [];
        return view('user.create', $data);
    }

    public function edit($id)
    {
        $data['userModel'] = [];
        if (isset($id)) {
            $data['userModel'] = User::where('id' , $id)->first();
        }
        return view('user.create', $data);
    }

    public function delete($id)
    {
        if (isset($id)) {
            $delete = User::where('id' , $id)->first();
            $delete->delete();
            session()->flash('msg','Account has deleted successfully');
        }
        return redirect()->to('/user');
    }

    public function detail($id)
    {
        if (isset($id)) {
            $data['userModel'] = User::where('id' , $id)->first();
            $data['listItems'] = Item::where('item.user_id' , $id)
            ->join('item_category', 'item_category.id' , '=' , 'item.item_category_id')
            ->join('type', 'type.id', '=', 'item.item_type_id')->get();
        }
        return view('user.detail', $data);
    }

    public function insert(Request $request)
    {
        $arr = array(
            'name' => $request->input('name'), 
            'email' => $request->input('email'), 
            'phone' => $request->input('phone'), 
            'sex' => $request->input('gender'), 
            'password' => Hash::make($request->input('password')), 
            'active' => $request->input('active') == "on" ? 1 : 0, 
            );
        $insert = new User($arr);
        $insert->save();
        session()->flash('msg','Account has inserted successfully');
        return redirect('user');
    }

    public function update(Request $request)
    {
        $arr = array(
            'name' => $request->input('name'), 
            'email' => $request->input('email'), 
            'phone' => $request->input('phone'), 
            'sex' => $request->input('gender'), 
            'password' => Hash::make($request->input('password')), 
            'active' => $request->input('active') == "on" ? 1 : 0, 
            );
        User::where('id', $request->input('id'))->update($arr);
        session()->flash('msg','Account has updated successfully');
        return redirect('user');
    }
}
