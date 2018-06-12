$(document).ready(function() {
    $('#sel1').change(function() {
        var sel1_id = $(this).val();
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/home/accessible_supervisor",
            method: "POST",
            data: {ccId:sel1_id},
            dataType: "text",
            success: function(data) {
                $('#sel2').html(data);
            }
        });
    });
});