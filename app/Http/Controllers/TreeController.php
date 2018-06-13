<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Worker;

class TreeController extends Controller
{
    public function show($id) {

        if(view()->exists('tree')) {
            
            $president = Worker::where('position', '=', 'President')->get();
            $second_ml_workers =  Worker::where('position', '=', 'Second Management Level')->get();

            $requested_list = explode('&', $id);
            

            $third_ml_workers = false;
            $fourth_ml_workers = false;
            $fifth_ml_workers = false;
            $sixth_ml_workers = false;
            $supervisor = false;

            if($id != 'none') {

                if(end($requested_list) > 2) {
                    $supervisor[0] = Worker::find($requested_list[0]);
                    $third_ml_workers =  Worker::where('position', '=', 'Third Management Level')->where('supervisor', '=', $requested_list[0])->get();
                    
                    if(end($requested_list) > 3) {
                        $supervisor[1] = Worker::find($requested_list[1]);
                        $fourth_ml_workers =  Worker::where('position', '=', 'Fourth Management Level')->where('supervisor', '=', $requested_list[1])->get();
                        
                        if(end($requested_list) > 4) {
                            $supervisor[2] = Worker::find($requested_list[2]);
                            $fifth_ml_workers =  Worker::where('position', '=', 'Fifth Management Level')->where('supervisor', '=', $requested_list[2])->get();

                            if(end($requested_list) > 5) {
                                $supervisor[3] = Worker::find($requested_list[3]);
                                $sixth_ml_workers =  Worker::where('position', '=', 'Worker')->where('supervisor', '=', $requested_list[3])->get();

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
