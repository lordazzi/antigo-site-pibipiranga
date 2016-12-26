<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 03/10/12 #

class Xml {
	private $path = "";
	private $xml = "";
	private $json = "";
	private $array = "";

	private function unsetXMLComments($array) {
		unset($array["comment"]);
		foreach($array as &$piece) {
			if (gettype($piece) == "array") {
				$piece = $this->unsetXMLComments($piece);
			}
		}
		return $array;
	}
	
	public function __construct($path = "") {
		if ($path != "") {
			$this->read($path);
		}
	}
	
	public function read($path) {
		//xml
		if (file_exists($path)) {
			$this->xml = simplexml_load_file($path);
		} else {
			$this->xml = simplexml_load_string($path);
		}
		$this->path = $path;
		
		$adjuster = json_encode($this->xml);
		$adjuster = json_decode($adjuster, TRUE);
		$adjuster = $this->unsetXMLComments($adjuster);
		
		//json
		$this->json = json_encode($adjuster);
		
		//array
		$this->array = $adjuster;
	}
	
	public function getJson() {
		return $this->json;
	}
	
	public function getArray() {
		return $this->array;
	}
	
	public function getXml() {
		return $this->xml;
	}
}

?>