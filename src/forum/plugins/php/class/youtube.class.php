<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 12/05/12 #

class Youtube {
	##############################
	#
	#   funчуo xmlLoad
	#   Duas funчѕes juntas, que servem para abrir o XML com as informaчѕes do vэdeo no youtube
	#   $id = id do vэdeo a ter a URL carregada
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
	#   funчуo isValid
	#   Youtube щ vсlido? Essa funчуo valida a URL do youtube, se a URL for vсlida, ele retorna o ID do vэdeo
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