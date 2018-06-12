@extends('layouts.app')
@section('content')
        <ul class="list-group">
            <p class="list-group-item list-group-item-info">President</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ФИО</th>
                                <th>Должность</th>
                                <th>Дата​ ​приема​ ​на​ ​работу</th>
                                <th>Размер​ ​заработной​ ​платы</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($president as $head)
                            <tr>
                                <td>{{$head->id}}</td>
                                <td>{{$head->name}}</td>
                                <td>{{$head->position}}</td>
                                <td>{{$head->hired_at}}</td>
                                <td>{{$head->salary}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            <li class="list-group-item">
                <ul class="list-group">
                    <p class="list-group-item list-group-item-info">Second Management Level</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ФИО</th>
                                <th>Должность</th>
                                <th>Дата​ ​приема​ ​на​ ​работу</th>
                                <th>Размер​ ​заработной​ ​платы</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($secondworkers as $worker)
                            <tr>
                                <td>{{$worker->id}}</td>
                                <td><a href="/tree/{{$worker->id}}&3">{{$worker->name}}</td>
                                <td>{{$worker->position}}</td>
                                <td>{{$worker->hired_at}}</td>
                                <td>{{$worker->salary}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($thirdworkers)
                        <li class="list-group-item">
                            <ul class="list-group">
                                <p class="list-group-item list-group-item-info">Руководитель: {{$supervisor[0][0]->name}} | Third Management Level</p>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ФИО</th>
                                            <th>Должность</th>
                                            <th>Дата​ ​приема​ ​на​ ​работу</th>
                                            <th>Размер​ ​заработной​ ​платы</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($thirdworkers as $worker)
                                        <tr>
                                            <td>{{$worker->id}}</td>
                                            <td><a href="/tree/{{$supervisor[0][0]->id}}&{{$worker->id}}&4">{{$worker->name}}</a></td>
                                            <td>{{$worker->position}}</td>
                                            <td>{{$worker->hired_at}}</td>
                                            <td>{{$worker->salary}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    @if($fourthworkers)
                                    <li class="list-group-item">
                                        <ul class="list-group">
                                            <p class="list-group-item list-group-item-info">Руководитель: {{$supervisor[1][0]->name}} | Fourth Management Level</p>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>ФИО</th>
                                                        <th>Должность</th>
                                                        <th>Дата​ ​приема​ ​на​ ​работу</th>
                                                        <th>Размер​ ​заработной​ ​платы</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($fourthworkers as $worker)
                                                    <tr>
                                                        <td>{{$worker->id}}</td>
                                                        <td><a href="/tree/{{$supervisor[0][0]->id}}&{{$supervisor[1][0]->id}}&{{$worker->id}}&5">{{$worker->name}}</a></td>
                                                        <td>{{$worker->position}}</td>
                                                        <td>{{$worker->hired_at}}</td>
                                                        <td>{{$worker->salary}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                                @if($fifthworkers)
                                                <li class="list-group-item">
                                                    <ul class="list-group">
                                                        <p class="list-group-item list-group-item-info">Руководитель: {{$supervisor[2][0]->name}} | Fifth Management Level</p>
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>ФИО</th>
                                                                    <th>Должность</th>
                                                                    <th>Дата​ ​приема​ ​на​ ​работу</th>
                                                                    <th>Размер​ ​заработной​ ​платы</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($fifthworkers as $worker)
                                                                <tr>
                                                                    <td>{{$worker->id}}</td>
                                                                    <td><a href="/tree/{{$supervisor[0][0]->id}}&{{$supervisor[1][0]->id}}&{{$supervisor[2][0]->id}}&{{$worker->id}}&6">{{$worker->name}}</a></td>
                                                                    <td>{{$worker->position}}</td>
                                                                    <td>{{$worker->hired_at}}</td>
                                                                    <td>{{$worker->salary}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                            @if($workers)
                                                            <li class="list-group-item">
                                                                <ul class="list-group">
                                                                    <p class="list-group-item list-group-item-info">Руководитель: {{$supervisor[3][0]->name}} | Workers</p>
                                                                    <table class="table table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>ФИО</th>
                                                                                <th>Должность</th>
                                                                                <th>Дата​ ​приема​ ​на​ ​работу</th>
                                                                                <th>Размер​ ​заработной​ ​платы</th>
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
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </ul>
                                                            </li>
                                                            @endif
                                                    </ul>
                                                </li>
                                                @endif
                                        </ul>
                                    </li>
                                    @endif
                            </ul>
                        </li>
                        @endif
                </ul>
            </li>
        </ul>
@endsection
