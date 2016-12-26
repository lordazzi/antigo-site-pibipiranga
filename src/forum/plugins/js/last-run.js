/*
	# AUTHOR: RICARDO AZZI #
	# CREATED: 16/10/12 #
*/
$(function(){
	
	//
	// AJUSTANDO O MENU
	//
	
	$(".left-hidden span, .left-show span").click(function(){
		var minha_classe = $(this).parent().attr("class");
		if (minha_classe == "left-hidden") {
			$(this).parent().attr("class", "left-show");
			setCookie("ttots-"+$(this).parent().attr("id"), "true", 1);
		} else {
			setCookie("ttots-"+$(this).parent().attr("id"), "false", 1);
			$(this).parent().attr("class", "left-hidden");
		}
	});
	
	for (i = 1; i <= 7; i++) {
		if (getCookie("ttots-mainmenu-"+i) == "true") {
			$("#mainmenu-"+i).attr("class", "left-show");
		}
	}
	
	//
	// NOVOS OBJETOS DO DOM
	//
	
	// INT, UINT, FLOAT, UFLOAT
	
	$("input[type='int'], input[type='uint'], input[type='float'], input[type='ufloat']").on("keydown", function(e){
		if ((e.keyCode == 8 || e.keyCode == 46 || //backspace e delete
		e.keyCode >= 96 && e.keyCode <= 105 || //teclas do numlock
		e.keyCode >= 48 && e.keyCode <= 57 || //números ali em cima
		e.keyCode >= 33 && e.keyCode <= 40 || //outras teclas e setas
		e.keyCode == 47 || e.keyCode == 9) && //outras teclas
		e.shiftKey == false || e.ctrlKey == true || //teclas auxiliares
		e.keyCode >= 37 && e.keyCode <= 40 && e.shiftKey == true) { //teclas auxiliares
		   return true;
		} else {
		   var tipo = $(this).attr("type");
		   if ((tipo == "float" || tipo == "ufloat") && ((e.keyCode == 188 || e.keyCode == 190 || e.keyCode == 110 || e.keyCode == 194) && e.shiftKey == false)) {
			   return true;
		   }
		  
		   if ((tipo == "int" || tipo == "float") && ((e.keyCode == 189 && e.shiftKey == false) || e.keyCode == 109)) {
			   return true;
		   }
		   return false;
		}
	});
   
	function numberfield(me){
		var valor = $(me).val();
		if (isNaN(valor.replace(/[,]/g, ".")) == true) {
			   var cursor = $(me).getCursor();
			   var novo_valor = "";
			   var meu_type = $(me).attr("type");
			   if (meu_type == "float" || meu_type == "ufloat") {//float pode ter números quebrados, usando ponto ou vírgula
				   valor = valor.replace(/[,]/g, ".");
				   var quantos_pontos = valor.split(".").length;
				   if (quantos_pontos > 1) {
					   valor = valor.replace(/[.]/g, "");
				   }
				   $(me).val(valor);
			   }
			  
			   for (i = 0; i < valor.length; i++) {
				   if ((meu_type == "float" || meu_type == "ufloat") && valor[i] == ".") { //verificando se o elemento é FLOAT, então ele pode ter caractere de ponto
					   novo_valor += valor[i];
				   } else if ((meu_type == "float" || meu_type == "int") && i == 0 && valor[i] == "-") { //verificando se o elemento NÃO é UNSIGNED, então ele pode ter caractere de menos
					   novo_valor += valor[i];
				   } else if (!isNaN(valor[i]) && valor[i] != " ") {
					   novo_valor += valor[i];
				   }
			   }
			  
			   $(me).val(novo_valor);
			   $(me).setCursor(cursor);
		}
	}
   
	$("input[type='int'], input[type='uint'], input[type='float'], input[type='ufloat']").on("keyup change blur", function(e){
		numberfield(this);
	});
   
   
	$("input[type='int'], input[type='uint'], input[type='float'], input[type='ufloat']").each(function(){
		numberfield(this);
	});
	
		// MAXLENGTH PARA TABLE
	$("td[maxlength]").each(function(){
		//peganto o maxlength
		var maxlen = $(this).attr("maxlength");
		
		//organizando a posição onde o texto deve ficar
		var value = $(this).text();
		$(this).attr("all-content", value);
		var littletext = "";
		if (value.length <= maxlen) {
			littletext = value;
		} else {
			var arr = value.split(" ");
			for (i = 0; i < arr.length; i++) {
				if ((littletext + arr[i]).length < maxlen) {
					littletext += " " + arr[i];
				}
			}
			littletext += "...";
		}
		$(this).attr("low-content", littletext)
		$(this).text($(this).attr("low-content"));
	});
	
	$("td[maxlength][openable='openable']").each(function(){
		//gerando um ID, caso ainda não o tenha
		if ($(this).attr("id") == null) {
			$(this).attr("id", generate());
		}
		var tdid = $(this).attr("id");
		//adicionando uma nova tag
		var mytr = $(this).parent();
		var novo_td_id = generate();
		$("<td class='plus-minus'><img id='"+novo_td_id+"' src='plugins/img/plus.gif'></td>").appendTo(mytr);
		var mytd = this;
		$("#"+novo_td_id).on("click", function() {
			if ($(mytd).attr("open")) {
				$(mytd).removeAttr("open");
				$("#"+novo_td_id).attr("src", "plugins/img/plus.gif");
				$(mytd).text($(mytd).attr("low-content"));
			} else {
				$(mytd).attr("open", "open");
				$("#"+novo_td_id).attr("src", "plugins/img/minus.gif");
				$(mytd).text($(mytd).attr("all-content"));
			}
		});
	});
});