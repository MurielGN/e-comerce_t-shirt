<?php

class Pedido{
	private $id;
	private $usuario_id;
	private $provincia;
	private $localidad;
	private $direccion;
	private $coste;
	private $estado;
	private $fecha;
	private $hora;

	private $db;
	
	public function __construct() {
		$this->db = Database::connect();
	}
	
	function getId() {
		return $this->id;
	}

	function getUsuario_id() {
		return $this->usuario_id;
	}

	function getProvincia() {
		return $this->provincia;
	}

	function getLocalidad() {
		return $this->localidad;
	}

	function getDireccion() {
		return $this->direccion;
	}

	function getCoste() {
		return $this->coste;
	}

	function getEstado() {
		return $this->estado;
	}

	function getFecha() {
		return $this->fecha;
	}

	function getHora() {
		return $this->hora;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setUsuario_id($usuario_id) {
		$this->usuario_id = $usuario_id;
	}

	function setProvincia($provincia) {
		$this->provincia = $this->db->real_escape_string($provincia);
	}

	function setLocalidad($localidad) {
		$this->localidad = $this->db->real_escape_string($localidad);
	}

	function setDireccion($direccion) {
		$this->direccion = $this->db->real_escape_string($direccion);
	}

	function setCoste($coste) {
		$this->coste = $coste;
	}

	function setEstado($estado) {
		$this->estado = $estado;
	}

	function setFecha($fecha) {
		$this->fecha = $fecha;
	}

	function setHora($hora) {
		$this->hora = $hora;
	}

	public function getAll(){
		$productos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC");
		return $productos;
	}
	
	public function getOne(){
		$producto = $this->db->query("SELECT p.*, u.nombre, u.apellidos
									FROM pedidos p, usuarios u
									WHERE p.usuario_id=u.id
									AND p.id = {$this->getId()}");
		return $producto->fetch_object();
	}
	
	public function getOneByUser(){
		$sql = "SELECT p.id, p.coste FROM pedidos p "
				//. "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
				. "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC LIMIT 1";
			
		$pedido = $this->db->query($sql);
			
		return $pedido->fetch_object();
	}
	
	public function getAllByUser(){
		$sql = "SELECT p.* FROM pedidos p "
				. "WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC";
			
		$pedido = $this->db->query($sql);
			
		return $pedido;
	}
	
	
	public function getProductosByPedido($id){
//		$sql = "SELECT * FROM productos WHERE id IN "
//				. "(SELECT producto_id FROM lineas_pedidos WHERE pedido_id={$id})";
	
		$sql = "SELECT pr.*, lp.unidades FROM productos pr "
				. "INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id "
				. "WHERE lp.pedido_id={$id}";
				
		$productos = $this->db->query($sql);
			
		return $productos;
	}
	
	public function save(){
		$sql = "INSERT INTO pedidos VALUES(NULL, {$this->getUsuario_id()}, '{$this->getProvincia()}', '{$this->getLocalidad()}', '{$this->getDireccion()}', {$this->getCoste()}, 'confirm', CURDATE(), CURTIME());";
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function save_linea(){
		$sql = "SELECT LAST_INSERT_ID() as 'pedido';";
		$query = $this->db->query($sql);
		$pedido_id = $query->fetch_object()->pedido;
		
		foreach($_SESSION['carrito'] as $elemento){
			$producto = $elemento['producto'];
			
			$insert = "INSERT INTO lineas_pedidos VALUES(NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']})";
			$save = $this->db->query($insert);
			
//			var_dump($producto);
//			var_dump($insert);
//			echo $this->db->error;
//			die();
		}
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}
	
	public function edit(){
		$sql = "UPDATE pedidos SET estado='{$this->getEstado()}' ";
		$sql .= " WHERE id={$this->getId()};";
		
		$save = $this->db->query($sql);
		
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
	}

	public function getDatosCliente(){
		$sql = "SELECT u.nombre, u.apellidos, u.email, p.direccion, p.provincia, p.localidad
				FROM usuarios u, pedidos p
				WHERE p.usuario_id=u.id  
				AND p.id = {$this->getId()};";
		$cliente = $this->db->query($sql);
		return $cliente->fetch_object();
	}

	public function getDatosAlbaran(){
		$arrDatos = [];
		$sql = "SELECT p.fecha as fecha, pr.id as prodID, pr.nombre as prodNom, precio, unidades, precio*unidades AS total, 
					(SELECT SUM(suma.total)
					FROM (SELECT precio*unidades AS total
						FROM pedidos p, lineas_pedidos l, productos pr
					WHERE p.id=l.pedido_id AND l.producto_id=pr.id
					AND p.id= {$this->getId()} ) AS suma) as TOTAL2
				FROM pedidos p, lineas_pedidos l, productos pr
				WHERE p.id=l.pedido_id AND l.producto_id=pr.id
				AND p.id= {$this->getId()}";
		$datos = $this->db->query($sql);
		while ($dato = $datos->fetch_object()){
			$arrDatos[] = $dato;
		}

		return $arrDatos;

	}

	public function getAlbaran($datosAlbaran, $datosCliente){
		
		$mpdf = new \Mpdf\Mpdf();
		
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->showImageErrors = true;
		$stylesheet = file_get_contents(base_url.'assets/css/albaran.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);

		$html = "";

        $mpdf->WriteHTML('<table id="cabecera">
        <tr>
            <td><img src="http://localhost/clase/workspace/php_mysql_tShirt_onlineStore_Project/master-php/assets/img/camiseta.png" width="100px"/></td>
            <td><p id="titulo">Tienda de camisetas</p></td>
            <td>    <div id="datosEmpresa">
                <p>
                    Tienda de Camisetas SLU <br>
                    Avda de los Soles, 2-3, Pol.Ind. El Solar. <br>
                    38033. Madrid. Madrid <br> 
                    CIF: B59743159 <br>
                </p>
            </div></td>
        </tr>
    </table>
    <hr>
    <h4>FACTURA SIMPLIFICADA</h4>
	<p>Datos de facturación</p>
    <div id="datC">
        Nombre: '.$datosCliente->nombre.' '.$datosCliente->apellidos.'<br>
        Dirección: '.$datosCliente->direccion.'<br>
        Pobración: '.$datosCliente->localidad.', '.$datosCliente->provincia.'<br>
        Email: '.$datosCliente->email.'
    </div>
	<br><br>
    <table>
        <tr>
            <td>Fecha: '.$datosAlbaran[0]->fecha.'</td>
            <td>Forma de pago: Tarjeta</td>
        </tr>
    </table>
    <br><br>
    <table>
        <tr>
            <td id="pedido">Albarán del pedido '.$this->getId().':</td>
        </tr>
    </table>
    <br>
    <table>
        <tr class="sombreado">
            <th>Cod</th><th style="width: 50%;">Artículo</th><th>Precio</th><th style="width: 6%;">Und</th><th>Total</th>
        </tr>');

		for ($i=0; $i < count($datosAlbaran); $i++) { 
			$code = "<tr><td>".$datosAlbaran[$i]->prodID."</td>
					<td>".$datosAlbaran[$i]->prodNom."</td>
					<td>".$datosAlbaran[$i]->precio."</td>
					<td>".$datosAlbaran[$i]->unidades."</td>
					<td>".$datosAlbaran[$i]->total."</td></tr>";
					$mpdf->WriteHTML($code);
		}

		$mpdf->WriteHTML('</tr>
    </table>
    <br><br>
    <table class="total">
        <tr class="sombreado">
            <th>Base Imponible</th><th>IVA</th><th colspan="2">TOTAL FACTURA</th>
        </tr>
        <tr>
            <td>'.round($datosAlbaran[0]->TOTAL2 * 0.79, 2).'</td><td>(21%) '.round($datosAlbaran[0]->TOTAL2 * 0.21,2).'</td><td colspan="2">'.$datosAlbaran[0]->TOTAL2.' €</td>
        </tr>
    </table>
    <table class="total">
        <tr>
            <td style="width: 85%;">TOTAL A PAGAR</td><td>'.$datosAlbaran[0]->TOTAL2.' €</td>
        </tr>
    </table>');
	

		$mpdf->Output();
	}
}