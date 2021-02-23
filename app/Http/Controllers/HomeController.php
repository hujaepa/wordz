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
        $wordOfToday = Word_of_today::where("user_id",Auth::id())
            ->first();
        // dd($wordOfToday->user_id);
        //GET CURRENT DATE
        $current = Carbon::now();
        // dd($wordOfToday);
        if(!isset($wordOfToday->user_id)){
            $fav = $this->randomFav();
            $wot = new Word_of_today();
            $wot->word_id=$fav->id;
            $wot->user_id=$fav->added_by;
            $wot->save();
            $fetchWOT = $fav->word;
        }
        else if($wordOfToday->created_at > $current){
            $fav = $this->randomFav();
            Word_of_today::where("user_id",$fav->added_by)
                ->update(["word_id"=>$fav->id]);
            $fetchWOT = $fav->word;
        }
        else {
            $fetchWOT = Word_of_today::join('favourites', 'word_of_today.word_id', '=', 'favourites.id')
            ->select('favourites.word')
            ->first();
        }
        
        return view('home',["word"=>$fetchWOT]);
    }
}
