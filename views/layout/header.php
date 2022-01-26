<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Tienda de Camisetas</title>
		<!-- <link rel="stylesheet" href="<?=base_url?>assets/css/styles.css" /> -->
		<!-- BOOTSTRAP -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
	</head>
	<body>
		<div id="container-fluid">
			<!-- CABECERA -->
			<div class="container-fluid col-12 row">
				<div class="col-1">
					<img src="<?=base_url?>assets/img/camiseta.png" class="img-fluid" alt="Camiseta Logo" />
				</div>
				<div class="col-4">
				<a href="<?=base_url?>">Tienda de camisetas</a>
				</div>
				<div class="col-1">
					<i class="bi bi-person"></i>
				</div>
				<div class="col-1">
					<i class="bi bi-cart2"></i>
				</div>
	
				
				
			</div>
			<header id="header">
				<div id="logo">
					
					<a href="<?=base_url?>">
						Tienda de camisetas
					</a>
				</div>
			</header>










			<!-- MENU -->
			<?php $categorias = Utils::showCategorias(); ?>
			<nav id="menu">
				<ul>
					<li>
						<a href="<?=base_url?>">Inicio</a>
					</li>
					<?php while($cat = $categorias->fetch_object()): ?>
						<li>
							<a href="<?=base_url?>categoria/ver&id=<?=$cat->id?>"><?=$cat->nombre?></a>
						</li>
					<?php endwhile; ?>
					<li>
					<a href="<?=base_url?>categoria/ver&oferta=true">OFERTAS</a>
					</li>
				</ul>
			</nav>

			<div id="content">