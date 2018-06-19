@extends('layouts.app')
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
@section('content')

    
    <ul class="list-group">
    @if(isset($presidents))
        @foreach($presidents as $president)
        <li class="list-group-item item{{$president->id}}"><p class="some" id="{{$president->id}}" style="cursor: pointer;"><span class="glyphicon glyphicon-menu-right" id="item{{$president->id}}"></span>   {{$president->name}} | {{$president->position}}</p>
            <div class="{{$president->id}}">
            </div>
        </li>
        @endforeach
    @elseif(!isset($presidents))
        <li class="list-group-item list-group-item-danger">
            <p>Президент отсутствует. Дерево не может быть построено.</p>
        </li>
    @endif
    </ul>
    

</body>
<script>
    $(document).ready(function() {
        $(document).on('click', '.some', function() {
            var id = $(this).attr("id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"/treeajax",
                method:"POST",
                data:{id:id},
                success: function(data) {
                    $('.'+id+'').html(data);
                    $('.item'+id+'').addClass('list-group-item-info');
                    $('#item'+id+'').toggleClass('glyphicon-menu-right').addClass('glyphicon-menu-down');
                }
            })
        });
    });
</script>
@endsection