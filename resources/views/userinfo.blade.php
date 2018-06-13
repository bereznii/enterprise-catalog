@extends('layouts.app')

@section('content')
        <div class="main-section">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Информация о сотруднике # {{$worker['id']}}
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
                            <td>{{$worker['id']}}</td>
                        </tr>
                        <tr>
                            <td>ФИО</td>
                            <td>{{$worker['name']}}</td>
                        </tr>
                        <tr>
                            <td>Должность</td>
                            <td>{{$worker['position']}}</td>
                        </tr>
                        <tr>
                            <td>Руководитель</td>
                            <td>@if($worker['supervisor'] == NULL)
                                -
                                @elseif($worker['supervisor'] == '0')
                                -
                                @else
                                {{$supervisor['name']}} ({{$supervisor['id']}}, {{$supervisor['position']}})
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Дата приема на работу</td>
                            <td>{{$worker['hired_at']}}</td>
                        </tr>
                        <tr>
                            <td>Размер заработной платы</td>
                            <td>{{$worker['salary']}}</td>
                        </tr>
                        <tr>
                            <td>Фотография сотрудника</td>
                            <td><img src="{{asset('storage/') . '/' . $worker['photo']}}" alt="Фото отсутствует" style="max-width:200px; max-height:200px;"></td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </body>
</html>
@endsection