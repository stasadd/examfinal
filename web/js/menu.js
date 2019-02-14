$(document).ready(function(){
    flag = false;
    menu_start_height = $(".menu_list").css("height");
    menu_start_width = $(".menu_list").css("width");

    menu_height();
    $(window).resize(menu_height);

    $(window).scroll(function(){
        if($(window).width()>768)
        {
            if($(document).scrollTop()>50)
            {
                if(flag==false)
                {
                    menu_start_width = $(".menu_list").css("width");
                    flag = true;
                }
                $(".menu_list").css("position","fixed");
                $(".menu_list").css("width",menu_start_width);
            }
            else{
                $(".menu_list").css("position","absolute");
                $(".menu_list").css("width","auto");
                flag = false;
            }
        }
    });

    function menu_height(){
        if($(window).width()>768){
            if(menu_start_height<$(".carousel").css("height"))
            {
                $(".menu_list").css("min-height",$(".carousel").css("height"));
            }
            if($(window).width()>=1517)
            {
                $(".container-with-menu").attr("class","container container-with-menu");
                if(($(".menu_list").children().length)*40<$(".carousel").css("height"));
                {
                    $(".menu_list").css("min-height",$(".carousel").css("height"));
                }
            }
            else{
                $(".container-with-menu").attr("class","container-fluid container-with-menu");
                if(($(".menu_list").children().length)*40<$(".carousel").css("height"));
                {
                    $(".menu_list").css("min-height",$(".carousel").css("height"));
                }
            }
        }
        else{
            $(".menu_list").removeAttr("style");
            $(".menu_list").css("position","relative");
        }
    }
})