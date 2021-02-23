<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function index()
    {
        $wordOfToday = DB::table("favourites")
            ->select("word")
            ->where("added_by","=",Auth::id())
            ->inRandomOrder()
            ->limit(1)
            ->get();
        return view('home',["word"=>$wordOfToday]);
    }
}
