<?php
require_once 'models/Producto.php';

class productoController{
	
	public function index(){
		$producto = new Producto();
		$productos = $producto->getRandom(8);
	
		// renderizar vista
		require_once 'views/producto/destacados.php';
	}
	
	public function ver(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
		
			$producto = new Producto();
			$producto->setId($id);
			
			$product = $producto->getOne();
			
		}
		require_once 'views/producto/ver.php';
	}
	
	public function crear(){
		Utils::isAdmin();
		require_once 'views/producto/crear.php';
	}
	
	public function save(){
		Utils::isAdmin();
		if(isset($_POST)){
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
			$precio = isset($_POST['precio']) ? $_POST['precio'] : false;
			$descuento = isset($_POST['descuento']) ? $_POST['descuento'] : false;
			$stock = isset($_POST['stock']) ? $_POST['stock'] : false;
			$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
			
			if($nombre && $descripcion && $precio && $stock && $categoria && $descuento){
				$producto = new Producto();
				$producto->setNombre($nombre);
				$producto->setDescripcion($descripcion);
				$producto->setPrecio($precio);
				$producto->setDescuento($descuento);
				$producto->setStock($stock);
				$producto->setCategoria_id($categoria);
				
				// Guardar la imagen
				if(isset($_FILES['imagen'])){
					$file = $_FILES['imagen'];
					$filename = $file['name'];
					$mimetype = $file['type'];

					if($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif'){

						if(!is_dir('uploads/images')){
							mkdir('uploads/images', 0777, true);
						}

						$producto->setImagen($filename);
						move_uploaded_file($file['tmp_name'], 'uploads/images/'.$filename);
					}
				}
				
				if(isset($_GET['id'])){
					$id = $_GET['id'];
					$producto->setId($id);
					
					$save = $producto->edit();
				}else{
					$save = $producto->save();
				}
				
				if($save){
					$_SESSION['producto'] = "complete";
				}else{
					$_SESSION['producto'] = "failed";
				}
			}else{
				$_SESSION['producto'] = "failed";
			}
		}else{
			$_SESSION['producto'] = "failed";
		}
		header('Location:'.base_url.'Producto/gestion');
	}
	
	public function editar(){
		Utils::isAdmin();
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$edit = true;
			
			$producto = new Producto();
			$producto->setId($id);
			
			$pro = $producto->getOne();

			if($pro->id){
				$_SESSION['editarProducto'] = $id;
			}
			
			require_once 'views/producto/crear.php';
			
		}else{
			header('Location:'.base_url.'Producto/gestion');
		}
	}
	
	public function eliminar(){
		Utils::isAdmin();
		
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$producto = new Producto();
			$producto->setId($id);
			
			$delete = $producto->delete();
			if($delete){
				$_SESSION['delete'] = 'complete';
			}else{
				$_SESSION['delete'] = 'failed';
			}
		}else{
			$_SESSION['delete'] = 'failed';
		}
		
		header('Location:'.base_url.'Producto/gestion');
	}

	//My code
	public function gestion(){
		Utils::isAdmin();
		
		$producto = new Producto();
		$arrProductos = $producto->getAll();

		productoController::orderProducts($arrProductos);
		$maxVent = $producto->getMaxVentas();


		if(!isset($_SESSION['pag'])){
			$_SESSION['pag'] = 1;
		}else{
			if(isset($_GET['pag'])){
				self::getPag($arrProductos);
			}else{
				$_SESSION['pag'] = 1;
			}
		}

		$arrProductos = self::sliceArr($arrProductos, 5);

		require_once 'views/producto/gestion.php';
	}

	private static function orderProducts(&$arrProductos){
		//change the order result
		if(isset($_GET['order'])){
			$_SESSION['orderList'] = isset($_SESSION['orderList'])? !$_SESSION['orderList'] : true;
			$_SESSION['order'] = $_GET['order'];
		}

		switch ($_SESSION['order']) {

			case 'id':
				usort($arrProductos, function($a,$b){
					return $_SESSION['orderList']? $a->id - $b->id : $b->id - $a->id;				
				});break;					

			case 'nombre':
				usort($arrProductos, function ($a, $b){
					return strnatcmp(strtolower($a->nombre), strtolower($b->nombre));
				});
				if($_SESSION['orderList']) $arrProductos = array_reverse($arrProductos);
				break;

			case 'precio':
				usort($arrProductos, function($a,$b){
					return $_SESSION['orderList']? $a->precio - $b->precio : $b->precio - $a->precio;				
				});break;
			
			case 'descuento':
				usort($arrProductos, function($a,$b){
					return $_SESSION['orderList']? $a->descuento - $b->descuento : $b->descuento - $a->descuento;				
				});break;

			case 'stock':
				usort($arrProductos, function($a,$b){
					return $_SESSION['orderList']? $a->stock - $b->stock : $b->stock - $a->stock;				
				});break;
			
			case 'totalVentas':
				usort($arrProductos, function($a,$b){
					return $_SESSION['orderList']? $a->totalVentas - $b->totalVentas : $b->totalVentas - $a->totalVentas;				
				});break;
			
		}
	}

	private static function getPag($arrProductos){
		$maxPag = floor(count($arrProductos)/5);
		if(count($arrProductos)%5 != 0) $maxPag++;

		switch ($_GET['pag']) {
			case 'principio':
				$_SESSION['pag'] = 1;
				break;

			case 'anterior':
				if($_SESSION['pag'] > 1){
					$_SESSION['pag']--;
				}
				break;

			case 'siguiente':
				if($_SESSION['pag'] < $maxPag) $_SESSION['pag']++;
				break;
				
			case 'final':
				$_SESSION['pag'] = $maxPag;
				break;
		}
		//$arrAux = array_chunk($arrProductos, 5);
		//$arrProductos = $arrAux[$_SESSION['pag']-1];

		/*$inicio = 5 * ($_SESSION['pag']-1);
		$final = (5 * $_SESSION['pag']);
		$arrAux = array_slice($arrProductos, $inicio, $final);
		$arrProductos = $arrAux;*/
	}

	private static function sliceArr($arr, $size):array{
		$arrResu = [];
		$arrResu = array_chunk($arr, $size);

		return $arrResu[$_SESSION['pag']-1];

	}
	//End my code
	
}