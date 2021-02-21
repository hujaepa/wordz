$("#success-alert").hide();
$("#danger-alert").hide();
$("#save").on("click",function(e){
    e.preventDefault();
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
        beforeSend:function(){
            $('#result').loading();
        },
        success: function (response) {
            $('#result').loading("stop");
            $(".message").html(response.message);

            if(response.status){

                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
                $("#save").attr("class","btn btn-secondary btn-sm").html("Added to favourites").attr("disabled",true);
            }else{
                $("#danger-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#danger-alert").slideUp(500);
                });
            }
        }
    });
});
