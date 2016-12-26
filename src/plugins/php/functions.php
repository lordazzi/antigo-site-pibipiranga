<?php

################################################################################
################################################################################
###                                                                          ### 
###                    ARQUIVO PHP FUNCTION PIBI v 11.0		                 ###
###                                                                          ### 
################################################################################
################################################################################

#######################################
#  
#  Nome: getday
#  Descrição: retorna o valor do dia de uma data no formato 0000-00-00 ou 00/00/0000
#
#  $date > data a ter o dia pego
#  
#######################################
function getday($date) {
	if (strpos($date, "/")) {
		$date = human2bd($date);
	}
	
	$date = explode("-", $date);
	return $date[2];
}

#######################################
#  
#  Nome: getmonth
#  Descrição: retorna o valor do mês de uma data no formato 0000-00-00 ou 00/00/0000
#
#  $date > data a ter o mês pego
#  
#######################################
function getmonth($date) {
	if (strpos($date, "/")) {
		$date = human2bd($date);
	}
	
	$date = explode("-", $date);
	return $date[1];
}

#######################################
#  
#  Nome: getyear
#  Descrição: retorna o valor do ano de uma data no formato 0000-00-00 ou 00/00/0000
#
#  $date > data a ter o ano pego
#  
#######################################
function getyear($date) {
	if (strpos($date, "/")) {
		$date = human2bd($date);
	}
	
	$date = explode("-", $date);
	return $date[0];
}

###########################################
#
#  Nome: diffDate
#  Descrição: verifica quanto tempo há entre uma data e outra,
#  respondendo o tempo em dias, semanas, meses ou anos arredondados
#
#  $date1 > primeira data, no formato 00/00/0000 ou 0000-00-00
#  $date2 > segunda data, no formato 00/00/0000 ou 0000-00-00
#  $type > fomato em que a resposta deve vir: D = Dia, S ou W = Semana, M = Mês e A ou Y = Ano.
#
###########################################

function diffDate($date1, $date2, $type="D") {
	if (strpos($date1, "/")) {
		$date1 = human2bd($date1);
	}
	
	if (strpos($date2, "/")) {
		$date2 = human2bd($date2);
	}
	
	$day1 = getday($date1);
	$day2 = getday($date2);
	$mouth1 = getmonth($date1);
	$mouth2 = getmonth($date2);
	$year1 = getyear($date1);
	$year2 = getyear($date2);
	
	$date1 = strtotime($date1);
	$date2 = strtotime($date2);
	
	$diff = $date2 - $date1;
	
	// Calcula a diferença de dias
	$dias = (int)floor( $diff / (60 * 60 * 24));
	
	if ($type == "D") {
		$dias = $dias;
	}
	
	elseif ($type == "S" OR $type == "W") {
		$dias = $dias / 7;
	}
	
	elseif ($type == "M") {
		$year = $year2 - $year1;
		$mouth = $mouth2 - $mouth1;
		$dias = $mouth + ($year*12);
	}
	
	elseif ($type == "A" OR $type == "Y") {
		$dias = $year2 - $year1;
	}
	
	return floor($dias);
}

##############################
#
#   função youtube_xmlload
#   Duas funções juntas, que servem para abrir o XML com as informações do vídeo no youtube
#   $id = id do vídeo a ter a URL carregada
#
##############################

function youtube_xmlload($id) {
	return simplexml_load_string(load_file_from_url("http://gdata.youtube.com/feeds/api/videos/".$id));
}

function load_file_from_url($url) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_REFERER, 'http://www.pibipiranga.com.br');
	$str = curl_exec($curl);
	curl_close($curl);
	return $str;
}

##############################
#
#   função youtube_isvalid
#   Youtube é válido? Essa função valida a URL do youtube, se a URL for válida, ele retorna o ID do vídeo
#   $url = URL a ser validada
#
##############################

function youtube_isvalid($url) {
	preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $output);
	if ($output[0]) {
		return $output[0];
	}
	
	else {
		return false;
	}
}

##############################
#
#   função unacenta
#   Retira todos os acentos de uma palavra
#   $palavra = palavra a ter os acentos retirados
#
##############################

