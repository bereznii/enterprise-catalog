@extends('layouts.app')
@section('content')
        <div class="panel panel-default" >
        <div class="panel-heading">
        <form action="/list/order/none" method="post">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" value='' name="search_request">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" name="do_search">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                    <a href="/list" class="btn btn-default" title="Очистить Поиск">
                        <span class="glyphicon glyphicon-refresh"></span>
                    </a>
                </div>
            </div>
        </form>
        </div>
        <div class="panel-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#
                        <a href="/list/order/id&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/list/order/id&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
                    <th>ФИО
                        <a href="/list/order/name&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/list/order/name&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
                    <th>Должность
                        <a href="/list/order/position&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/list/order/position&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
                    <th>Дата​ ​приема​ ​на​ ​работу
                        <a href="/list/order/hired_at&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/list/order/hired_at&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
                    <th>Размер​ ​заработной​ ​платы
                        <a href="/list/order/salary&DESC">
                            <span class="glyphicon glyphicon-arrow-down"></span>
                        </a>
                        <a href="/list/order/salary&ASC">
                            <span class="glyphicon glyphicon-arrow-up"></span>
                        </a>
                    </th>
                    <th>Фото
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
                        @if($worker->photo)
                        <a href="{{asset('storage/') . '/' . $worker->photo}}" data-lightbox="{{$worker->photo}}" data-title="{{$worker->name}}">
                            <img src="{{asset('storage/') . '/' . $worker->photo}}" style="max-width:20px; max-height:20px;">
                        </a>
                        @endif
                    </td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="5">...</td>
                </tr>
            </tbody>
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
@endsection