$("#success-alert").hide();
$("#danger-alert").hide();
$("#save").on("click",function(e){
    e.preventDefault();
    setInterval(function() {
        $('#result').loading('toggle');
    }, 2000);
    let word=$(this).attr("data-id");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "post",
        url: "/search/save",
        data: {word:word},
        success: function (response) {
            $(".message").html(response.message);
            if(response.status){
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
            }else{
                $("#danger-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#danger-alert").slideUp(500);
                });
            }
        }
    });
});