function unacenta($palavra) {
	$palavra = str_replace("Â", "A", $palavra);
	$palavra = str_replace("Ã", "A", $palavra);
	$palavra = str_replace("Á", "A", $palavra);
	$palavra = str_replace("À", "A", $palavra);
	$palavra = str_replace("Ä", "A", $palavra);
	$palavra = str_replace("â", "a", $palavra);
	$palavra = str_replace("ã", "a", $palavra);
	$palavra = str_replace("á", "a", $palavra);
	$palavra = str_replace("à", "a", $palavra);
	$palavra = str_replace("ä", "a", $palavra);
	$palavra = str_replace("@", "a", $palavra);
	$palavra = str_replace("Ê", "E", $palavra);
	$palavra = str_replace("É", "E", $palavra);
	$palavra = str_replace("È", "E", $palavra);
	$palavra = str_replace("Ë", "E", $palavra);
	$palavra = str_replace("ê", "e", $palavra);
	$palavra = str_replace("é", "e", $palavra);
	$palavra = str_replace("à", "e", $palavra);
	$palavra = str_replace("ë", "e", $palavra);
	$palavra = str_replace("Î", "I", $palavra);
	$palavra = str_replace("Í", "I", $palavra);
	$palavra = str_replace("Ì", "I", $palavra);
	$palavra = str_replace("Ï", "I", $palavra);
	$palavra = str_replace("î", "i", $palavra);
	$palavra = str_replace("í", "i", $palavra);
	$palavra = str_replace("ì", "i", $palavra);
	$palavra = str_replace("ï", "i", $palavra);
	$palavra = str_replace("Ô", "O", $palavra);
	$palavra = str_replace("Õ", "O", $palavra);
	$palavra = str_replace("Ó", "O", $palavra);
	$palavra = str_replace("Ò", "O", $palavra);
	$palavra = str_replace("Ö", "O", $palavra);
	$palavra = str_replace("ô", "o", $palavra);
	$palavra = str_replace("õ", "o", $palavra);
	$palavra = str_replace("ó", "o", $palavra);
	$palavra = str_replace("ò", "o", $palavra);
	$palavra = str_replace("ö", "o", $palavra);
	$palavra = str_replace("Û", "U", $palavra);
	$palavra = str_replace("Ú", "U", $palavra);
	$palavra = str_replace("Ù", "U", $palavra);
	$palavra = str_replace("Ü", "U", $palavra);
	$palavra = str_replace("û", "u", $palavra);
	$palavra = str_replace("ú", "u", $palavra);
	$palavra = str_replace("ù", "u", $palavra);
	$palavra = str_replace("ü", "u", $palavra);
	$palavra = str_replace("Ç", "C", $palavra);
	$palavra = str_replace("ç", "c", $palavra);
	$palavra = str_replace("Ñ", "N", $palavra);
	$palavra = str_replace("ñ", "n", $palavra);
	return $palavra;
}

##############################
#
#   função domoney
#   Converte números decimais ou inteiros para o formato 0.00 (duas casas depois da vírgula)
#   $date = variavel a ser alterada
#
##############################

function domoney($valor) {
	$valor = str_replace("R", "", $valor);
	$valor = str_replace("U", "", $valor);
	$valor = str_replace("S", "", $valor);
	$valor = str_replace("$", "", $valor);
	$valor = str_replace(" ", "", $valor);
	$valor = str_replace(",", ".", $valor);
	if (onlynumbers($valor, ".")) {//só pode ter números e ponto se não retorna o mesmo valor
		$ponto = strpos($valor, ".");
		if ($ponto === 0 OR $ponto) { //se ponto existe ou é exatamente igual a zero (por que nesse caso 0 não é false, mas o primeiro valor da casa de uma string)
			$decimal = substr($valor, $ponto, 3);
			$valor = substr($valor, 0, $ponto);
			if ($ponto === 0) {
				$valor = "0".$valor;
			}
			
			if (strlen($decimal) == 2) {
				$decimal .= "0";
			}
			
			elseif (strlen($decimal) == 1) {
				$decimal .= "00";
			}
			
			return $valor.$decimal;
		}
		
		else {
			return $valor.".00";
		}
	}
	
	else {
		return $valor; //se o valor inserido tiver alguma coisa além de números e o ponto, então a função retorna o próprio valor em si.
	}
}

