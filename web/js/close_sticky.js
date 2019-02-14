$(document).ready(function(){
	var footer_height = $("#footer").height()+parseInt($("#footer").css("padding-top"));
	$(".sticky-footer").animate({opacity: 1}, 1500);
	$(".sticky-close").on("click",function(){
        $(".sticky-footer").css("display","none");
    });
    scrolling();
    $(window).scroll(function(){
    	scrolling();
    });
    function scrolling(){
    	var scroll = $(document).scrollTop();
    	var flag;
    	var el;
    	if($(".sticky-wrap").css("position")=="fixed")
    		flag=false;
    	else
    		flag=true;
    	if(flag==false)
			el = $(".footer-menu").height()+parseInt($("#footer").css("padding-top"));
		else
			el = footer_height;
    	if(scroll <= ($(document).height()-$(window).height()-el))
    		{
    			$(".sticky-wrap").css("position","fixed");
    			if($(window).width()>1000)
    				$(".sticky-wrap").css("left",($(window).width()-1000)/2);
    			else
    				$(".sticky-wrap").css("left",0);
    			$(".sticky-wrap").css("background","linear-gradient(to bottom,#000000 0%,#696969 75%,#808080 100%)");
    		}
    	else
    		{
    			$(".sticky-wrap").css("left",0);
    			$(".sticky-wrap").css("position","relative");
    			$(".sticky-wrap").css("background","none");
    		}
    }
});