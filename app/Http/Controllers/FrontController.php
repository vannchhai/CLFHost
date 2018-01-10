<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = null;
        // From Laravel 5.3.4 or above
		$this->middleware(function ($request, $next)
		{
			$this->getAuth();
            $this->getUser();
            $this->getItem();
            $this->getPageAbout();
			return $next($request);
		});
    }

    public function getAuth(){
    	$this->user = $this->checkUser();
    	view()->share('user', $this->user);
    }

    public function getUser(){
        $countUser = User::where('id', '!=', 1)->get();
        view()->share('countUser', sizeof($countUser));
    }

    public function getItem(){
        $countItem = Item::where('active', 1)->get();
        view()->share('countItem', sizeof($countItem));
    }

    public function getPageAbout(){
        $obj = Page::where('id', 1)->first();
        view()->share('aboutTitle', "About");
    }
    /**
     * Check if User is logged
     *
     * @return bool
     */
    public function checkUser()
    {
        if (Auth::check()) {
            $this->user = Auth::user();
            view()->share('user', $this->user);
            $this->userLevel = 'user';
            
            return $this->user;
        }
        
        return false;
    }
}
