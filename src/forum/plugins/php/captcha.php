<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 19/09/12 #

   session_start(); // inicial a sessao
   header("Content-type: image/jpeg"); // define o tipo do arquivo
   
    function captcha($largura, $altura, $tamanho_fonte, $quantidade_letras) {
        $imagem = imagecreate($largura, $altura); // define a largura e a altura da imagem
		$path = "../fonts";
		
		$randon_fonte = rand(0, 9);
		if ($randon_fonte == 0) { $fonte = "$path/aenigma.ttf"; }
		elseif ($randon_fonte == 1) { $fonte = "$path/airmole.ttf"; }
		elseif ($randon_fonte == 2) { $fonte = "$path/akashi.ttf"; }
		elseif ($randon_fonte == 3) { $fonte = "$path/aliens.ttf"; }
		elseif ($randon_fonte == 4) { $fonte = "$path/android.ttf"; }
		elseif ($randon_fonte == 5) { $fonte = "$path/bosox.ttf"; }
		elseif ($randon_fonte == 6) { $fonte = "$path/gringo.ttf"; }
		elseif ($randon_fonte == 7) { $fonte = "$path/jagga.ttf"; }
		elseif ($randon_fonte == 8) { $fonte = "$path/lewisham.ttf"; }
		elseif ($randon_fonte == 9) { $fonte = "$path/lightout.ttf"; }
		
		$cores = rand(0, 9);
		if ($cores == 0) {
			$r1 = 255; $g1 = 255; $b1 = 255; // define a cor branca
			$r2 = 0; $g2 = 0; $b2 = 0; // define a cor preta
		}
		
		elseif ($cores == 1) {
			$r1 = 0; $g1 = 0; $b1 = 0; // define a cor preta
			$r2 = 255; $g2 = 255; $b2 = 255; // define a cor branca
		}
		
		elseif ($cores == 2) {
			$r1 = 255; $g1 = 0; $b1 = 0; // define a cor vermelha
			$r2 = 0; $g2 = 255; $b2 = 255; // define a cor ciano
		}
		
		elseif ($cores == 3) {
			$r1 = 0; $g1 = 255; $b1 = 255; // define a cor ciano
			$r2 = 255; $g2 = 0; $b2 = 0; // define a cor vermelho
		}
		
		elseif ($cores == 4) {
			$r1 = 255; $g1 = 102; $b1 = 0; // define a cor laranja
			$r2 = 0; $g2 = 102; $b2 = 255; // define a cor azul
		}
		
		elseif ($cores == 5) {
			$r1 = 0; $g1 = 102; $b1 = 255; // define a cor azul
			$r2 = 255; $g2 = 102; $b2 = 0; // define a cor laranja
		}
		
		elseif ($cores == 6) {
			$r1 = 255; $g1 = 255; $b1 = 0; // define a cor amarelo
			$r2 = 0; $g2 = 0; $b2 = 255; // define a cor azul
		}
		
		elseif ($cores == 7) {
			$r1 = 0; $g1 = 0; $b1 = 255; // define a cor azul
			$r2 = 255; $g2 = 255; $b2 = 0; // define a cor amarelo
		}
		
		elseif ($cores == 8) {
			$r1 = 51; $g1 = 255; $b1 = 0; // define a cor verde
			$r2 = 204; $g2 = 0; $b2 = 255; // define a cor magenta
		}
		
		elseif ($cores == 9) {
			$r1 = 204; $g1 = 0; $b1 = 255; // define a cor verde
			$r2 = 51; $g2 = 255; $b2 = 0; // define a cor magenta
		}
		
        $preto  = imagecolorallocate($imagem, $r1, $g1, $b1); // define a cor preta
        $branco = imagecolorallocate($imagem, $r2, $g2, $b2); // define a cor branca
       
        // define a palavra conforme a quantidade de letras definidas no parametro $quantidade_letras
		/*$randomize = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "Y", "X", "W", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
		$qtdd = rand(4, $quantidade_letras);
		$captcha = "";
		for ($i = 0; $i < $qtdd; $i++) {
			$captcha .= $randomize[rand(0, strlen($randomize)-1)];
		}*/
		
        $captcha = substr(str_shuffle("ABCDEFGHIJKLMNPQRSTUVYXWZ0123456789"), 0, ($quantidade_letras));
        $_SESSION["palavra"] = $captcha; // atribui para a sessao a palavra gerada
        for($i = 0; $i < $quantidade_letras; $i++){
            imagettftext($imagem, $tamanho_fonte, rand(-5, 5), (($tamanho_fonte+5)*$i)+20, ($tamanho_fonte + 20),$branco, $fonte, $captcha[$i]); // atribui as letras a imagem
        }
        imagejpeg($imagem); // gera a imagem
        imagedestroy($imagem); // limpa a imagem da memoria
    }
 
    captcha(225, 70, 30, rand(4, 6)); // executa a funcao captcha passando os parametros recebidos
?>