$(function(){
	var nome = "";
	var tipo_valor = "";
	var tipo_nome = "";
	var nomes = new Array();
	
	var onDelete = (function(item, self, Event){
		$.ajax({
			type: "POST",
			url: "actions/desativa-campo.php",
			data: {
				id: item
			},
			success: function(json) {
				json = JSON.parse(json);
				if (json.success == true) {
					self.animate({
						"opacity": 0
					}, 500, function(){
						$(this).remove();
					});
				}
			}
		});
	});
	
	$("#adicionar-campo").on("click", function(){
		nome = $("#formulario-nome").val();
		tipo_valor = $("#formulario-tipo").val();
		tipo_nome = $($("#formulario-tipo").children("option").get(tipo_valor - 1)).text();
		
		if (nomes.indexOf(nome) == -1) {
			$.ajax({
				url: "actions/salva-novo-campo.php",
				type: "POST",
				data: {
					nome: nome,
					tipo: tipo_valor
				},
				success: function(json){
					json = JSON.parse(json);
					if (json.id != false) {
						$("#formulario-nome").val("");
						var id = "element-"+(new Date().getTime())+"-"+((Math.random()+"").replace(".", ""));
						var close = "element-"+(new Date().getTime())+"-"+((Math.random()+"").replace(".", ""));
						
						$("<tr id='"+id+"' style='opacity: 0'>" + 
							"<td><span>" + nome + "</span></td>" + 
							"<td><span>" + tipo_nome + "</span></td>" + 
							"<td id='"+close+"' class='deletar'><span><img src='/resource/icons/16/delete.png' data-id='"+json.id+"' /></span></td>" + 
						"</tr>").appendTo("#formulario-opcoes tbody");
						
						//	avisando que este nome já existe
						nomes[nomes.length] = nome;
						
						//	setando os eventos
						$("#"+close).on("click", function(Event){ onDelete(tipo_valor, $("#"+id), Event); });
						
						//	fazendo o efeitinho
						$("#"+id).animate({
							"opacity": 1
						}, 500);
					}
				}
			});
		} else {
			$("#alert-campo-ja-existe").parents("div.block-background").removeClass("ghost");
		}
		return false;
	});
	
	$("#alert-campo-ja-existe").on("click", function(){
		$(this).parents(".block-background").addClass("ghost");
	});
	
	$(".deletar img").on("click", function(Event){
		onDelete($(this).data("id"), $(this).parents("tr"), Event);
	});
	
	$("#formulario-opcoes tbody").sortable({
		placeholder: "ui-state-highlight",
		stop: function(Event){
			var child = $(Event.toElement).parents("tbody")[0].children;
			var arr = [];
			for (i = 0; i < child.length; i++) {
				arr[arr.length] = $(child[i]).find("img").data("id");
			}
			
			$.ajax({
				type: "post",
				url: "actions/alterar-ordem-dos-campos.php",
				data: {
					"pos": arr
				},
				success: function(retorno){
					console.log(retorno);
				}
			});
		}
	});
});