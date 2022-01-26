<?php
require_once 'models/Categoria.php';
require_once 'models/Producto.php';

class categoriaController{

	//My code
	public function editar(){
		Utils::isAdmin();
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$_SESSION['idCat'] = $id; //My code
			$edit = true;
			
			$categoria = new Categoria();
			$categoria->setId($id);
			
			$cat = $categoria->getOne();
			require_once 'views/categoria/crear.php';
			
		}else{
			header('Location:'.base_url.'Producto/gestion');
		}
	}

	public function eliminar(){
		Utils::isAdmin();
		
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$categoria = new Categoria();
			$categoria->setId($id);

			$stockCheck = $categoria->checkProdcutos();
			if($stockCheck){
				$delete = $categoria->delete();
				if($delete){
					$_SESSION['delete'] = 'complete';
				}else{
					$_SESSION['delete'] = 'failed';
				}
			}else{
				$_SESSION['delete'] = 'failed';
			}
		}else{
			$_SESSION['delete'] = 'failed';
		}
		
		header('Location:'.base_url.'Categoria/index');
	}
	//End my code
	
	public function index(){
		Utils::isAdmin(); //la clase utils de jelpers retorna true o refersca la página y te manda al inicio
		$categoria = new Categoria(); //La clase esta en models/
		$categorias = $categoria->getAll(); //Falla no coge categorias si no tienen stock o total

		require_once 'views/categoria/index.php';
	}
	
	public function ver(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			
			// Conseguir categoria
			$categoria = new Categoria();
			$categoria->setId($id);
			$categoria = $categoria->getOne();
			
			// Conseguir productos;
			$producto = new Producto();
			$producto->setCategoria_id($id);
			$productos = $producto->getAllCategory();
		}
		// My code
		if(isset($_GET['oferta']) && $_GET['oferta']){
			
			$producto = new Producto();
			$productos = $producto->getAllOfertas();
		}
		
		require_once 'views/categoria/ver.php';
	}
	
	public function crear(){
		Utils::isAdmin();
		require_once 'views/categoria/crear.php';
	}
	
	public function save(){
		Utils::isAdmin();
	    if(isset($_POST) && isset($_POST['nombre'])){
			// Guardar la categoria en bd
			$categoria = new Categoria();
			$categoria->setNombre($_POST['nombre']);
			$categoria->setId($_SESSION['idCat']);
			unset($_SESSION['idCat']);
			$save = $categoria->save();
			if($save){
				$_SESSION['categoria'] = "complete";
			}else{
				$_SESSION['categoria'] = "failed";
			}
		}else{
			$_SESSION['categoria'] = "failed";
		}
		header("Location:".base_url."categoria/index");
	}
	
}