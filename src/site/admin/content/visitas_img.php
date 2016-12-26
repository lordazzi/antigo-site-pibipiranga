<?php
	include("../conn.php");
	if (!$_SESSION["S_poderes7"]) { exit; }
	header("Content-type: image/jpeg"); // define o tipo do arquivo

	$imagem = imagecreate(1310, 841); // define a largura e a altura da imagem
	$preto = imagecolorallocate($imagem, 0, 0, 0);
	$branco = imagecolorallocate($imagem, 255, 255, 255);
	$vermelho = imagecolorallocate($imagem, 255, 0, 0);
	
	imagettftext($imagem, 20, 0, 10, 30, $branco, "../../../plugins/fonts/arial.ttf", bd2human($_GET["d1"]));
	imagettftext($imagem, 20, 0, 1165, 30, $branco, "../../../plugins/fonts/arial.ttf", bd2human($_GET["d2"]));
	
	$days = diffDate($_GET["d1"], $_GET["d2"], "D");
	$style = "A"; //mostra o estilo em que o grafico serс mostrado: dividido por dias, semanas, meses ou anos, o padrуo inicial щ ano
	if ($days <= 420) { //se forem mais do que 10 os dias
		$style = "D";
		$write = "Grсfico em dias";
	}
	
	elseif ($days <= 2940) {
		$style = "S";
		$write = "Grсfico em semanas";
	}
	
	elseif ($days <= 12600) {
		$style = "M";
		$write = "Grсfico em meses";
	}
	
	else {
		$style = "A";
		$write = "Grсfico em anos";
	}
	
	imagettftext($imagem, 20, 0, 550, 32, $branco, "../../../plugins/fonts/arial.ttf", $write);
	
	//Carregando todas as datas entre o primeiro e o segundo dia indicados
	$bigger = 0; $internal_IntFor = 0; $IntFor2 = 0;
	for ($IntFor = 0; $IntFor <= $days; $IntFor++) {
		if ($style == "D") {
			$date_array[$IntFor][0] = nextday($_GET["d1"], $IntFor, "Y-m-d"); //registrando o dia a ser consultado no array, esse dia щ o primeiro dia da compraчуo mais a quantidade de dias dada pelo IntFor
			$data = mysql_query("SELECT * FROM visitas WHERE data='".addslashes($date_array[$IntFor][0])."'");
			$date_array[$IntFor][1] = mysql_num_rows($data);
			
			//o $bigger pega o dia que teve mais acessos
			if ($bigger < $date_array[$IntFor][1]) {
				$bigger = $date_array[$IntFor][1];
			}
		}
		
		//registrando por semanas
		elseif ($style == "S") {
			if (($IntFor % 7) == 6) {//jс щ o ultimo dia da semana?
				$date_array[$internal_IntFor][0] = nextday($_GET["d1"], $IntFor, "Y-m-d"); //Esse IntFor interno representa o IntFor para os graficos expostos em semana, mъs e ano
				$qtd = mysql_query("SELECT * FROM visitas WHERE data='".addslashes($date_array[$internal_IntFor][0])."'");
				$date_array[$internal_IntFor][1] = $tmp_array[0][1] + $tmp_array[1][1] + $tmp_array[2][1] + $tmp_array[3][1] + $tmp_array[4][1] + $tmp_array[5][1] + mysql_num_rows($qtd);
				
				//o $bigger pega a semana que teve mais acessos
				if ($bigger < $date_array[$internal_IntFor][1]) {
					$bigger = $date_array[$internal_IntFor][1];
				}
				$internal_IntFor++;
			}
			
			else {//se nуo, continua preenchendo o array temporсrio dessa semana
				$tmp_array[$IntFor % 7][0] = nextday($_GET["d1"], $IntFor, "Y-m-d");
				$qtd = mysql_query("SELECT * FROM visitas WHERE data='".addslashes($tmp_array[$IntFor % 7][0])."'");
				$tmp_array[$IntFor % 7][1] = mysql_num_rows($qtd);
			}
		}
		
		elseif($style == "M") {
			if (ITLDFM(nextday($_GET["d1"], $IntFor)) OR $IntFor == $days) { //Is The Last Day From Month?
				$date_array[$internal_IntFor][0] = nextday($_GET["d1"], $IntFor, "Y-m-d");
				$qtd = mysql_query("SELECT * FROM visitas WHERE data LIKE '".getyear($date_array[$internal_IntFor][0])."-".getmonth($date_array[$internal_IntFor][0])."-%'");
				$date_array[$internal_IntFor][1] = mysql_num_rows($qtd);

				//o $bigger pega o mъs que teve mais acessos
				if ($bigger < $date_array[$internal_IntFor][1]) {
					$bigger = $date_array[$internal_IntFor][1];
				}
				$internal_IntFor++;
			}
		}
		
		elseif($style == "A") {
			$date = nextday($_GET["d1"], $IntFor);
			if ((getmonth($date) == 12 AND getday($date) == 31) OR $IntFor == $days) { // o fim do ano ou o fim do for
				$date_array[$internal_IntFor][0] = nextday($_GET["d1"], $IntFor, "Y-m-d");
				$qtd = mysql_query("SELECT * FROM visitas WHERE data LIKE '".getyear($date_array[$internal_IntFor][0])."-%'");
				$date_array[$internal_IntFor][1] = mysql_num_rows($qtd);

				//o $bigger pega o mъs que teve mais acessos
				if ($bigger < $date_array[$internal_IntFor][1]) {
					$bigger = $date_array[$internal_IntFor][1];
				}
				$internal_IntFor++;
			}
		}
	}
	
	//Verifica como as informaчѕes de visitantes serуo apresentadas
	if ($bigger < 11) {
		$n1 = 1; $n2 = 2; $n3 = 3; $n4 = 4; $n5 = 5; $n6 = 6; $n7 = 7; $n8 = 8; $n9 = 9; $n10 = 10;
	}
	
	elseif ($bigger < 51) {
		$n1 = 5; $n2 = 10; $n3 = 15; $n4 = 20; $n5 = 25; $n6 = 30; $n7 = 35; $n8 = 40; $n9 = 45; $n10 = 50;
	}
	
	elseif ($bigger < 101) {
		$n1 = 10; $n2 = 20; $n3 = 30; $n4 = 40; $n5 = 50; $n6 = 60; $n7 = 70; $n8 = 80; $n9 = 90; $n10 = 100;
	}
	
	elseif ($bigger < 501) {
		$n1 = 50; $n2 = 100; $n3 = 150; $n4 = 200; $n5 = 250; $n6 = 300; $n7 = 350; $n8 = 400; $n9 = 450; $n10 = 500;
	}
	
	else {
		$n1 = 100; $n2 = 200; $n3 = 300; $n4 = 400; $n5 = 500; $n6 = 600; $n7 = 700; $n8 = 800; $n9 = 900; $n10 = 1000;
	}
	
	//Desenhando os retangulos horizontais brancos
	$posy1 = 41; $posy2 = 119;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n10, $preto);
	$posy1 += 80; $posy2 += 80;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n9, $preto);
	$posy1 += 80; $posy2 += 80;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n8, $preto);
	$posy1 += 80; $posy2 += 80;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n7, $preto);
	$posy1 += 80; $posy2 += 80;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n6, $preto);
	$posy1 += 80; $posy2 += 80;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n5, $preto);
	$posy1 += 80; $posy2 += 80;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n4, $preto);
	$posy1 += 80; $posy2 += 80;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n3, $preto);
	$posy1 += 80; $posy2 += 80;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n2, $preto);
	$posy1 += 80; $posy2 += 80;
	imagefilledrectangle($imagem, 1, $posy1, 1308, $posy2, $branco);
	imagestring($imagem, 5, 2, $posy1+2, $n1, $preto);
	
	//desenhando linha vertical ao lado dos nњmeros
	imagefilledrectangle($imagem, 30, 1, 31, 842, $preto);
	imagestring($imagem, 1, 30, $posy1+30, $info, $preto);
	
	$line_width = floor (1290 / count($date_array));
	for ($IntFor = 0; $IntFor < count($date_array); $IntFor++) {
		//calculando a posiчуo do ponto X, que щ o tamanho que ele tem de permissуo de ocupar ($line_width) multiplicado pelo contador do for, soma 20 para ignorar a barra do lado
		$posx = ($IntFor * $line_width) + 32;
		if ($n1 == 1) {
			//O tamanho total da imagem subtraindo a multiplicaчуo da altura de um campo horizontal pela quantidade de visitantes ($date_array[$IntFor][1])
			$posy = 840 - (80 * $date_array[$IntFor][1]);
		}
	
		elseif ($n1 == 5) {
			$posy = 840 - (16 * $date_array[$IntFor][1]);
		}
		
		elseif ($n1 == 10) {
			$posy = 840 - (8 * $date_array[$IntFor][1]);
		}
		
		elseif ($n1 == 50) {
			$posy = round(840 - (1.6 * $date_array[$IntFor][1]));
		}
		
		elseif ($n1 == 100) {
			$posy = round(840 - (0.8 * $date_array[$IntFor][1]));
		}
		
		if ($IntFor != 0) { //O primeiro sѓ tem uma posiчуo X e Y, nуo serve para compor uma linha
			imagesetthickness($imagem, 2);
			imageline($imagem, $last_posx, $last_posy, $posx, $posy, $vermelho);
		}
		//guardando a informaчуo da ultima vez que foi dado X e Y, para continuar criando a prѓxima linha dai
		$last_posx = $posx; $last_posy = $posy;
	}
	
	
	imagejpeg($imagem); // gera a imagem
	imagedestroy($imagem); // limpa a imagem da memoria
?>