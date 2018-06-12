<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class ListController extends Controller
{
    
    public function index(Request $request) {


        if(view()->exists('list')) {

            $request->session()->forget('search');

            $workers = DB::select("SELECT * FROM workers LIMIT 100");

            return view('list')->withTitle('List')->with('workers', $workers);
        }

        abort(404);
    }

    public function order($info, Request $request) {

        if(view()->exists('list')) {

            $columnArr = ['id', 'name', 'position', 'hired_at', 'salary'];

            $workers = false;
            if(!$request->input('search_request')){
                $search = '';
                if($request->session()->get('search')) {
                    $search = "LIKE '%" . $request->session()->get('search') ."%'";
                }
            } else {
                $request->session()->put('search', $request->input('search_request'));
                $search = $request->input('search_request');
                $search = "LIKE '%" . $search ."%'";
            }
            if($info == 'none') {
                $string = '';
            } else {
                $string = explode("&", $info);
                $string = "ORDER BY " . $string[0] . " " . $string[1];
            }

            

            $i = 0;
            while(!$workers) {
                $workers = DB::select("SELECT * FROM workers 
                                                WHERE " . $columnArr[$i] . 
                                                " $search " . 
                                                $string .
                                                " LIMIT 100");
                $i++;
            }
            
            return view('list')->withTitle('List')->with('workers', $workers);
        }

        abort(404);
    }

}
