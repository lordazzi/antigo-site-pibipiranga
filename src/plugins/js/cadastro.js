
// FUNÇÕES REFERENTES AO TELEFONE

var n_contatos = 0;

function contato(meuid, pais) //altera o conteúdo de contato, ou para celular, ou para email ou para telefone fixo
{
	var prefixo;
	if (pais == 1) { prefixo = ""; }
	else { prefixo = "<input type='text' style='width: 20px;' name='"+meuid+"_prefix' id='"+meuid+"_prefix'>"; } 
  
	if (document.getElementById(meuid+"_tipo").value == "tel")
	{	  
	  document.getElementById(meuid+"_content").innerHTML = "\
	  "+prefixo+"\
	  <input type='text' style='width: 95px;' name='"+meuid+"' id='"+meuid+"'>";
	  $("#"+meuid).mask("(99) 9999-9999");
	}

	else if (document.getElementById(meuid+"_tipo").value == "cel")
	{
	  document.getElementById(meuid+"_content").innerHTML = "\
	  "+prefixo+"\
	  <input type='text' style='width: 95px;' name='"+meuid+"' id='"+meuid+"'>\
	  <select style='width: 60px;' name='"+meuid+"_op' id='"+meuid+"_op'>\
		  <option value='claro'>Claro</option>\
		  <option value='nextel'>Nextel</option>\
		  <option value='oi'>Oi</option>\
		  <option value='tim'>Tim</option>\
		  <option value='vivo'>Vivo</option>\
		  <option value='outra'>Outra...</option>\
	  </select>";
	  $("#"+meuid).mask("(99) 9999-9999");
	}

	else if (document.getElementById(meuid+"_tipo").value == "mail")
	{
	  document.getElementById(meuid+"_content").innerHTML = "<input type='text' id='mail_"+meuid+"' name='"+meuid+"' maxlength='75'>";
	}
}

function addcontato(pais) //1 é o país padrão da região
{
	n_contatos++; var show;
	if (n_contatos != 1) { show = " "+n_contatos; }
	else { show = ""; }
	
	//Evitando que os dados digitados se percam para cada vez que um contato for adicionado
	var salva_valores; salva_valores = new Array();
	var o_nome;
	for (IntFor = 0; IntFor < (n_contatos - 1); IntFor++)
	{
	  o_nome = IntFor + 1;
	  salva_valores[IntFor] = new Array();
	  salva_valores[IntFor][0] = document.getElementById("cont"+o_nome+"_tipo").value;
	  if (salva_valores[IntFor][0] == "mail") 	{ salva_valores[IntFor][1] = document.getElementById("mail_cont"+o_nome).value; }
	  else										{ salva_valores[IntFor][1] = document.getElementById("cont"+o_nome).value; }
	  if (salva_valores[IntFor][0] == "cel") {
		salva_valores[IntFor][2] = document.getElementById("cont"+o_nome+"_op").value;
	  }
	}
	
	document.getElementById("js_contato").innerHTML += "\
	  <label for='cont"+n_contatos+"'>	Contato"+show+":	</label> \
		<select name='cont"+n_contatos+"_tipo' id='cont"+n_contatos+"_tipo' onClick=\"contato('cont"+n_contatos+"', "+pais+");\" style='width: 50px;'>\
		  <option value='tel'>Tel</option>\
		  <option value='cel'>Cel</option>\
		  <option value='mail'>Email</option>\
		</select>\
	  <span id='cont"+n_contatos+"_content'></span>\
	  <br />\
	";
	
	//Criando um novo campo e devolvendo as mascaras que foram tiradas dos outros campos com o += a cima
	for (IntFor = 0; IntFor < n_contatos; IntFor++)
	{
	  $("#cont"+IntFor).mask("(99) 9999-9999");
	} //Ele mascara todos menos o atual, o atual é mascarado pela função 'contato'
	contato("cont"+n_contatos, pais);
	
	//Devolvendo os valores
	var o_nome; o_nome = 0;
	for (IntFor = 0; IntFor < salva_valores.length; IntFor++)
	{
	  o_nome = IntFor + 1;
	  document.getElementById("cont"+o_nome+"_tipo").value = salva_valores[IntFor][0];
	  if (salva_valores[IntFor][0] == "mail") 	{ document.getElementById("mail_cont"+o_nome).value = salva_valores[IntFor][1]; }
	  else 										{ document.getElementById("cont"+o_nome).value = salva_valores[IntFor][1]; }
	  if (salva_valores[IntFor][0] == "cel") {
		document.getElementById("cont"+o_nome+"_op").value = salva_valores[IntFor][2];
	  }
	}
	document.getElementById("cont_numero").value = n_contatos;
}

//Solicitando um país, caso o da pessoa ainda não exista no banco de dados
function paissolicita()
{
	document.getElementById("js_pais_solicita").innerHTML = " Solicitar novo país: <input name='pais_solicita' maxlength='64' style='width: 100px;' type='text'>";
	document.getElementById("js_pais_solicita").style.cursor = "none";
	document.getElementById("js_pais_solicita").onClick = "";
	document.getElementById("js_pais_solicita").id = "pais_solicita";
}

//Solicitando um estado, caso o da pessoa ainda não exista no banco de dados
function ufsolicita()
{
	document.getElementById("js_uf_solicita").innerHTML = " Solicitar novo estado (sigla): <input name='uf_solicita' maxlength='2' style='width: 20px;' type='text'>";
	document.getElementById("js_uf_solicita").style.cursor = "none";
	document.getElementById("js_uf_solicita").onClick = "";
	document.getElementById("js_uf_solicita").id = "uf_solicita";
}