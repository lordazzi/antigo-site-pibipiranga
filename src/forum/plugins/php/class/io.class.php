<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 04/10/12 #

class IO {
	private $content = "";
	private $ext = "";
	private $file = "";
	private $json = "";
	private $array = "";
	
	private $xml = "";
	
	public function read($file) {
		//pegando a extenчуo
		$this->ext = get_file_ext($file);
	
		//posiчуo do arquivo
		$this->file = $file;
	
		//resetando as configuraчѕes do arquivo antigo
		$this->json = "";
		$this->array = "";
		$this->xml = "";
		
		$this->content = file_get_contents($file);
		return $this->content;
	}
	
	public function save($content, $path = "", $overwrite = TRUE) {
		if ($path == "") { $path = $this->file; }
		if ($overwrite == FALSE AND file_exists($path)) { return FALSE; }
		
		@unlink($path);
		$fp = fopen($path, "a");
		fwrite($fp, $content);
		fclose($fp);
		
		return $content;
	}
	
	public function getContent() {
		return $content;
	}
	
	public function getJson() {
		if ($this->json == "") {
			switch($this->ext) {
				case "log":
						$this->json = json_encode($this->getArray());
						return $this->json;
					break;
				case "xml":
						if ($this->xml != "") {
							$this->xml = new Xml($this->content);
						}
						$this->json = $this->xml->getJson();
						$this->array = $this->xml->getArray();
						return $this->json;
					break;
			}
		} else {
			return $this->json;
		}
	}
	
	public function getArray() {
		if ($this->array == "") {
			switch($this->ext) {
				case "log":
						$info = explode("\n", $content);
						foreach($info as &$cmd) {
							$cmd = explode(" /", $cmd);
							$cmd[1] = "/".$cmd[1];
						}
						$this->array = $info;
						return $this->array;
					break;
				case "xml":
						if ($this->xml != "") {
							$this->xml = new Xml($this->content);
						}
						$this->json = $this->xml->getJson();
						$this->array = $this->xml->getArray();
						return $this->array;
					break;
			}
		} else {
			return $this->array;
		}
	}
	
	public function readDir($dir) {
		$mydir = scandir($dir);
		foreach ($mydir as $file) {
			if (!($file == "." OR $file == ".." OR $file == "Thumbs.db")) {
				$files[] = $file;
			}
		}
		return $files;
	}
}

?>