<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Search extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view("search.form");
    }

    public function result(Request $request)
    {
        $url = 'https://api.dictionaryapi.dev/api/v2/entries/en_US';
        $word = $request->search;
        
        $request_url = $url . '/' . $word;
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//ignore ssl url
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($curl);
        if(!curl_exec($curl)) {
            $info["status"]=false;
            $info["curl_error"]='Curl error: ' . curl_error($curl);
        }
        else {
            curl_close($curl);
            $words=json_decode($response);
            // dd($words);
            /*
            1.Check if word has an array return
            2.Check if meanings isset & has more than one index
            */
            if(is_array($words)) {//means there are infos
                $info["status"]=true;
                $info["word"]=$words[0]->word;
                $meanings=$words[0]->meanings;
                //dd($words);
                if(is_array($meanings)){
                    $total_meanings=count($meanings);
                    $info["total_meanings"]=$total_meanings;
                    for ($i=0; $i < $total_meanings; $i++) {
                        $info["partOfSpeech"][$i]=$meanings[$i]->partOfSpeech;//fetch partof speech property
                        $info["definition"][$i]=$meanings[$i]->definitions[0]->definition;//grab its definition
                        if(isset($meanings[$i]->definitions[0]->example))
                            $info["example"][$i]=$meanings[$i]->definitions[0]->example;//grab its example
                    }
                }
                if(isset($words[0]->meanings[0]->definitions[0]->synonyms)){
                    $synonyms=$words[0]->meanings[0]->definitions[0]->synonyms;
                    // dd($synonyms);
                    $total_synonyms=count($synonyms);
                    $info["total_synonyms"]=$total_synonyms;
                    for ($i=0; $i <$total_synonyms ; $i++) { 
                       $info["synonyms"][$i]=$synonyms[$i];
                    }
                }
            }
            else {//no infos
                $info["status"]=false;
                $info["message"]=$words->message;
            }
        }
        return view("search.form",["info"=>$info])->with("word",$word);
    }
}
