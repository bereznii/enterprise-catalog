@extends('layouts.app')

@section('content')
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="main-section">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Информация о сотруднике # {{$worker->id}}
                </div>
                <div class="panel-body">
                    <form action="/do_update" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{$worker->id}}">
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
                            <td>{{$worker->id}}</td>
                        </tr>
                        <tr>
                            <td>ФИО</td>
                            <td><input class="form-control" type="text" placeholder="{{$worker->name}}" value="{{$worker->name}}" name="new_name" maxlength="254" required></td>
                        </tr>
                        <tr>
                            <td>Должность</td>
                            <td>
                                <select class="form-control"  name="new_position" id="sel1">
                                    @foreach($positions as $position)
                                        @if($position == $worker->position)
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
                                    @if(isset($supervisor_list))
                                    @foreach($supervisor_list as $supervisor)
                                         @if($supervisor->id == $worker->supervisor)
                                            <option selected="selected" value="{{$supervisor->id}}">{{$supervisor->name}}, {{$supervisor->id}}, {{$supervisor->position}}</option>
                                        @else
                                            <option value="{{$supervisor->id}}">{{$supervisor->name}}, {{$supervisor->id}}, {{$supervisor->position}}</option>
                                        @endif
                                    @endforeach
                                    @endif
                                </select>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>Дата приема на работу</td>
                            <td><input class="form-control" type="date" value="{{$worker->hired_at}}" name="new_date" required></td>
                        </tr>
                        <tr>
                            <td>Размер заработной платы</td>
                            <td><input class="form-control" type="text" placeholder="" value="{{$worker->salary}}" name="new_salary" maxlength="10" required></td>
                        </tr>
                        <tr>
                            <td>Фотография сотрудника</td>
                            <td><img src="{{asset('storage/') . '/' . $worker->photo}}" alt="Фото отсутствует" style="max-width:200px; max-height:200px;">
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
        <script>
            $(document).ready(function() {
            $('#sel1').change(function() {
                var sel1_id = $(this).val();
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/createajax",
                    method: "POST",
                    data: {pos:sel1_id},
                    dataType: "text",
                    success: function(data) {
                        $('#sel2').html(data);
                        console.log('success!');
                    }
                });
            });
        });
    </script>
    </body>
</html>
@endsection