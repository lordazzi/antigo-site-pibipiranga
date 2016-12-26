/*
	# AUTHOR: RICARDO AZZI #
	# CREATED: 16/10/12 #
*/
//
// FUNÇÔES
//

//função responsável por substituir o link dos menus, me permitindo usar javascript para manipular os items do menu
var sendto = (function(to, me) {
	$(".active").removeAttr("class");
	var cls = $(me).attr("class");
	$(me).attr("class", cls+" active");
	window.location.href = to;
});

//pegando o $_GET
function get(index) {
	var gets = window.location.href.split("?");
	if (index == "?") {
		return gets[1];
	} else {
		gets = gets[1].split("&");
		for (i = 0; i < gets.length; i++) {
			gets[i] = gets[i].split("=");
			if (gets[i][0] == index) {
				return gets[i][1];
			}
		}
	}
}

//Coloca um zero a esquerda de uma número que for menor do que 10
function rightZero(number) {
	if (number < 10) {
		return "0"+number;
	} else {
		return number;
	}
}

/* trabalhando com cookies */
var setCookie = (function(c_name, value, exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
});

var getCookie = (function(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name) {
			return unescape(y);
		}
	}
});


$(function(){
	//
	// NOVAS FUNÇÕES JQUERY
	//
	//pega a posição do cursor dentro de uma caixa de texto
	$.fn.getCursor = function() {
		var el = $(this).get(0);
		var pos = 0;
		if('selectionStart' in el) {
		   pos = el.selectionStart;
		} else if('selection' in document) {
		   el.focus();
		   var Sel = document.selection.createRange();
		   var SelLength = document.selection.createRange().text.length;
		   Sel.moveStart('character', -el.value.length);
		   pos = Sel.text.length - SelLength;
		}
		return pos;
	}

	//seta o cursor dentro de uma caixa de texto
	$.fn.setCursor = function(pos) {
		var element = $(this).get(0);
		if (typeof(element.setSelectionRange) != "undefined") {
		   element.setSelectionRange(pos, pos);
		}
		else if (element.createTextRange) {
		   var breaks = element.value.slice(0, pos).match(/\n/g);
		   var endPoint = 0;
		   if (breaks instanceof Array) {
			   endPoint = -breaks.length;
		   }
		   var range = element.createTextRange();
		   range.collapse(true);
		   range.moveStart("character", pos);
		   range.moveEnd("character", endPoint);
		   range.select();
		}
	}
	
	//importando CSS via javascript
	$.fn.getCss = function(file) {
		var file = file.split("?");
		file = file[0];
		$("<link rel='stylesheet' type='text/css' href='"+file+"?"+new Date().getTime()+"' />").appendTo("head");
	}

	//
	// EXECUÇÕES INICIAIS
	//
	//avisando que a pessoa visitou
	$.ajax({
		type: "POST",
		url: "post/register-visitor-first-ajax.php",
		data: {
			width: window.screen.width,
			height: window.screen.height,
			firstajax: new Date().getTime(),
			language: navigator.language,
			browser: navigator.vendor,
			system: navigator.platform
		},
		success: function(retorno) {
			eval("retorno = "+retorno);
			if (retorno.success == true) {
				$.ajax({
					type: "POST",
					url: "post/register-visitor-second-ajax.php",
					data: {
						secondajax: new Date().getTime()
					}
				});
			}
		}
	});
});