##############################
#
#   função bd2human
#   Converte a data de Banco de dados para humano
#   $date = variavel com a data a ser analisada [formato 0000-00-00]
#
##############################

function bd2human($date) {
	$time = "";
	//verificando se alem da data foi dado o tempo também
	if (strlen($date) == 19) {
		$date = explode(" ", $date);
		$time = " ".substr($date[1], 0, 5);
		$date = $date[0];
	}
	$date = explode("-", $date);
	$date = $date[2]."/".$date[1]."/".$date[0];
	return $date.$time;
}

##############################
#
#   função human2bd
#   Converte a data de humano para Banco de dados
#   $date = variavel com a data a ser analisada [formato 00/00/0000]
#
##############################

function human2bd($date) {
	$date = explode("/", $date);
	$date = $date[2]."-".$date[1]."-".$date[0];
	return $date;
}

##############################
#
#   função ajeita
#   Essa função ajeita os nomes enviados para o banco de dados que forem escritos todos em maiusculas ou minusculas para o formato de primeira letra maiuscula e o resto minuscula, com exceção de preposições
#
#   $nome = o nome a ser ajeitado
#
##############################

function ajeita($nome) {
	//deixa tudo em minuscula
	$nome = lower_acento($nome);
	$nome = strtolower($nome);
	
	//divide os nomes em arrays
	$nome = explode(" ", $nome);
	
	//deixando a primeira letra maiuscula das palavras que tenham mais de 3 letras
	$RunFor = count($nome); //número de vezes que o for irá rodar
	$final_nome = "";
	for ($IntFor = 0; $IntFor < $RunFor; $IntFor++) {
		if ($nome[$IntFor] == "de" OR $nome[$IntFor] == "la" OR $nome[$IntFor] == "el" OR $nome[$IntFor] == "dos" OR $nome[$IntFor] == "da" OR $nome[$IntFor] == "das" OR $nome[$IntFor] == "do" OR $nome[$IntFor] == "com" OR $nome[$IntFor] == "e" OR $nome[$IntFor] == "na" OR $nome[$IntFor] == "no" OR $nome[$IntFor] == "nas" OR $nome[$IntFor] == "nos" OR $nome[$IntFor] == "às" OR $nome[$IntFor] == "a" OR $nome[$IntFor] == "e" OR $nome[$IntFor] == "o" OR $nome[$IntFor] == "ou" OR $nome[$IntFor] == "pra" OR $nome[$IntFor] == "para" OR $nome[$IntFor] == "pras" OR $nome[$IntFor] == "pra" OR $nome[$IntFor] == "y") {
		}
		
		else {
			$nome[$IntFor] = ucfirst($nome[$IntFor]);
			if ($nome[$IntFor] == "Sao") { //corrigindo a mania feia de não colocar o tio no 'São' dos nomes das cidades
				$nome[$IntFor] = "São";
			}
			
			elseif ($nome[$IntFor] == "Joao") { 
				$nome[$IntFor] = "João";
			}
		}
	}
	$nome = implode(" ", $nome);
	return $nome;
}

##############################
#
#   função dateexists
#   Verifica se a data realmente existe
#   $date = variavel com a data a ser analisada [formato 0000-00-00]
#
##############################

function dateexists($date)
{
  $date = explode("-", $date); //[0] ano; [1] mes; [2] dia;
  $datevalid = true;
  
  if ($date[1] == 0 OR $date[2] == 0) { $datevalid = false; }
  elseif ($date[1] == 1 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 2) //calculo do bissexto
  {
    $bissexto = $date[0] % 4;
    if ($bissexto == 0) 
	{
	  if ($date[2] > 29) { $datevalid = false; } //é bissexto
	}
	
	else
	{
	  if ($date[2] > 28) { $datevalid = false; }
	}
  }
  
  elseif ($date[1] == 3 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 4 AND $date[2] > 30)  { $datevalid = false; }
  elseif ($date[1] == 5 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 6 AND $date[2] > 30)  { $datevalid = false; }
  elseif ($date[1] == 7 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 8 AND $date[2] > 31)  { $datevalid = false; }
  elseif ($date[1] == 9 AND $date[2] > 30)  { $datevalid = false; }
  elseif ($date[1] == 10 AND $date[2] > 31) { $datevalid = false; }
  elseif ($date[1] == 11 AND $date[2] > 30) { $datevalid = false; }
  elseif ($date[1] == 12 AND $date[2] > 31) { $datevalid = false; }
  return $datevalid;
}

