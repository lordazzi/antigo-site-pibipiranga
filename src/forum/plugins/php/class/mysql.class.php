<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 31/10/12 #

class MySql {
	private $conn;
	
	public function __construct() {
		$this->conn = mysql_connect("mysql03.pibipiranga.com.br", "pibipiranga12", "A1B2C3D4");
		mysql_select_db("pibipiranga12");
	}
	
	public function __destruct() {
		//@mysql_close($this->conn);
	}
	
	public function Query($query) {
		$data = mysql_query($query);
		//Se retornar informaчуo, essa informaчуo щ organizada
		if (gettype($data) == "resource") {
			$getvales = array();
			$i = 0;
			while ($retorno = mysql_fetch_array($data)) {
				foreach ($retorno as $key => $value) {
					if (!is_numeric($key)) {
						if (substr($key, 0, 2) == "dt") {
							$getvales[$i][$key] = (int) strtotime($value);
						} else {
							$getvales[$i][$key] = $value;
						}
					}
				}
				$i++;
			}
			return $getvales;
		} else {
			//Se nуo tiver data, verifica se tem como retornar o ultimo id de AUTO_INCREMENT
			$id =  mysql_insert_id();
			if ($id != FALSE) {
				return $id;
			} else {
				return FALSE;
			}
		}
	}
	
	public function getJson($query) {
		if (gettype($query) != "string") {
			return json_encode(array("success"=> (bool) $query)); //fazendo um success true
		} else {
			return json_encode($this->Query($query));
		}
	}
}
?>