<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\Page;
use App\Models\PageDescription;

class PagesController extends FrontController
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
        $data['listPage'] = Page::all();
        return view('page.index', $data);
    }

    public function page_edit($id){
        $data['pageModel'] = Page::where('id', $id)->first();
        $data['listDescriptionPage'] = PageDescription::where('page_id', $id)->get();
        return view('page.edit_page', $data);
    }

    public function des_page_edit($id){
        $data['des_pageModel'] = PageDescription::where('id', $id)->first();
        return view('page.des_page_edit', $data);
    }

    public function page_update(Request $request){
        $arr = array('name' => $request->input('name'), 'description' => $request->input('description'), $request->input('active') == "on" ? 1 : 0 );
        Page::where('id', $request->input('id'))->update($arr);
        session()->flash('msg','Updated successfully');
        return redirect()->to('page');
    }

    public function des_page_update(Request $request){
        $arr = array(
            'title' => $request->input('title'), 
            'page_id' => $request->input('page_id'), 
            'index' => $request->input('index'), 
            'description' => $request->input('description'), 
            'icon' => $request->input('icon'), 
            'active' => $request->input('active') == "on" ? 1 : 0
            );
        PageDescription::where('id', $request->input('id'))->update($arr);
        session()->flash('msg','Updated successfully');
        return redirect()->to('page');
    }
}