##############################
#
#   função mail_valid
#   verifica se o email colocado é valido, retorna em true ou false (Email válido: verdadeiro? Email válido: falso?)
#
#   $email = o email a ser analisado
#
##############################

function mail_valid($mail) {
	$valido = true;
	
	if (strpos($mail, "@") == -1) {// tem arroba?
		$valido = false;
	}
	
	if (strpos($mail, ".com") == -1) {//tem .com
		$valido = false;
	}
	
	if (!strtolower($mail)) { //somente letras
		$valido = false;
	}
	
	return $valido;
}

##############################
#
#   função onlynumbers
#   verifica se uma string tem somente números, retorna em true ou false (apenas número: verdadeiro? apenas letras: falso?)
#
#   $string = variavel a ser analisada
#	$addvalues = valores adicionais a serem aceitos
#
##############################

function onlynumbers($string, $addvalues = "") {
  $valid = true;
  for ($IntFor = 0; $IntFor < strlen($string); $IntFor++)
  {
    $char = lower_acento($string[$IntFor]);
    $rightchar = false;

        if ($char == "0") { $rightchar = true; }	elseif ($char == "1") { $rightchar = true; }
    elseif ($char == "2") { $rightchar = true; }	elseif ($char == "3") { $rightchar = true; }
    elseif ($char == "4") { $rightchar = true; }	elseif ($char == "5") { $rightchar = true; }
    elseif ($char == "6") { $rightchar = true; }	elseif ($char == "7") { $rightchar = true; }
    elseif ($char == "8") { $rightchar = true; }	elseif ($char == "9") { $rightchar = true; }
	
	if (strlen($addvalues) != "") //se não tiver nada na variavel de valores adicionais
	{
	  for ($IntFor2 = 0; $IntFor2 < strlen($addvalues); $IntFor2++)
	  {
	    $lowed = strtolower($addvalues[$IntFor2]);
		$lowed = lower_acento($lowed);
	    if ($char == $lowed) { $rightchar = true; }
	  }
	}
	
	if ($rightchar == false) { $valid = false; } //se ele não achou nenhuma das caracteres acima, o barato é invalido (caracteres especiais, letras etc.)
  }
 
  return $valid;
}

##############################
#
#   função onlyletter
#   verifica se uma string tem somente letras ou espaço, retorna em true ou false (apenas letras: verdadeiro? apenas letras: falso?)
#
#   $string = variavel a ser analisada
#	$addvalues = valores adicionais a serem aceitos
#
##############################

function onlyletter($string, $addvalues = "") {
  $valid = true;
  for ($IntFor = 0; $IntFor < strlen($string); $IntFor++)
  {
    $char = lower_acento($string[$IntFor]);
    $rightchar = false;

        if ($char == "a") { $rightchar = true; }	elseif ($char == "b") { $rightchar = true; }
    elseif ($char == "c") { $rightchar = true; }	elseif ($char == "d") { $rightchar = true; }
    elseif ($char == "e") { $rightchar = true; }	elseif ($char == "f") { $rightchar = true; }
    elseif ($char == "g") { $rightchar = true; }	elseif ($char == "h") { $rightchar = true; }
    elseif ($char == "i") { $rightchar = true; }	elseif ($char == "j") { $rightchar = true; }
    elseif ($char == "k") { $rightchar = true; }	elseif ($char == "l") { $rightchar = true; }
    elseif ($char == "m") { $rightchar = true; }	elseif ($char == "n") { $rightchar = true; }
    elseif ($char == "o") { $rightchar = true; }	elseif ($char == "p") { $rightchar = true; }
    elseif ($char == "q") { $rightchar = true; }	elseif ($char == "r") { $rightchar = true; }
    elseif ($char == "s") { $rightchar = true; }	elseif ($char == "t") { $rightchar = true; }
    elseif ($char == "u") { $rightchar = true; }	elseif ($char == "v") { $rightchar = true; }
    elseif ($char == "w") { $rightchar = true; }	elseif ($char == "x") { $rightchar = true; }
    elseif ($char == "y") { $rightchar = true; }	elseif ($char == "z") { $rightchar = true; }
	elseif ($char == " ") { $rightchar = true; }
	
	if (strlen($addvalues) != "") //se não tiver nada na variavel de valores adicionais
	{
	  for ($IntFor2 = 0; $IntFor2 < strlen($addvalues); $IntFor2++)
	  {
		$lowed = lower_acento($addvalues[$IntFor2]);
	    if ($char == $lowed) { $rightchar = true; }
	  }
	}
	
	if ($rightchar == false) { $valid = false; } //se ele não achou nenhuma das caracteres acima, o email é invalido (caracteres especiais, letras com acento etc.)
  }
 
  return $valid;
}

