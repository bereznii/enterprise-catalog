@extends('layouts.app')

@section('content')
        <div class="main-section">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Информация о сотруднике # {{$worker[0]->id}}
                </div>
                <div class="panel-body">
                    <form action="/home/do_update" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{$worker[0]->id}}">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Поле</th>
                            <th>Информация</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <tr>
                            <td>#</td>
                            <td>{{$worker[0]->id}}</td>
                        </tr>
                        <tr>
                            <td>ФИО</td>
                            <td><input class="form-control" type="text" placeholder="" value="{{$worker[0]->name}}" name="new_name" required></td>
                        </tr>
                        <tr>
                            <td>Должность</td>
                            <td>
                                <select class="form-control"  name="new_position" id="sel1">
                                    @foreach($positions as $position)
                                        @if($position == $worker[0]->position)
                                            <option selected="selected" value="{{$position}}">{{$position}}</option>
                                        @else
                                        <option value="{{$position}}">{{$position}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Руководитель</td>
                            <td>
                                <select class="form-control" name="new_supervisor" id="sel2">
                                </select>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>Дата приема на работу</td>
                            <td><input class="form-control" type="date" value="{{$worker[0]->hired_at}}" name="new_date"></td>
                        </tr>
                        <tr>
                            <td>Размер заработной платы</td>
                            <td><input class="form-control" type="text" placeholder="" value="{{$worker[0]->salary}}" name="new_salary" required></td>
                        </tr>
                        <tr>
                            <td>Фотография сотрудника</td>
                            <td><img src="{{asset('storage/') . '/' . $worker[0]->photo}}" alt="Фото отсутствует" style="max-width:200px; max-height:200px;">
                                <hr>
                                <input type="file" class="form-control-file" name="new_photo">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" class="btn btn-primary">Изменить</button></td>
                        </tr>
                    </tbody>
                    
                </table>
                </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/user_supervisor.js') }}"></script>
    </body>
</html>
@endsection