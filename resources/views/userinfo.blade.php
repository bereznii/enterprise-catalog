@extends('layouts.app')

@section('content')
        <div class="main-section">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Информация о сотруднике # {{$worker[0]->id}}
                </div>
                <div class="panel-body">
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
                            <td>{{$worker[0]->name}}</td>
                        </tr>
                        <tr>
                            <td>Должность</td>
                            <td>{{$worker[0]->position}}</td>
                        </tr>
                        <tr>
                            <td>Руководитель</td>
                            <td>@if($worker[0]->supervisor == NULL)
                                -
                                @elseif($worker[0]->supervisor == '0')
                                -
                                @else
                                {{$supervisor[0]->name}} ({{$supervisor[0]->id}}, {{$supervisor[0]->position}})
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Дата приема на работу</td>
                            <td>{{$worker[0]->hired_at}}</td>
                        </tr>
                        <tr>
                            <td>Размер заработной платы</td>
                            <td>{{$worker[0]->salary}}</td>
                        </tr>
                        <tr>
                            <td>Фотография сотрудника</td>
                            <td><img src="{{asset('storage/') . '/' . $worker[0]->photo}}" alt="Фото отсутствует" style="max-width:200px; max-height:200px;"></td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </body>
</html>
@endsection