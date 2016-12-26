<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 12/05/12 #

class Youtube {
	##############################
	#
	#   fun��o xmlLoad
	#   Duas fun��es juntas, que servem para abrir o XML com as informa��es do v�deo no youtube
	#   $id = id do v�deo a ter a URL carregada
	#
	##############################

	public function xmlLoad($id) {
		return simplexml_load_string(load_file_from_url("http://gdata.youtube.com/feeds/api/videos/".$id));
	}

	private function load_file_from_url($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($curl, CURLOPT_REFERER, 'http://www.pibipiranga.com.br');
		$str = curl_exec($curl);
		curl_close($curl);
		return $str;
	}

	##############################
	#
	#   fun��o isValid
	#   Youtube � v�lido? Essa fun��o valida a URL do youtube, se a URL for v�lida, ele retorna o ID do v�deo
	#   $url = URL a ser validada
	#
	##############################

	public function isValid($url) {
		preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $output);
		if ($output[0]) {
			return $output[0];
		}
		
		else {
			return false;
		}
	}
}
?>