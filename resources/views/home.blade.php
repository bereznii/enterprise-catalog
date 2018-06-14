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
        <div class="panel panel-default" >
        <div class="panel-heading">
        <form action="/home" method="post">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" value='' name="search_request">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" name="do_search">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </div>
            </div>
        </form>
        </div>
        <div class="panel-body" id="employee_table">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><a href="#" class="column_sort" id="id" data-order="desc">#</a></th>
                    <th><a href="#" class="column_sort" id="name" data-order="desc">ФИО</th>
                    <th><a href="#" class="column_sort" id="position" data-order="desc">Должность</th>
                    <th><a href="#" class="column_sort" id="hired_at" data-order="desc">Дата​ ​приема​ ​на​ ​работу</th>
                    <th><a href="#" class="column_sort" id="salary" data-order="desc">Размер​ ​заработной​ ​платы</th>
                    <th colspan="3">
                        <a href="/home/create" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-plus"></span>Добавить 
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach($workers as $worker)
                <tr>
                    <td>{{$worker->id}}</td>
                    <td>{{$worker->name}}</td>
                    <td>{{$worker->position}}</td>
                    <td>{{$worker->hired_at}}</td>
                    <td>{{$worker->salary}}</td>
                    <td>
                        <a href="/home/read/{{$worker->id}}" title="Информация">
                            <span class="glyphicon glyphicon-info-sign"></span>
                        </a>
                        </td><td>
                        <a href="/home/update/{{$worker->id}}" title="Изменить">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        </td>
                    <td>
                        <a href="#demo{{$worker->id}}" data-toggle="collapse" title="Удалить">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
                <tr id="demo{{$worker->id}}" class="collapse">
                    <td colspan="5"></td>
                    <td colspan="3" align="center">Удалить?   <a class="btn btn-default btn-xs" href="/home/delete/{{$worker->id}}">Да</a></td>
                </tr>
            @endforeach
        </table>
        </div>
        </div>
        <script>
            $(document).ready(function() {
                $(document).on('click', '.column_sort', function() {
                    var column_name = $(this).attr("id");
                    var order = $(this).data("order");
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:"/homeorder",
                        method:"POST",
                        data:{column_name:column_name, order:order},
                        success: function(data) {
                            $('#employee_table').html(data);
                        }
                    })
                });
            });
        </script>
@endsection