##############################
#
#   função lower_acento
#   deixa todas as letras do termo em minusculas, incluindo acentos.
#
#   $term = a palavra a ter os acentos tornados em minusculas
#
##############################

function lower_acento($term) {
	$palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
    return $palavra;
}

##############################
#
#   função upper_acento
#   deixa todas as letras do termo em maiusculas, incluindo acentos.
#
#   $term = a palavra a ter os acentos tornados em maiusculas
#
##############################

function upper_acento($term) {
	$palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
	return $palavra;
}


#######################
#
#   função getip
#   pega o endereço de IP do usuário
#
#######################

function getip() {
    $ipuser =  $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ipuser = $_SERVER['HTTP_CLIENT_IP'];
    }

    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipuser = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    else {
        $ipuser = $_SERVER['REMOTE_ADDR'];
    }
    return $ipuser;
}

######################################################################
#
#   Nome: killdir
#   Descrição: deleta todos os arquivos de uma pasta
#   $dir > diretório atual da imagem
#
######################################################################

function killdir($dir) {
  $path = $dir;
  $dir = opendir($dir);
  while ($files = readdir($dir)) {
    unlink($path."/".$files);
  }
  rmdir($dir);
}

######################################################################
#
#   Nome: ifnotpassed (Se não passou)
#   Descrição: Escreve o valor inserido se a data não tiver passado
#   $time > analisa se esse dia já passou
#   $string > se o dia NÃo tiver passado, retorna esse valor
#
######################################################################

function ifnotpassed($time, $string="")
{
    $d = substr($time, 8, 2);
    $m = substr($time, 5, 2);
    $y = substr($time, 0, 4);

    if ((date("d") <= $d AND date("m") == $m AND date("Y") == $y) OR (date("m") < $m AND date("Y") == $y) OR (date("Y") < $y))
    {
	  if ($string != "") {
		return $string; //retorna o valor pedido pelo programador
	  }
	  
	  else {
		return true;
	  }
    }
}

######################################################################
#
#   Nome: nextday (Próximo dia)
#   Descrição: Descobre que dia será amanhã
#   $data > o dia
#   $dias > quantos dias a frente desse dia você quer saber qual é
#
######################################################################

function nextday($data, $dias=1, $format = "d/m/Y") {
	if (strpos($data, "/")) {
		$data = human2bd($data);
	}
	$novadata = explode("-",$data);
	$dia = $novadata[2];
	$mes = $novadata[1];
	$ano = $novadata[0];
	
	return date($format, mktime(0, 0, 0, $mes, $dia + $dias, $ano));
}

######################################################################
#
#   Nome: numbtomonth (Número para mês)
#   Descrição: converte um número de 1 à 12 no nome de um mês
#   $M > Número do mês
#
######################################################################

function numbtomonth($M)
{
  if      ($M == 1)  { $M = "janeiro"; }
  else if ($M == 2)  { $M = "fevereiro"; }
  else if ($M == 3)  { $M = "março"; }
  else if ($M == 4)  { $M = "abril"; }
  else if ($M == 5)  { $M = "maio"; }
  else if ($M == 6)  { $M = "junho"; }
  else if ($M == 7)  { $M = "julho"; }
  else if ($M == 8)  { $M = "agosto"; }
  else if ($M == 9)  { $M = "setembro"; }
  else if ($M == 10) { $M = "outubro"; }
  else if ($M == 11) { $M = "novembro"; }
  else if ($M == 12) { $M = "dezembro"; }
  return $M;
}

