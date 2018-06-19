<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Worker;

class TreeController extends Controller
{
    
    public function show() {

        if(view()->exists('tree')) {
            
            $presidents = Worker::where('supervisor','=','0')->get();
            if(!isset($presidents[0])) {
                $presidents = NULL;
            }
            return view('tree')->withTitle('Tree')->with('presidents', $presidents);
            
        }

        abort(404);
    }

    public function showsecond(Request $request) {

        $workers = Worker::where('supervisor', '=', $request->input('id'))->get();

        $output = "<ul class='list-group'>";

        if($workers[0]['position'] == 'Worker') {
            foreach($workers as $worker) {
                $output .="<li class='list-group-item '><p>" . $worker['name'] ." | ". $worker['position'] . "</p></li>";
            }
        } else {
            foreach($workers as $worker) {
                $output .="<li class='list-group-item item". $worker['id'] . "'><p class='some' id='" . $worker['id'] ."' style='cursor: pointer;'><span class='glyphicon glyphicon-menu-right' id='item". $worker['id'] ."'></span>   " . $worker['name'] ." | ". $worker['position'] . "</p><div class='" . $worker['id'] . "'>
                </div></li>";
            }
        }

        $output .= '</ul>';
    
        echo $output;

    }
}
