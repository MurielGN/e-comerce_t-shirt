<?php
require_once 'models/Pedido.php';
require_once 'models/Categoria.php';
require_once 'models/Producto.php';

class pedidoController{
	
	public function hacer(){

		$conexion = new Producto();
		foreach ($_SESSION['carrito'] as $productoCarrito) {
			$conexion->setId($productoCarrito['id_producto']);
			$producto = $conexion->getOne();
			if($producto->stock < $productoCarrito['unidades']){
				$_SESSION['SinStock'] = $producto->stock;
				require_once 'views/carrito/index.php';
			}
		}
		
		require_once 'views/pedido/hacer.php';
	}
	
	public function add(){
		if(isset($_SESSION['identity'])){
			$usuario_id = $_SESSION['identity']->id;
			$provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
			$localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
			$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
			
			$stats = Utils::statsCarrito();
			$coste = $stats['total'];
				
			if($provincia && $localidad && $direccion){
				// Guardar datos en bd
				$pedido = new Pedido();
				$pedido->setUsuario_id($usuario_id);
				$pedido->setProvincia($provincia);
				$pedido->setLocalidad($localidad);
				$pedido->setDireccion($direccion);
				$pedido->setCoste($coste);
				
				//Habría que hacer esto traccsacional*******
				$save = $pedido->save();
				
				// Guardar linea pedido
				$save_linea = $pedido->save_linea();

				//Descontar el stock
				$conexionProducto = new Producto();
				foreach ($_SESSION['carrito'] as $productoCarrito) {
					$conexionProducto->setId($productoCarrito['id_producto']);
					$conexionProducto->setStock($productoCarrito['unidades']);
					$producto = $conexionProducto->updateStock();
					if(!$producto) break;
				}
				
				
				if($save && $save_linea && $producto){
					$_SESSION['pedido'] = "complete";
					
					//header("Location:".base_url-"carrito/delete_all);
				}else{
					$_SESSION['pedido'] = "failed";
				}
				
			}else{
				$_SESSION['pedido'] = "failed";
			}
			
			header("Location:".base_url.'pedido/confirmado');			
		}else{
			// Redigir al index
			header("Location:".base_url);
		}
	}
	
	public function confirmado(){ 
		if(isset($_SESSION['identity'])){
			$identity = $_SESSION['identity'];
			$pedido = new Pedido();
			$pedido->setUsuario_id($identity->id);
			
			$pedido = $pedido->getOneByUser();
			
			$pedido_productos = new Pedido();
			$productos = $pedido_productos->getProductosByPedido($pedido->id);
			unset($_SESSION['carrito']); 
		}
		require_once 'views/pedido/confirmado.php';
	}
	
	public function mis_pedidos(){
		Utils::isIdentity();
		$usuario_id = $_SESSION['identity']->id;
		$pedido = new Pedido();
		
		// Sacar los pedidos del usuario
		$pedido->setUsuario_id($usuario_id);
		$pedidos = $pedido->getAllByUser();
		
		require_once 'views/pedido/mis_pedidos.php';
	}
	
	public function detalle(){
		Utils::isIdentity();
		

		if(isset($_GET['id'])){
			$id = $_GET['id'];
			
			// Sacar el pedido
			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido = $pedido->getOne();

			if($pedido->usuario_id != $_SESSION['identity']->id){
				header('Location:'.base_url.'pedido/mis_pedidos');
				exit();
			}

			$fechaEnvio = pedidoController::setFechEnv($pedido->fecha);
			
			// Sacar los poductos
			$pedido_productos = new Pedido();
			$productos = $pedido_productos->getProductosByPedido($id);

			// Sacar nombre del Usuario
			
			
			require_once 'views/pedido/detalle.php';
		}else{
			header('Location:'.base_url.'pedido/mis_pedidos');
		}
	}

	private static function setFechEnv($fecha){
		$explode = explode('-', $fecha);
		$fechaEnv = mktime(0,0,0,$explode[1],$explode[2],$explode[0]);
		$fechaEnv += 2*24*3600;
		$fechaEnv = date(DATE_ATOM,$fechaEnv);
		$fechaEnv = substr($fechaEnv,0,10);
		return $fechaEnv;
	}
	
	public function gestion(){
		Utils::isAdmin();
		$gestion = true;
		
		$pedido = new Pedido();
		$pedidos = $pedido->getAll();
		
		require_once 'views/pedido/mis_pedidos.php';
	}
	
	public function estado(){
		Utils::isAdmin();
		if(isset($_POST['pedido_id']) && isset($_POST['estado'])){
			// Recoger datos form
			$id = $_POST['pedido_id'];
			$estado = $_POST['estado'];
			
			// Upadate del pedido
			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido->setEstado($estado);
			$pedido->edit();
			
			header("Location:".base_url.'pedido/detalle&id='.$id);
		}else{
			header("Location:".base_url);
		}
	}

	public function cancelar(){
		if(isset($_GET['id'])){
			// Recoger datos form
			$id = $_GET['id'];
			
			// Upadate del pedido
			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido->setEstado("cancelled");
			$pedido->edit();

			if($pedido){
				$_SESSION['cancelado'] = true;
			}else{
				$_SESSION['cancealdo'] = false;
			}
			
			header("Location:".base_url.'pedido/detalle&id='.$id);
		}else{
			header("Location:".base_url);
		}
	}

	public function albaran(){
		$conexion = new Pedido();
		$id = $_GET['id'];
		$conexion->setId($id);

		$datosAlbaran = $conexion->getDatosAlbaran();
		$datosCliente = $conexion->getDatosCliente();
		

		$conexion->getAlbaran($datosAlbaran, $datosCliente);
	}
	
	
}