$(document).ready(function(){
		var $body = $(document.body), 
			$top = '';

		$top=$('<div>') 
				.addClass('scroll_top') 
				.hide()
				.click(function(){  
					$body.animate({ scrollTop: 0 }); 
				})
				.appendTo($body); 

		$(window).scroll(function(){

			var y = $(this).scrollTop();

			if(y >= 100){
				$top.fadeIn();
			}
			else {
				$top.fadeOut();
			}
		});

	var quick_menu=$('#quick');
	quick_menu.animate({ scrollTop: 0 });

	$("#quick .first").click(function() {   // box 안의 태그중 클래스가 imgst 인 태그를 클릭하면...
	$("#quick .last").stop().toggle("slow");
	//$("#quick a div").stop().toggle("slow");  // 해당 서브 div 를 토글시킨다.
		});

});
