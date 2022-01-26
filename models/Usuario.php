<?php

class Usuario{
	private $id;
	private $nombre;
	private $apellidos;
	private $email;
	private $direccion;
	private $password;
	private $rol;
	private $imagen;
	private $db;

	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function getApellidos() {
		return $this->apellidos;
	}

	function getEmail() {
		return $this->email;
	}

	function getDireccion() {
		return $this->direccion;
	}

	function getPassword() {
		return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
	}

	function getRol() {
		return $this->rol;
	}

	function getImagen() {
		return $this->imagen;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->db->real_escape_string($nombre);
	}

	function setApellidos($apellidos) {
		$this->apellidos = $this->db->real_escape_string($apellidos);
	}

	function setEmail($email) {
		$this->email = $this->db->real_escape_string($email);
	}

	function setDireccion($direccion) {
		$this->direccion = $this->db->real_escape_string($direccion);
	}


	function setPassword($password) {
		$this->password = $password;
	}

	function setRol($rol) {
		$this->rol = $rol;
	}

	function setImagen($imagen) {
		$this->imagen = $imagen;
	}

	public function save(){
		$sql = "INSERT INTO usuarios VALUES(NULL, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', 'user', '{$this->getImagen()}', '{$this->getDireccion()}');";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function login(){
		$result = false;
		$email = $this->email;
		$password = $this->password;
		
		// Comprobar si existe el usuario
		$sql = "SELECT * FROM usuarios WHERE email = '$email'";
		$login = $this->db->query($sql); //Que devuelve??
		
		
		if($login && $login->num_rows == 1){ //Entiendo que login es true si no es false
			$usuario = $login->fetch_object();
			
			// Verificar la contraseña
			$verify = password_verify($password, $usuario->password);
			
			if($verify){ 
				$result = $usuario;
			}
		}
		
		return $result;
	}

	//My code
	public function getAll(){
		$usuario = $this->db->query("SELECT u.id, nombre, apellidos, email, rol, (SELECT sum(coste) FROM `pedidos` WHERE usuario_id = u.id) AS 'Coste_Pedidos', (SELECT count(*) FROM `pedidos` WHERE usuario_id = u.id AND estado = 'sended') AS 'Pendientes' FROM `usuarios` u ORDER by id DESC ");
		return $usuario;
	}

	public function getOne(){
		$usuario = $this->db->query("SELECT * FROM usuarios WHERE id={$this->getId()}");
		return $usuario->fetch_object();
	}

	public function saveAdmin(){
		$sql = "UPDATE usuarios SET nombre='{$this->getNombre()}', apellidos='{$this->getApellidos()}', email='{$this->getEmail()}', rol='{$this->getRol()}' WHERE id='{$this->getId()}';";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}

	public function checkPedidos(){
		$control = false;
		$query =  $this->db->query("SELECT * FROM `pedidos` WHERE usuario_id = '{$this->getId()}' AND estado = 'sended';");
		if($query->num_rows == 0){
			$control = true;
		}
		return $control;
	}

	public function delete(){
		$id = $this->id;
		$transactionConection = new Usuario();
		//$transactionConection->db = new mysqli("localhost", "root", "root", "tienda_master");
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$transactionConection->db->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
		try{

			$arrIdPedidos = $this->getLineasPedididos($id);
			$sql1 = [];
			foreach($arrIdPedidos as $idPedido){
				$sql1[] = "DELETE FROM lineas_pedidos WHERE pedido_id = {$idPedido[0]}";
			}
			$sql2 = "DELETE FROM pedidos WHERE usuario_id = {$id};";
			$sql3 = "DELETE FROM usuarios WHERE id = {$id};";

		
			for($i=0;$i<count($sql1);$i++){
				$transactionConection->db->query($sql1[$i]);
			}
			$transactionConection->db->query($sql2);
			$transactionConection->db->query($sql3);

		} catch (mysqli_sql_exception $e){
			$transactionConection->db->rollback();
			return false;
		}

		$transactionConection->db->commit();
		$transactionConection->db->close();

		return true;
	}

	private function getLineasPedididos($id):array{
		$arr = array();

		$query = $this->db->query("SELECT DISTINCT p.id FROM pedidos p, lineas_pedidos l WHERE p.id=l.pedido_id AND p.usuario_id = '{$id}';");
		if($query){
			$arr = $query->fetch_all();
		}		

		return $arr;
	}

	public function updateUsuario($arrMod){
		$textSQL = "UPDATE usuarios SET ";
		foreach($arrMod as $attribute => $value){
			$textSQL .= $attribute." = '".$value."', ";
		}
		$textSQL = substr($textSQL, 0, -2);
		$textSQL .= " WHERE id = ".$this->getId();

		$save = $this->db->query($textSQL);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}

	public function checkEmail($email):bool{
		$query = $this->db->query("SELECT * FROM `usuarios` WHERE email = '{$email}'");

		if ($query->num_rows > 0) {
			return false;
		}else{
			return true;
		}
	}
	//End my code
	
	
	
}