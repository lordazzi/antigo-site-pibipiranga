$(function(){
	//	geral, ajustando o design
	$(window).on("resize", function(){
		var size = Math.round(($(window).width() - 960) / 2 - 1);
		$("#header-menu-left, #header-menu-right").css({
			"width": size
		});
	});
	
	$(window).trigger("resize");
	
	//	default.php
	$("#slider img").each(function(){
		var $slider = $("#slider");
		var width = $slider.width() / $(this).width();
		var height = $slider.height() / $(this).height();
		if (width < height) {
			var margin = ($slider.height() - $(this).height()) / 2;
			$(this).css({
				"width": "100%",
				"margin-top": Math.floor(margin),
				"margin-bottom": Math.round(margin)
			});
			
		} else {
			$(this).css({
				"height": "100%"
			});
		}
	});
	
	var stopslide = false;
	var blockslide = false;
	var controller = [];
	
	$(".slide").each(function(i){
		controller[controller.length] = $("<div>")
			.addClass("slide-control")
			.text(i + 1)
			.appendTo("#slider .controller");
	});
	
	$(".slide-control").on("click", function(){
		blockslide = true;
		var indice = parseFloat($(this).text()) - 1;
		var slides = $(".slide");
		var current;
		
		//	descobrindo slide atual
		for (i = 0; i < slides.length; i++) {
			if ($(slides[i]).attr("data-current") == "current") { current = i; }
		}
		
		//	fazendo transferencia do atual para o que foi chamado
		$(".slide-control").removeClass("active");
		controller[indice].addClass("active");
		
		$(".slide").removeAttr("data-current");
		$(".slide").css("z-index", 0);
		
		$(slides[indice]).attr("data-current", "current");
		$(slides[indice]).css("z-index", 5);
		$(slides[indice]).animate({
			"opacity": 1
		}, 1000, function(){
			blockslide = false;
		});
		
		$(slides[current]).animate({
			"opacity": 0
		}, 1000);
	});
	
	var slider = (function(time){
		if (time == null) { time = 0; }
		setTimeout(function(){
			if (!stopslide && !blockslide) {
				var slides = $(".slide");
				var next = 0, current = 0, currentisget = false;
				for (i = 0; i < slides.length; i++) {
					if (currentisget == true) {
						next = i;
						break;
					} else {
						current = i;
						currentisget = ($(slides[i]).attr("data-current") == "current");
					}
				}
				
				$(".slide-control").removeClass("active");
				controller[next].addClass("active");
				
				$(".slide").removeAttr("data-current");
				$(".slide").css("z-index", 0);
				
				$(slides[next]).attr("data-current", "current");
				$(slides[next]).css("z-index", 5);
				$(slides[next]).animate({
					"opacity": 1
				}, 1000, function(){
					slider(2500);
				});
				
				$(slides[current]).animate({
					"opacity": 0
				}, 1000);
			} else {
				slider(500);
			}
		}, time);
	});
	
	$("#slider").on("mouseenter", function(){
		stopslide = true;
	});
	
	$("#slider").on("mouseleave", function(){
		stopslide = false;
	});
	
	slider();
});