<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Favourites;
use App\Word_of_today;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    private function randomFav()
    {
        return Favourites::select("id","added_by","word")
            ->where("added_by","=",Auth::id())
            ->inRandomOrder()
            ->limit(1)
            ->first();
    }
    public function index()
    {
        $fetchWOT = $this->randomFav();
        
        return view('home',["word"=>$fetchWOT]);
    }
}
