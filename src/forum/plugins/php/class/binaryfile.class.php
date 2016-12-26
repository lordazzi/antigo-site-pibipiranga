<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 19/09/12 #

class BinaryFile extends Math {
	private $cursor = 0;
	private $path = "";
	private $file = "";
	
	public function __construct($path) {
		$this->open($path);
	}
	
	public function open($path) {
		$this->path = $path;
		$this->file = fopen($path, "rb");
	}
	
	//Leitura que avanчa o cursor
	public function readByte() {
		$this->cursor += 1;
		$mybyte = unpack("C", fread($this->file, 1));
		return $mybyte[1];
	}
	
	public function readChar() {
		$this->cursor += 1;
		$mychar = unpack("A", fread($this->file, 1));
		return $mychar[1];
	}
	
	public function readInt16() {
		$value[0] = $this->readByte();
		$value[1] = $this->readByte();
		return BinaryFile->byte2UInt16($value[0], $value[1]);
	}
	
	public function readInt32() {
		$value[0] = $this->readByte();
		$value[1] = $this->readByte();
		$value[2] = $this->readByte();
		$value[3] = $this->readByte();
		return BinaryFile->byte2Int32($value[0], $value[1], $value[2], $value[3]);
	}
	
	public function readInt64() {
		$value[0] = $this->readByte();
		$value[1] = $this->readByte();
		$value[2] = $this->readByte();
		$value[3] = $this->readByte();
		$value[4] = $this->readByte();
		$value[5] = $this->readByte();
		$value[6] = $this->readByte();
		$value[7] = $this->readByte();
		return BinaryFile->byte2Int64($value[0], $value[1], $value[2], $value[3], $value[4], $value[5], $value[6], $value[7]);
	}
	
	//Alterando ou vendo a posiчуo do cursor no arquivo
	public function setPosition($position) {
		fseek($this->file, $position);
		$this->cursor = $position;
	}
	
	public function getPosition() {
		return $this->cursor;
	}
	
	//Encerra a leitura do arquivo
	public function close() {
		fclose($this->file);
		$this->cursor = 0;
		$this->path = "";
		$this->file = "";
	}
	
	public function __destruct() {
		$this->close();
	}
}
?>