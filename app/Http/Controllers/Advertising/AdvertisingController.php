<?php

namespace App\Http\Controllers\Advertising;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontController;
use App\Models\Advertising;

class AdvertisingController extends FrontController
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
        $data['listAdvertising'] = Advertising::all();
        return view('advertising.index', $data);
    }

    public function ads_edit($id){
        $data['adsModel'] = Advertising::where('id', $id)->first();
        return view('advertising.edit_advertising', $data);;
    }

    public function ads_update(Request $request)
    {
        $arr = array(
            'slug' => $request->input('slug'), 
            'provider_name' => $request->input('name'), 
            'tracking_code_large' => $request->input('tcl'), 
            'tracking_code_medium' => $request->input('tcm'), 
            'tracking_code_small' => $request->input('tcs'), 
            'active' => $request->input('active') == "on" ? 1 : 0
            );
        Advertising::where('id', $request->input('id'))->update($arr);
        session()->flash('msg','Advertising has updated successfully');
        return redirect()->to('advertising');
    }

    public function ads_block($id){
         if (isset($id)) {
            $arr = Advertising::where('id', $id)->first();
            $data = array(
                'id' => $arr->id,
                'slug' => $arr->slug,
                'provider_name' => $arr->provider_name,
                'tracking_code_large' => $arr->tracking_code_large,
                'tracking_code_medium' => $arr->tracking_code_medium,
                'tracking_code_small' => $arr->tracking_code_small,
                'active' => 0,
                );
            Advertising::where('id', $id)->update($data);
            session()->flash('msg','Item has been Block successfully');
        }
        return redirect()->to('/advertising');
    }

     public function ads_reblock($id){
         if (isset($id)) {
            $arr = Advertising::where('id', $id)->first();
            $data = array(
                'id' => $arr->id,
                'slug' => $arr->slug,
                'provider_name' => $arr->provider_name,
                'tracking_code_large' => $arr->tracking_code_large,
                'tracking_code_medium' => $arr->tracking_code_medium,
                'tracking_code_small' => $arr->tracking_code_small,
                'active' => 1,
                );
            Advertising::where('id', $id)->update($data);
            session()->flash('msg','Item has been Block successfully');
        }
        return redirect()->to('/advertising');
    }
}
