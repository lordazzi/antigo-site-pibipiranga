<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 08/01/13 #

class Page {
	public $account;
	
	public function __construct($array = array()) {
		//verificando se é necessario que esteja logado para visitar essa página
		$this->account = new Account();
		if ($this->account->isLogged() AND $array["logado"] == TRUE) {
			redirect("www.pibipiranga.com.br/forum/index.php?".urlCompile());
		}
		unset($array["logado"]);
		
		//Verificando se a pessoa tem acesso
		if (isSet($array["access"])) {
			$cansee = TRUE;
			foreach ($array["access"] as $acc) {
				if (!$this->account->haveAccess($acc)) {
					$cansee = FALSE;
				}
			}
			
			if ($cansee == FALSE) {
				redirect("/Time Travel OTS/index.php");
			}
		}
		unset($array["access"]);
		
		//Importando HTML
		require_once($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/php/incs/header.php");
		require_once($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/php/incs/menu.php");
	}
	
	public function __destruct() {
		require_once($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/php/incs/footer.php");
		echo('<script type="text/javascript" src="plugins/js/last-run.js"></script>');
	}
	
	public static function getMirror($type) {
		
		$espelho = explode("/", $_SERVER["PHP_SELF"]);
		for ($i = 0; $i < count($espelho)-2; $i++) {
			$new[$i] = $espelho[$i + 2];
		}
		$espelho = $new;

		switch ($type) {
			case "js":
				$ext = "js";
				break;
			case "css":
				$ext = "css";
				break;
			case "php":
				$ext = "php";
				break;
		}
		
		$file = $espelho[count($espelho)-1];
		$file = explode(".", $file);
		$file[count($file)-1] = $ext;
		$file = implode(".", $file);
		$espelho[count($espelho)-1] = $file;
		$espelho = implode("/", $espelho);
		
		if ($type == "css") {
			return "/forum/plugins/style.php?".urlCompile("../../mirror/$type/$espelho");
		} else {
			return "/forum/mirror/$type/$espelho";
		}
	}
	
	public static function unpathed($evoke) {
		$ext = get_file_ext($evoke);
		switch ($ext) {
			case "js":
				echo("<script type='text/javascript' src='/forum/mirror/$ext/unpathed/$evoke'></script>");
				break;
			case "css":
				echo("<link rel='stylesheet/less' type='text/css' href='/forum/plugins/style.php?".urlCompile("../../mirror/$ext/unpathed/$evoke")."' />");
				break;
			case "php":
				require_once("/forum/mirror/$ext/unpathed/$evoke");
				break;
		}
	}
}

?>