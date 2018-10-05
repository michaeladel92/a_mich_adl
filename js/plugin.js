$(document).ready(function(){

    $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');
        
        if(value == "all")
        {
            //$('.filter').removeClass('hidden');
            $('.filter').show('1000');
        }
        else
        {
//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
            
        }
    });
    
    if ($(".filter-button").removeClass("active")) {
$(this).removeClass("active");
}
$(this).addClass("active");



//new_profile.php
    $(function() {
        $("#register").ajaxForm({
            beforeSend:function () {
                $("#result").html("<img src='img/loading.gif' width='50px' style='margin:10px 0;'>");
            },
            success:function (data) {
                $("#result").html(data);
            }
        });
    });

  






//edit_profile
    $(function() {
        $("#update_profile").ajaxForm({
            beforeSend:function () {
                $("#update_result").html("<img src='img/loading.gif' width='50px' style='margin:10px 0;'>");
            },
            success:function (data) {
                $("#update_result").html(data);
            }
        });
    });

//edit_post
    $(function() {
        $("#edit_post").ajaxForm({
            beforeSend:function () {
                $("#edit_result").html("<img src='img/loading.gif' width='50px' style='margin:10px 0;'>");
            },
            success:function (data) {
                $("#edit_result").html(data);
            }
        });
    });

//  Comments
$(function() {
    $("#comments").ajaxForm({
        beforeSend:function () {
            $("#com_result").html("<img src='img/loading.gif' width='50px' style='margin:10px 0;'>");
        },
        success:function (data) {
            $("#com_result").html(data);
        }
    });
});
//  settings
$(function() {
    $("#setting").ajaxForm({
        beforeSend:function () {
            $("#setting_result").html("<img src='../img/loading.gif' width='50px' style='margin:10px 0;'>");
        },
        success:function (data) {
            $("#setting_result").html(data);
        }
    });
});




});
