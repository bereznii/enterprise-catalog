<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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

            $workers = DB::select("SELECT * FROM workers LIMIT 100");

            return view('home')->withTitle('List')->with('workers', $workers);
        }

        abort(404);
    }

    public function refresh(Request $request) {

        if(view()->exists('home')) {

            $request->session()->forget('search');

            return redirect()->route('home');
        }

        abort(404);
    }

    public function order($info, Request $request) {

        if(view()->exists('home')) {

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
                if($i > 4) {
                    $workers = false;
                    break;
                }
            }
            
            return view('home')->withTitle('List')->with('workers', $workers);
        }

        abort(404);
    }

    public function read($user_id) {

        if(view()->exists('userinfo')) {

            $worker = DB::select('SELECT * FROM workers WHERE id = :id', ['id' => $user_id]);

            $supervisor = DB::select('SELECT * FROM workers WHERE id = :id', ['id' => $worker[0]->supervisor]);

            return view('userinfo')->withTitle('Information')->with('worker', $worker)->with('supervisor', $supervisor);
        }

        abort(404);
    }

    public function delete($user_id) {

        if(view()->exists('home')) {

            DB::delete('DELETE FROM workers WHERE id = :id', ['id' => $user_id]);

            $items = DB::select('SELECT * FROM workers WHERE supervisor = :supervisor', ['supervisor' => $user_id]);

            foreach($items as $item) {
                DB::update('UPDATE workers SET supervisor = NULL WHERE supervisor = :supervisor', ['supervisor' => $user_id]);
            }

            return redirect()->route('home');
        }

        abort(404);
    }

    public function update($user_id) {

        if(view()->exists('userupdate')) {

            $positionArr = ['President', 'Second Management Level', 'Third Management Level', 'Fourth Management Level', 'Fifth Management Level', 'Worker'];

            $worker = DB::select('SELECT * FROM workers WHERE id = :id', ['id' => $user_id]); //работник, чьи данные требуется
            $supervisor = DB::select('SELECT * FROM workers WHERE id = :id', ['id' => $worker[0]->supervisor]);//данные о руководителе работника
            
            if($worker[0]->supervisor) {
                if(!$supervisor) {
                    $accessible_supervisor_position = $positionArr[array_search($worker[0]->position, $positionArr) - 1];
                } else {
                    $accessible_supervisor_position = $positionArr[array_search($supervisor[0]->position, $positionArr)];//название позиции руководителя
                }
                $supervisor_list = DB::select('SELECT * FROM workers WHERE position = :position', ['position' => $accessible_supervisor_position]);
                
            } else if($worker[0]->supervisor == NULL) {
                $accessible_supervisor_position = $positionArr[array_search($worker[0]->position, $positionArr) - 1];
                $supervisor_list = DB::select('SELECT * FROM workers WHERE position = :position', ['position' => $accessible_supervisor_position]);
              
            } else {
                $supervisor_list = NULL;
            }
            //dump($worker);
            return view('userupdate')->withTitle('Update')->with('worker', $worker)
                                                        ->with('supervisor', $supervisor)
                                                        ->with('positions', $positionArr)
                                                        ->with('supervisor_list', $supervisor_list);
        }

        abort(404);
    }

    public function do_update(Request $request) {

        if(view()->exists('userupdate')) {

            $worker = $request->all();

            //$worker['user_id']
            //$worker['new_name']
            //$worker['new_position']
            //$worker['new_supervisor']
            //$worker['new_salary']
            //$worker['new_photo']
            if($worker['new_supervisor'] == 'NULL') {
                $worker['new_supervisor'] = 0;
            }

            $name = $request->file('new_photo')->getClientOriginalName();

            $photo_name = explode('.', $request->file('new_photo')->getClientOriginalName());
            $photo_name = $worker['user_id'] . '.' . $photo_name[1];
            
            DB::update("UPDATE workers SET name = '" . $worker['new_name'] . 
                                        "', position = '" . $worker['new_position'] . 
                                        "', supervisor = '"  . $worker['new_supervisor'] .
                                        "', salary = '" . $worker['new_salary'] .
                                        "', hired_at = '" . $worker['new_date'] .
                                        "', photo = '" . $photo_name .
                                        "' WHERE id = ?", [$worker['user_id']]);

            $request->file('new_photo')->storeAs('public', $photo_name);

            return redirect()->action('HomeController@read', ['user_id' => $worker['user_id']]);
            
        }

        abort(404);
    }

    public function create() {

        if(view()->exists('usercreate')) {

            $last_id = DB::select('SELECT id FROM workers ORDER BY id DESC LIMIT 1');
            $id = $last_id[0]->id + 1;
            
            $positions = ['President', 'Second Management Level', 'Third Management Level', 'Fourth Management Level', 'Fifth Management Level', 'Worker'];
            $accessible_supervisors = false;

            return view('usercreate')->withTitle('Create')->with('positions', $positions)
                                                            ->with('supervisors', $accessible_supervisors)
                                                            ->with('id', $id);
            
        }

        abort(404);
    }

    public function do_create(Request $request) {

        if(view()->exists('userinfo')) {

            $new_worker = $request->all();
            
            $last_id = DB::select('SELECT id FROM workers ORDER BY id DESC LIMIT 1');
            $id = $last_id[0]->id;

            if($request->file('new_photo')) {
                $name = $request->file('new_photo')->getClientOriginalName();

                $photo_name = explode('.', $request->file('new_photo')->getClientOriginalName());
                $photo_name = $id . '.' . $photo_name[1];
                $request->file('new_photo')->storeAs('public', $photo_name);
            } else {
                $photo_name = NULL;
            }

            DB::insert('INSERT INTO workers (name, position, supervisor, hired_at, salary, photo) 
                        VALUES (?, ?, ?, ?, ?, ?)', 
                        [
                            $new_worker['new_name'], 
                            $new_worker['new_position'], 
                            $new_worker['new_supervisor'], 
                            $new_worker['new_date'], 
                            $new_worker['new_salary'],
                            $photo_name
                        ]);

            $id++;
            return redirect()->action('HomeController@read', ['user_id' => $id]);
        }

        abort(404);
    }

    public function accessible_supervisor_ajax(Request $request) {

            $positions = ['President', 'Second Management Level', 'Third Management Level', 'Fourth Management Level', 'Fifth Management Level', 'Worker'];
            $response_supervisors = '';
            
            if($positions[array_search($request->input('ccId'), $positions)] != 'President') {
                
                $accessible_supervisors = $positions[array_search($request->input('ccId'), $positions) - 1];
                $accessible_supervisors = DB::select('SELECT id, name, position FROM workers WHERE position = :position', ['position' => $accessible_supervisors]);
                
                foreach($accessible_supervisors as $supervisor) {
                    $response_supervisors .= "<option value='" . $supervisor->id . "'>" . $supervisor->name . ", " . $supervisor->id . ", " . $supervisor->position . "</option>";
                }
                echo $response_supervisors;

            } else {
                $response_supervisors .= "<option>". "-" ."</option>"; 
                echo $response_supervisors;
            }
            
    }
}
