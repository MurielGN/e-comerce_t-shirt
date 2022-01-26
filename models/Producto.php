<?php

class Producto{
	private $id;
	private $categoria_id;
	private $nombre;
	private $descripcion;
	private $precio;
	private $descuento;
	private $stock;
	private $oferta;
	private $fecha;
	private $imagen;

	private $db;
	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getCategoria_id() {
		return $this->categoria_id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function getDescripcion() {
		return $this->descripcion;
	}

	function getPrecio() {
		return $this->precio;
	}

	function getDescuento() {
		return $this->descuento;
	}

	function getStock() {
		return $this->stock;
	}

	function getOferta() {
		return $this->oferta;
	}

	function getFecha() {
		return $this->fecha;
	}

	function getImagen() {
		return $this->imagen;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setCategoria_id($categoria_id) {
		$this->categoria_id = $categoria_id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $this->db->real_escape_string($descripcion);
	}

	function setPrecio($precio) {
		$this->precio = $this->db->real_escape_string($precio);
	}

	function setDescuento($descuento) {
		$this->descuento = $this->db->real_escape_string($descuento);
	}

	function setStock($stock) {
		$this->stock = $this->db->real_escape_string($stock);
	}

	function setOferta($oferta) {
		$this->oferta = $this->db->real_escape_string($oferta);
	}

	function setFecha($fecha) {
		$this->fecha = $fecha;
	}

	function setImagen($imagen) {
		$this->imagen = $imagen;
	}
	
	public function getRandom($limit){
		$productos = $this->db->query("SELECT * FROM productos ORDER BY RAND() LIMIT $limit");
		return $productos;
	}
	
	public function getOne(){
		$producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()}");
		return $producto->fetch_object();
	}
	
	public function save(){
		$sql = "INSERT INTO productos VALUES(NULL, {$this->getCategoria_id()}, '{$this->getNombre()}', '{$this->getDescripcion()}', {$this->getPrecio()}, {$this->getStock()}, null, CURDATE(), '{$this->getImagen()}', {$this->getDescuento()});";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function edit(){
		$sql = "UPDATE productos SET nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio={$this->getPrecio()}, descuento={$this->getDescuento()}, stock={$this->getStock()}, categoria_id={$this->getCategoria_id()}";
		
		if($this->getImagen() != null){
			$sql .= ", imagen='{$this->getImagen()}'";
		}
		
		$sql .= " WHERE id={$this->id};";
		
		
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function delete(){
		$sql = "DELETE FROM productos WHERE id={$this->id}";
		$delete = $this->db->query($sql);
		
		$result = false;
		if($delete){
			$result = true;
		}
		return $result;
	}
	//My code

	public function getAll(){
		$productos = $this->db->query("SELECT * ,
				(SELECT SUM(l.unidades) FROM productos p, lineas_pedidos l WHERE p.id=l.producto_id AND p.id = pr.id) as 'totalVentas'
			FROM productos pr
			ORDER BY totalVentas DESC");

		$arrProductos = [];
		while ($pro = $productos->fetch_object()) {
			$arrProductos[] = $pro;
		}
		return $arrProductos;
	}

	public function getMaxVentas(){
		$sql = ("SELECT SUM(sumaVentas) as maxVentas
				FROM
				(
					SELECT SUM(l.unidades) as sumaVentas 
					FROM productos p, lineas_pedidos l
					WHERE p.id=l.producto_id
					GROUP BY p.id
				) T");
		$sqlResu = $this->db->query($sql);
		$max = $sqlResu->fetch_row();
		return $max[0];		
	}

	public function getAllCategory(){

		$sql = ("SELECT * FROM `productos` WHERE categoria_id = {$this->categoria_id}");
		$productos = $this->db->query($sql);

		return $productos;
	}

	public function getAllOfertas(){
		$sql = ("SELECT * FROM `productos` WHERE descuento != 0");
		$productos = $this->db->query($sql);
		return $productos;
	}

	public function updateStock(){
		$sql = "UPDATE productos SET stock = stock - {$this->getStock()} WHERE id = {$this->getId()}";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	//En my code
	
}