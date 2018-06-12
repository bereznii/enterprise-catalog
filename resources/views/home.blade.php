@extends('layouts.app')

@section('content')

<div class="main-section">
        <div class="panel panel-default" >
        <div class="panel-heading">
        <form action="/home/order/none" method="post">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" value='' name="search_request">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" name="do_search">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                    <a href="/home/refresh" class="btn btn-default" title="Очистить Поиск">
                        <span class="glyphicon glyphicon-refresh"></span>
                    </a>
                </div>
            </div>
        </form>
        </div>
        <div class="panel-body">
        @if($workers)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#
                        <a href="/home/order/id&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/home/order/id&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
                    <th>ФИО
                        <a href="/home/order/name&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/home/order/name&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
                    <th>Должность
                        <a href="/home/order/position&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/home/order/position&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
                    <th>Дата​ ​приема​ ​на​ ​работу
                        <a href="/home/order/hired_at&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/home/order/hired_at&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
                    <th>Размер​ ​заработной​ ​платы
                        <a href="/home/order/salary&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/home/order/salary&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
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
                <tr>
                    <td colspan="8">...</td>
                </tr>
            </tbody>
        </table>
        @else 
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ФИО</th>
                    <th>Должность</th>
                    <th>Дата​ ​приема​ ​на​ ​работу</th>
                    <th>Размер​ ​заработной​ ​платы</th>
                    <th colspan="3">
                        <a href="/home/create" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-plus"></span>Добавить 
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="8" align="center">Ничего не найдено</td>
                </tr>
            </tbody>
        </table>
        @endif
        </div>
        </div>
        </div>

@endsection
