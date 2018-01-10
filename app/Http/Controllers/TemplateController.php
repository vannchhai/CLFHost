<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;
use App\Models\PageDescription;

class TemplateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->getAbout(1);
        $this->getFeature(2);
        $this->getReview(3);
        $this->getScreens(4);
        $this->getDemo(5);
        $this->getApp(6);
        $this->getSupport(7);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function getAbout($id){
        $aboutObj = Page::where('id', $id)->first();
        $aboutObjDescription = PageDescription::where('page_id', $aboutObj->id)->get();
        view()->share('aboutTitle', $aboutObj->name);
        view()->share('aboutDescription', $aboutObj->description);
        view()->share('aboutDescriptionList', $aboutObjDescription);
    }

    public function getFeature($id){
        $fObj = Page::where('id', $id)->first();
        $fObjDescriptionLeft = PageDescription::where('page_id', $fObj->id)->where('index', '>=', 1)->where('index', '<=', 5)->get();
        $fObjDescriptionRight = PageDescription::where('page_id', $fObj->id)->where('index', '>=', 6)->where('index', '<=', 10)->get();
        view()->share('featureTitle', $fObj->name);
        view()->share('featureDescription', $fObj->description);
        view()->share('featureDescriptionLeftList', $fObjDescriptionLeft);
        view()->share('featureDescriptionRightList', $fObjDescriptionRight);
    }

    public function getReview($id){
        $rObj = Page::where('id', $id)->first();
        view()->share('reviewTitle', $rObj->name);
        view()->share('reviewDescription', $rObj->description);
    }

    public function getScreens($id){
        $sObj = Page::where('id', $id)->first();
        $sObjDescription = PageDescription::where('page_id', $sObj->id)->get();

        view()->share('screenTitle', $sObj->name);
        view()->share('screenDescription', $sObj->description);
        view()->share('screenDescriptionList', $sObjDescription);
    }

    public function getDemo($id){
        $dObj = Page::where('id', $id)->first();
        $dObjDescription = PageDescription::where('page_id', $dObj->id)->get();

        view()->share('demoTitle', $dObj->name);
        view()->share('demoDescription', $dObj->description);
        view()->share('demoDescriptionList', $dObjDescription);
    }

    public function getApp($id){
        $gObj = Page::where('id', $id)->first();
        $gObjDescription = PageDescription::where('page_id', $gObj->id)->get();

        view()->share('getAppTitle', $gObj->name);
        view()->share('getAppDescription', $gObj->description);
        view()->share('getAppDescriptionList', $gObjDescription);
    }

    public function getSupport($id){
        $sObj = Page::where('id', $id)->first();
        $sObjDescription = PageDescription::where('page_id', $sObj->id)->get();

        view()->share('supportTitle', $sObj->name);
        view()->share('supportDescription', $sObj->description);
        view()->share('supportDescriptionList', $sObjDescription);
    }
}
