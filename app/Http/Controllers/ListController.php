<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Worker;

class ListController extends Controller
{
    
    public function index(Request $request) {

        if(view()->exists('list')) {

            $request->session()->forget('search_request');

            $workers = Worker::limit(100)->get();
            
            return view('list')->withTitle('List')->with('workers', $workers);
        }

        abort(404);
    }

    public function search(Request $request) {

        $this->validate($request, [
            'search_request' => 'alpha_num|max:200',
        ]);

        if(view()->exists('list')) {

            $search_request = $request->input('search_request');
            $request->session()->put('search_request', $search_request);
            
            $workers = Worker::where('id', 'LIKE', "%".$search_request."%")
                                            ->orwhere(function ($query) use ($search_request) {
                                                $query->where('name', 'LIKE', "%".$search_request."%")
                                                        ->orWhere('position', 'LIKE', "%".$search_request."%")
                                                        ->orWhereRaw("DATE_FORMAT(hired_at, '%Y-%m-%d') LIKE '%".$search_request."%'")
                                                        ->orWhere('salary', 'LIKE', "%".$search_request."%");
                                            })
                                            ->limit(100)
                                            ->get();

            return view('list')->withTitle('List')->with('workers', $workers);
        }

        abort(404);
    }

    public function order(Request $request) {

            $order = $request->input('order');
            $column_name = $request->input('column_name');

            $output = '';

            if($order == 'desc') {
                $order = 'asc';
            } else {
                $order = 'desc';
            }

            if($request->session()->get('search_request')) {
                $search_request = $request->session()->get('search_request');
            } else {
                $search_request = '';
            }
            

            $workers = Worker::where('id', 'LIKE', "%".$search_request."%")
                                            ->orwhere(function ($query) use ($search_request) {
                                                $query->where('name', 'LIKE', "%".$search_request."%")
                                                        ->orWhere('position', 'LIKE', "%".$search_request."%")
                                                        ->orWhereRaw("DATE_FORMAT(hired_at, '%Y-%m-%d') LIKE '%".$search_request."%'")
                                                        ->orWhere('salary', 'LIKE', "%".$search_request."%");
                                            })
                                            ->orderBy($column_name, $order)
                                            ->limit(100)
                                            ->get();
            
            $output .= '
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><a href="#" class="column_sort" id="id" data-order='.$order.'>#</a></th>
                                <th><a href="#" class="column_sort" id="name" data-order='.$order.'>ФИО</th>
                                <th><a href="#" class="column_sort" id="position" data-order='.$order.'>Должность</th>
                                <th><a href="#" class="column_sort" id="hired_at" data-order='.$order.'>Дата​ ​приема​ ​на​ ​работу</th>
                                <th><a href="#" class="column_sort" id="salary" data-order='.$order.'>Размер​ ​заработной​ ​платы</th>
                                <th>Фото</th>
                            </tr>
                        </thead><tbody>';
            foreach($workers as $worker) {
            
            if($worker->photo) {
                $photo = "
                        <a href=".asset('storage/'. $worker->photo). " data-lightbox='. $worker->photo. ' data-title='{{"."$"."worker->name}}'>
                            <img src=".asset('storage/' .$worker->photo). " style='max-width:20px; max-height:20px;'>
                        </a>";
            } else {
                $photo = '';
            }
        
            $output .= '
                        <tr>
                            <td>'.$worker->id.'</td>
                            <td>'.$worker->name.'</td>
                            <td>'.$worker->position.'</td>
                            <td>'.$worker->hired_at.'</td>
                            <td>'.$worker->salary.'</td>
                            <td>'.$photo.'</td>
                        </tr>';
            }
            
            echo $output;
        
    }
}
