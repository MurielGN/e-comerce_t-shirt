<?php

class Categoria{
	private $id;
	private $nombre;
	private $db;
	//My code
	private $totalSold;
	private $stock;
	//End my code

	public function __construct() {
		$this->db = Database::connect();
	}
	
	//My code
	public function checkProdcutos(){
		$control = false;
		$query =  $this->db->query("SELECT id FROM productos WHERE categoria_id = '{$this->getId()}';");
		if($query->num_rows == 0){
			$control = true;
		}
		return $control;
	}

	public function delete(){
		$sql = "DELETE FROM categorias WHERE id={$this->id}";
		$delete = $this->db->query($sql);
		
		$result = false;
		if($delete){
			$result = true;
		}
		return $result;
	}
	//End my code

	function getId() {
		return $this->id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	public function getAll(){
		//$categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC;");
		$categorias = $this->db->query("SELECT * , (SELECT SUM(unidades*precio) FROM lineas_pedidos l, productos p WHERE l.producto_id=p.id AND p.categoria_id = c.id) AS 'totalSold', (SELECT sum(stock*precio) FROM productos WHERE categoria_id = c.id) AS 'stock' FROM categorias c ORDER BY id DESC ");
		return $categorias;
	}
	
	public function getOne(){
		$categoria = $this->db->query("SELECT * FROM categorias WHERE id={$this->getId()}");
		return $categoria->fetch_object();
	}
	
	public function save(){
		if($this->getId() != null){
			$sql = "UPDATE categorias SET nombre='{$this->getNombre()}' WHERE id='{$this->getId()}';";
		}else{
			$sql = "INSERT INTO categorias VALUES(NULL, '{$this->getNombre()}');";
		}

		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
}