######################################################################
#
#   Nome: redimenciona
#   Descrição: Redimenciona imagens
#   $origem > Local onde o arquivo está
#	$destino > Para onde ele deve ir
#	$maxlargura > largura máxima que ele pode tomar
#	$maxaltura > altura máxima que ele pode tomar
#	$qualidade > qualidade da imagem
#
######################################################################
function redimensiona($origem, $destino, $maxlargura=640, $maxaltura=460, $qualidade=80){
	if(!strstr($origem,"http") && !file_exists($origem)){
		echo("Arquivo de origem da imagem inexistente");
		return false;
	}
	$ext = strtolower(end(explode('.', $origem)));
	
	if($ext == "jpg" || $ext == "jpeg"){
		$img_origem = imagecreatefromjpeg($origem);
	}
	
	elseif ($ext == "gif") {
		$img_origem = imagecreatefromgif($origem);
	}
	
	elseif ($ext == "png") {
		$img_origem = imagecreatefrompng($origem);
	}
	
	if(!$img_origem){
		echo("Erro ao carregar a imagem, talvez formato nao suportado");
		return false;
	}
	$alt_origem = imagesy($img_origem);
	$lar_origem = imagesx($img_origem);
	$escala = min($maxaltura/$alt_origem, $maxlargura/$lar_origem);
	if($escala < 1) {
		$alt_destino = floor($escala*$alt_origem);
		$lar_destino = floor($escala*$lar_origem);
		// Cria imagem de destino
		$img_destino = imagecreatetruecolor($lar_destino,$alt_destino);
		// Redimensiona
		imagecopyresampled($img_destino, $img_origem, 0, 0, 0, 0, $lar_destino, $alt_destino, $lar_origem, $alt_origem);
		imagedestroy($img_origem);
	}
	
	else {
		$img_destino = $img_origem;
	}
	
	$ext = strtolower(end(explode('.', $destino)));
	if($ext == "jpg" || $ext == "jpeg") {
		imagejpeg($img_destino, $destino, $qualidade);
		return true;
	}
	
	elseif ($ext == "gif") {
		imagepng($img_destino, $destino);
		return true;
	}
	
	elseif ($ext == "png") {
		imagepng($img_destino, $destino);
		return true;
	}
	
	else {
		echo("Formato de destino não suportado");
		return false;
	}
}

############################
#
#    nome: getbrowser (Pega o browser)
#   descrição: identifica qual o browser que esta sendo usado pelo usuário
#
###########################
function getbrowser() {
	if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "googlebot") !== false) {
        $browser = "Googlebot";
    }
	
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "AhrefsBot") !== false) {
        $browser = "AhrefsBot";
    }
	
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "bingbot") !== false) {
        $browser = "BingBot";
    }
	
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "facebookexternalhit") !== false) {
        $browser = "Citação no Facebook";
    }
	
    elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Gecko")) {
        if (strpos($_SERVER["HTTP_USER_AGENT"], "Netscape") !== false) {
            //$browser = "Netscape";
			$browser = $_SERVER["HTTP_USER_AGENT"];
        }
				
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox") !== false) {
			$start = strpos($_SERVER["HTTP_USER_AGENT"], "Firefox");
			$length = strpos(substr($_SERVER["HTTP_USER_AGENT"], $start + 8), ".");
			$version = substr($_SERVER["HTTP_USER_AGENT"], $start + 8, $length);
			if ($version >= 11) {
				$browser = "Aurora Firefox v.".$version;
			}
			
			else {
				$browser = "Mozilla Firefox v.".$version;
			}
        }
       
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome") !== false) {
			$start = strpos($_SERVER["HTTP_USER_AGENT"], "Chrome");
			$length = strpos(substr($_SERVER["HTTP_USER_AGENT"], $start + 7), ".");
			$version = substr($_SERVER["HTTP_USER_AGENT"], $start + 7, $length);
            $browser = "Google Chrome v.".$version;
        }
       
        elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Apple") !== false AND strpos($_SERVER["HTTP_USER_AGENT"], "Safari") !== false) {
            //$browser = "Apple Safari";
			$browser = $_SERVER["HTTP_USER_AGENT"];
        }
       
        else {
            $browser = $_SERVER["HTTP_USER_AGENT"];
        }
    }

    elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false) {
		$start = strpos($_SERVER["HTTP_USER_AGENT"], "MSIE");
		$length = strpos(substr($_SERVER["HTTP_USER_AGENT"], $start + 5), ".");
		$version = substr($_SERVER["HTTP_USER_AGENT"], $start + 5, $length);
        $browser = "Internet Explorer v.".$version;
    }

    elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera") !== false) {
        //$browser = "Opera";
		$browser = $_SERVER["HTTP_USER_AGENT"];
    }
	
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "NetFront") !== false) {
		$start = strpos($_SERVER["HTTP_USER_AGENT"], "NetFront");
		$length = strpos(substr($_SERVER["HTTP_USER_AGENT"], $start + 9), ".");
		$version = substr($_SERVER["HTTP_USER_AGENT"], $start + 9, $length);
        $browser = "NetFront v.".$version;
    }

	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Android") !== false) {
        //$browser = "Android Webkit";
		$browser = $_SERVER["HTTP_USER_AGENT"];
    }
	
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "BingPreview") !== false) {
		$start = strpos($_SERVER["HTTP_USER_AGENT"], "BingPreview");
		$length = strpos(substr($_SERVER["HTTP_USER_AGENT"], $start + 12), ".");
		$version = substr($_SERVER["HTTP_USER_AGENT"], $start + 12, $length);
        $browser = "Bing v.".$version;
    }
		
    else {
        $browser = $_SERVER["HTTP_USER_AGENT"];
    }
    return $browser;
}

