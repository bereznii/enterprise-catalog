<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Worker;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        if(view()->exists('home')) {

            $request->session()->forget('search_request');

            $workers = Worker::limit(100)->get();

            return view('home')->withTitle('List')->with('workers', $workers);
        }

        abort(404);
    }

    /**
     * Method for searching
     */
    public function search(Request $request) {

        $this->validate($request, [
            'search_request' => 'alpha_num|max:200',
        ]);

        if(view()->exists('home')) {

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

            return view('home')->withTitle('Home')->with('workers', $workers);
        }

        abort(404);
    }

    /**
     * Method for ordering searched list with AJAX
     */
    public function order_ajax(Request $request) {

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
                            <th colspan="3">
                                <a href="/home/create" class="btn btn-primary btn-xs">
                                    <span class="glyphicon glyphicon-plus"></span>Добавить 
                                </a>
                            </th>
                        </tr>
                    </thead><tbody>';

        foreach($workers as $worker) {
    
        $output .= '
                    <tr>
                        <td>'.$worker->id.'</td>
                        <td>'.$worker->name.'</td>
                        <td>'.$worker->position.'</td>
                        <td>'.$worker->hired_at.'</td>
                        <td>'.$worker->salary.'</td>
                        <td>
                        <a href="/home/read/'.$worker->id.'" title="Информация">
                            <span class="glyphicon glyphicon-info-sign"></span>
                        </a>
                        </td><td>
                        <a href="/home/update/'.$worker->id.'" title="Изменить">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        </td>
                    <td>
                        <a href="#demo'.$worker->id.'" data-toggle="collapse" title="Удалить">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
                <tr id="demo'.$worker->id.'" class="collapse">
                    <td colspan="5"></td>
                    <td colspan="3" align="center">Удалить?   <a class="btn btn-default btn-xs" href="/home/delete/'.$worker->id.'">Да</a></td>
                </tr>';
        }
        
        echo $output;
    
    }

    public function read($user_id) {

        if(view()->exists('userinfo')) {

            $worker = Worker::find($user_id);
            
            $supervisor = Worker::find($worker['supervisor']);
            
            return view('userinfo')->withTitle('Information')->with('worker', $worker)->with('supervisor', $supervisor);
        }

        abort(404);
    }

    public function delete($user_id) {

        if(view()->exists('home')) {

            $worker = Worker::find($user_id);
            $worker->delete();

            $items = Worker::where('supervisor', '=', $user_id)->get();
            
            foreach($items as $item) {
                $item->supervisor = NULL;
                $item->save();
            }

            return redirect()->route('home');
        }

        abort(404);
    }

    public function update($user_id) {

        if(view()->exists('userupdate')) {

            $positionArr = ['President', 'Second Management Level', 'Third Management Level', 'Fourth Management Level', 'Fifth Management Level', 'Worker'];

            $worker = Worker::find($user_id);//работник, чьи данные требуется
            $supervisor = Worker::find($worker->supervisor);//данные о руководителе работника
            
            if(isset($worker->supervisor)) {
                if($supervisor) {
                    $accessible_supervisor_position = $positionArr[array_search($worker->position, $positionArr) - 1];
                    $supervisor_list = Worker::where('position', '=', $accessible_supervisor_position)->get();
                } else {
                    $supervisor_list = NULL;
                }
                
            } else if($worker->supervisor == NULL) {
                $accessible_supervisor_position = $positionArr[array_search($worker->position, $positionArr) - 1];
                $supervisor_list = Worker::where('position', '=', $accessible_supervisor_position)->get();
              
            } else {
                $supervisor_list = NULL;
            }
            
            return view('userupdate')->withTitle('Update')->with('worker', $worker)
                                                        ->with('supervisor', $supervisor)
                                                        ->with('positions', $positionArr)
                                                        ->with('supervisor_list', $supervisor_list);//список возможных руководителей
        }

        abort(404);
    }

    public function do_update(Request $request) {

        $this->validate($request, [
            'new_name' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
            'new_salary' => 'digits_between:1,10',
            'new_photo' => 'nullable|file|image|max:2048',
        ]);

        if(view()->exists('userupdate')) {

            $worker = $request->all();

            if(!isset($worker['new_supervisor'])) {
                $worker['new_supervisor'] = '0';//работник с руководителем "0" - президент
            }
            if(!$worker['new_supervisor']) {
                $worker['new_supervisor'] = '0';
            }

            if($request->file('new_photo')) {
                $name = $request->file('new_photo')->getClientOriginalName();
                $photo_name = explode('.', $request->file('new_photo')->getClientOriginalName());
                $photo_name = $worker['user_id'] .'-'. date("YmdHis") . '.' . $photo_name[1];//название фото: пользовательский-id + изначальный формат
                $request->file('new_photo')->storeAs('public', $photo_name);
            } else {
                $photo_name = NULL;
            }
            
            $updated_worker = Worker::find($worker['user_id']);
            $updated_worker->name = $worker['new_name'];
            $updated_worker->position = $worker['new_position'];
            $updated_worker->supervisor = $worker['new_supervisor'];
            $updated_worker->salary = $worker['new_salary'];
            if($photo_name) {
                $updated_worker->photo = $photo_name;
                $request->file('new_photo')->storeAs('public', $photo_name);
            }
            $updated_worker->hired_at = $worker['new_date'];
            $updated_worker->save();

            return redirect()->action('HomeController@read', ['user_id' => $worker['user_id']]);
            
        }

        abort(404);
    }

    public function create() {

        if(view()->exists('usercreate')) {

            $last_worker = Worker::orderBy('id','desc')->limit(1)->get();
            $id = $last_worker[0]['id'] + 1;
            
            $positions = ['President', 'Second Management Level', 'Third Management Level', 'Fourth Management Level', 'Fifth Management Level', 'Worker'];
            $accessible_supervisors = false;

            return view('usercreate')->withTitle('Create')->with('positions', $positions)
                                                            ->with('supervisors', $accessible_supervisors)
                                                            ->with('id', $id);
            
        }

        abort(404);
    }

    public function do_create(Request $request) {

        $this->validate($request, [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:200',//допускает пробелы
            'salary' => 'digits_between:1,10',
        ]);

        if(view()->exists('userinfo')) {

            $last_worker = Worker::orderBy('id','desc')->limit(1)->get();
            $id = $last_worker[0]['id'] + 1;

            $new_worker = $request->all();
            
            if($request->file('photo')) {
                $name = $request->file('photo')->getClientOriginalName();

                $photo_name = explode('.', $request->file('photo')->getClientOriginalName());
                $photo_name = $id .'-'. date("YmdHis") . '.' . $photo_name[1];
                $request->file('photo')->storeAs('public', $photo_name);
            } else {
                $photo_name = NULL;
            }
            if(!isset($new_worker['supervisor'])) {
                $new_worker['supervisor'] = 0;
            }

            $worker = new Worker;
            $worker->name = $new_worker['name'];
            $worker->position = $new_worker['position'];
            $worker->supervisor = $new_worker['supervisor'];
            $worker->hired_at = $new_worker['date'];
            $worker->salary = $new_worker['salary'];
            $worker->photo = $photo_name;
            $worker->save();

            $last_worker = Worker::orderBy('id','desc')->limit(1)->get();
            $id = $last_worker[0]['id'];

            return redirect()->action('HomeController@read', ['user_id' => $id]);
        }

        abort(404);
    }

    /**
     * Method for getting accessible supervisor, those who are higher by 1 management level
     */
    public function accessible_supervisor_ajax(Request $request) {

            $positions = ['President', 'Second Management Level', 'Third Management Level', 'Fourth Management Level', 'Fifth Management Level', 'Worker'];
            $response_supervisors = '';
            
            if($positions[array_search($request->input('pos'), $positions)] != 'President') {
                
                $accessible_supervisors = $positions[array_search($request->input('pos'), $positions) - 1];
                $accessible_supervisors = DB::select('SELECT id, name, position FROM workers WHERE position = :position', ['position' => $accessible_supervisors]);
                
                foreach($accessible_supervisors as $supervisor) {
                    $response_supervisors .= "<option value='" . $supervisor->id . "'>" . $supervisor->name . ", " . $supervisor->id . ", " . $supervisor->position . "</option>";
                }
                echo $response_supervisors;

            } else {
                $response_supervisors .= ""; 
                echo $response_supervisors;
            } 
    }
}
