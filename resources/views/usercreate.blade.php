@extends('layouts.app')

@section('content')
        <div class="main-section">
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <h4>Добавить Сотрудника # {{$id}}</h4>
                </div>
                <div class="panel-body">
                    <form action="/do_create" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
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
                            <td>{{$id}}</td>
                        </tr>
                        <tr>
                            <td>ФИО</td>
                            <td><input class="form-control" type="text" name="new_name" required></td>
                        </tr>
                        <tr>
                            <td>Должность</td>
                            <td>
                                <select class="form-control"  name="new_position" id="sel1">
                                    @foreach($positions as $position)
                                        <option value="{{$position}}">{{$position}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Руководитель</td>
                            <td>
                                <select class="form-control"  name="new_supervisor" id="sel2">
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Дата приема на работу</td>
                            <td><input class="form-control" type="date" value="" name="new_date"></td>
                        </tr>
                        <tr>
                            <td>Размер заработной платы</td>
                            <td><input class="form-control" type="number" value="" name="new_salary" required></td>
                        </tr>
                        <tr>
                            <td>Фотография сотрудника</td>
                            <td><input type="file" class="form-control-file" name="new_photo"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" class="btn btn-primary">Добавить</button></td>
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