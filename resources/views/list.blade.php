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
        <form action="/list" method="post">
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
                    <th>Фото</th>
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
                        @if($worker->photo)
                        <a href="{{asset('storage/') . '/' . $worker->photo}}" data-lightbox="{{$worker->photo}}" data-title="{{$worker->name}}">
                            <img src="{{asset('storage/') . '/' . $worker->photo}}" style="max-width:20px; max-height:20px;">
                        </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        </div>
        </div>
        
        <script src="{{ asset('js/lightbox.min.js') }}"></script>
        <script>
            lightbox.option({
            'resizeDuration': 200,
            'imageFadeDuration': 200,
            'fadeDuration': 200,
            'wrapAround': true
            })
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '.column_sort', function() {
                    var column_name = $(this).attr("id");
                    var order = $(this).data("order");
                    var arrow = '';
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:"/order",
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