############################
#
#	nome: getos (Pega o Sistema Operacional)
#   descrição: identifica qual o sistema operacional que esta sendo usado pelo usuário
#
###########################
function getos(){
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$useragent = strtolower($useragent);

	if(strpos("$useragent", "windows nt 5.1") !== false) {
		return "Windows XP";
	}

	elseif (strpos("$useragent", "windows nt 6.0") !== false) {
		return "Windows Vista";
	}

	elseif (strpos("$useragent", "windows nt 6.1") !== false) {
		return "Windows 7";
	}

	elseif (strpos("$useragent", "windows 98") !== false) {
		return "Windows 98";
	}

	elseif (strpos("$useragent", "windows nt 5.0") !== false) {
		return "Windows 2000";
	}

	elseif (strpos("$useragent", "windows nt 5.2") !== false) {
		return "Windows 2003 server";
	}

	elseif (strpos("$useragent", "windows nt 6.0") !== false) {
		return "Windows Vista";
	}

	elseif (strpos("$useragent", "windows nt") !== false) {
		return "Windows NT";
	}

	elseif (strpos("$useragent", "win 9x 4.90") !== false && strpos("$useragent","win me")) {
		return "Windows ME";
	}
	elseif (strpos("$useragent", "win ce") !== false) {
		return "Windows CE";
	}

	elseif (strpos("$useragent", "win 9x 4.90") !== false) {
		return "Windows ME";
	}

	elseif (strpos("$useragent", "iphone") !== false) {
		return "iPhone";
	}

	elseif (strpos("$useragent", "mac os x") !== false) {
		return "Mac OS X";
	}

	elseif (strpos("$useragent", "macintosh") !== false) {
		return "Macintosh";
	}

	elseif (strpos("$useragent", "linux") !== false) {
		return "Linux";
	}
	
	elseif (strpos("$useragent", "freebsd") !== false) {
		return "Free BSD";
	}
	
	elseif (strpos("$useragent", "symbian") !== false) {
		return "Symbian";
	}

	elseif (strpos("$useragent", "samsung") !== false) {
		return "Samsung";
	}
	
	elseif (strpos("$useragent", "nokia") !== false) {
		return "Nokia";
	}
	
	elseif (strpos("$useragent", "googlebot") !== false) {
		return "GoogleBot";
	}
	
	elseif (strpos("$useragent", "ahrefsbot") !== false) {
		return "AhrefsBot";
	}
	
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "bingbot") !== false) {
        $browser = "BingBot";
    }
	
	elseif (strpos("$useragent", "facebookexternalhit") !== false) {
		return "Citação no Facebook";
	}
	
	else {
		return $_SERVER["HTTP_USER_AGENT"];
	}
}
?>