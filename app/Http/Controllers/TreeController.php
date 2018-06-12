<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TreeController extends Controller
{
    public function show($id) {

        if(view()->exists('tree')) {
            
            $president = DB::select("SELECT id, name, position, hired_at, salary FROM workers WHERE position = 'President'");
            $second_ml_workers = DB::select("SELECT id, name, position, hired_at, salary FROM workers WHERE position = 'Second Management Level' LIMIT 10");

            $requested_list = explode('&', $id);
            

            $third_ml_workers = false;
            $fourth_ml_workers = false;
            $fifth_ml_workers = false;
            $sixth_ml_workers = false;
            $supervisor = false;

            if($id != 'none') {

                if(end($requested_list) > 2) {
                    $supervisor[0] = DB::select("SELECT id, name FROM workers WHERE id = " . $requested_list[0]);
                    $third_ml_workers = DB::select("SELECT id, name, position, hired_at, salary FROM workers WHERE position = 'Third Management Level' AND supervisor = " . $requested_list[0]);
                    
                    if(end($requested_list) > 3) {
                        $supervisor[1] =  DB::select("SELECT id, name FROM workers WHERE id = " . $requested_list[1]);
                        $fourth_ml_workers = DB::select("SELECT id, name, position, hired_at, salary FROM workers WHERE position = 'Fourth Management Level' AND supervisor = " . $requested_list[1]);
                    
                        if(end($requested_list) > 4) {
                            $supervisor[2] =  DB::select("SELECT id, name FROM workers WHERE id = " . $requested_list[2]);
                            $fifth_ml_workers = DB::select("SELECT id, name, position, hired_at, salary FROM workers WHERE position = 'Fifth Management Level' AND supervisor = " . $requested_list[2]);
                            
                            if(end($requested_list) > 5) {
                                $supervisor[3] =  DB::select("SELECT id, name FROM workers WHERE id = " . $requested_list[3]);
                                $sixth_ml_workers = DB::select("SELECT id, name, position, hired_at, salary FROM workers WHERE position = 'Worker' AND supervisor = " . $requested_list[3]);
                            
                            }
                        }
                    }
                }
            }
            
            return view('tree')->withTitle('Tree')->withPresident($president)
                                                    ->with('secondworkers', $second_ml_workers)
                                                    ->with('thirdworkers', $third_ml_workers)
                                                    ->with('fourthworkers', $fourth_ml_workers)
                                                    ->with('fifthworkers', $fifth_ml_workers)
                                                    ->with('workers', $sixth_ml_workers)
                                                    ->with('supervisor', $supervisor);
            
        }

        abort(404);
    }
}
