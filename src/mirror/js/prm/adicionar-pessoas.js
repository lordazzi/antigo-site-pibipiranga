var form;
$(function(){
	//	cep
	$("#cep").on("keyup", function(){
		if ($("#cep").val().length == 8) {
			$.ajax({
				url: "actions/pesquisar-cep.php",
				type: "POST",
				data: {
					cep: $("#cep").val()
				},
				success: function(json) {
					json = JSON.parse(json)[0];
					if (json == null) {
						$("#logradouro").val("");
						$("#bairro").val("");
						$("#cidade").val("");
					} else {
						$("#logradouro").val(json.tp_logradouro+" "+json.logradouro);
						$("#bairro").val(json.bairro);
						$("#cidade").val(json.cidade);
					}
				}
			});
		}
	});
	
	//	validando formulário
	form = new Form({
		id: "adicionar-pessoas",
		action: function(el, status) {
			if (status) {
				el.css({ "border": "1px solid #abadb3" });
			} else {
				el.css({ "border": "1px solid #FF0000" });
			}
		},
		success: function() {
		}
	});
});