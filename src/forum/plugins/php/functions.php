<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 23/05/12 #

	/** ajusta o post para que ele possa ser utilizado */
	function post($post) {
		return adjust($_POST[$post]);
	}
	
	/** ajusta o get para que ele possa ser utilizado */
	function get($get) {
		if ($get == "?") {
			return $_SERVER["QUERY_STRING"];
		} else {
			return adjust($_GET[$get]);
		}
	}
	
	/** ajusta a informação como se fosse um post ou um get */
	function adjust($info) {
		return trim(addslashes(str_replace("'", "`", $info)));
	}
	
	/** verifica se uma das informações de um array existe em outro */
	function array_in_array($array1, $array2) {
		foreach ($array1 as $arr) {
			if (in_array($arr, $array2)) {
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/** pesquisa um elemento dentro de uma matriz */
	function in_matriz($search, $matriz) {
		if (gettype($matriz) == "array" OR gettype($matriz) == "resource") {
			foreach($matriz as $array) {
				if (gettype($array) == "array" OR gettype($array) == "resource") {
					return in_matriz($search, $array);
				} else {
					if ($search == $array) {
						return TRUE;
					}
				}
			}
		} else if ($search == $matriz) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/** pega somente alguns campos escolhidos de um array, os campos podem vir numa string separados por vírgua ou em um array */
	function select_array($arr, $fields) {
		if (gettype($fields) == "string") {
			$fields = str_replace("\n", "", $fields);
			$fields = str_replace(" ", "", $fields);
			$fields = explode(",", $fields);
		} else if (gettype($fields) != "array") {
			return FALSE;
		}
		
		foreach($arr as $key => &$piece) {
			if (!in_array($key, $fields)) {
				unset($arr[$key]);
			}
		}
		return $arr;
	}
	
	/** um array de arrays, considerando que todos esses arrays sejam iguais, essa função pega somente os campos desejados destes */
	function select_arrays($arr, $fields) {
		foreach ($arr as &$piece) {
			$piece = select_array($piece, $fields);
		}
		return $arr;
	}
	
	/** organizando o array de menor para maior apartir de um de suas chaves */
	function sksort(&$array, $subkey = "id", $sort_ascending = TRUE) {
		if (count($array))
			$temp_array[key($array)] = array_shift($array);

		foreach($array as $key => $val){
			$offset = 0;
			$found = FALSE;
			foreach($temp_array as $tmp_key => $tmp_val) {
				if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
					$temp_array = array_merge((array) array_slice($temp_array,0,$offset),
						array($key => $val),
						array_slice($temp_array,$offset)
					);
					$found = true;
				}
				$offset++;
			}
			if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
		}

		if ($sort_ascending) $array = array_reverse($temp_array);
		else $array = $temp_array;
	}
	
	/** pega o nome do arquivo sem a extenção */
	function get_file_noext($filename) {
		$retorno = get_file_ext($filename, TRUE);
		return $retorno["name"];
	}
	
	/** pega a extenção do arquivo */
	function get_file_ext($filename, $returnname = FALSE) {
		$filename = explode(".", $filename);
		if ($returnname == TRUE) {
			$ext = $filename[count($filename)-1];
			unset($filename[count($filename)-1]);
			$filename = implode(".", $filename);
			return array(0=>$ext, 1=>$filename, "ext"=>$ext, "filename"=>$filename, "name"=>$filename);
		}
		return $filename[count($filename)-1];
	}
	
	/** avisa que a operação foi bem sucedida e ainda envia mais informações */
	function success($return = TRUE, $arr = "") {
		if (gettype($arr) == "array") {
			echo(json_encode(array("success"=>(bool) $return, $arr)));
		} else {
			echo(json_encode(array("success"=>(bool) $return)));
		}
	}
	
	function callback($array) {
		if (gettype($array) == "array") {
			echo(json_encode($array));
		}
	}
	
	function urlDecompile($url) {
		return base64_decode($url);
	}
	
	function urlCompile($url = "") {
		if ($url == "") {
			return base64_encode($_SERVER["REQUEST_URI"]);
		} else {
			return base64_encode($url);
		}
	}
	
	function redirect($to, $iscompiled = FALSE) {
		@header("location: $to");
		echo("
			<script type='text/javascript'>
				window.location.href = '$to';
			</script>
		");
		exit();
	}
?>