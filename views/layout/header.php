<!DOCTYPE HTML>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<title>Tienda de Camisetas</title>
	<!-- <link rel="stylesheet" href="<?= base_url ?>assets/css/styles.css" /> -->
	<!-- BOOTSTRAP -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/customstiles.css" />

</head>

<body>
	<div id="container-fluid">
		<!-- CABECERA -->
		<div class="container-fluid col-11 m-auto row p-0">
			<div class="col-1">
				<img src="<?= base_url ?>assets/img/camiseta.png" class="img-fluid" alt="Camiseta Logo" />
			</div>
			<div class="col-9">
				<a href="<?= base_url ?>" class="text-uppercase fs-4">Tienda de camisetas</a>
			</div>
			<div class="col-1 position-relative">
				<i class="bi bi-person position-absolute end-0 fs-4"></i>
			</div>
			<div class="col-1 position-relative">
				<i class="bi bi-cart2 position-absolute end-0 fs-4"></i>
			</div>

			<div class="input-group p-0">
				<input class="form-control m-0 border-end-0 border-2 border-warning" type="text" placeholder="¡Busca aquí tus temas preferidos!" aria-label="Search docs for...">
				<span class="input-group-append border border-2 border-start-0 border-warning rounded-end">
					<button class="btn" type="button">
					<i class="bi bi-search"></i>
					</button>
				</span>
			</div>



		</div>
		<header id="header">
			<div id="logo">

				<a href="<?= base_url ?>">
					Tienda de camisetas
				</a>
			</div>
		</header>










		<!-- MENU -->
		<?php $categorias = Utils::showCategorias(); ?>
		<nav id="menu">
			<ul>
				<li>
					<a href="<?= base_url ?>">Inicio</a>
				</li>
				<?php while ($cat = $categorias->fetch_object()) : ?>
					<li>
						<a href="<?= base_url ?>categoria/ver&id=<?= $cat->id ?>"><?= $cat->nombre ?></a>
					</li>
				<?php endwhile; ?>
				<li>
					<a href="<?= base_url ?>categoria/ver&oferta=true">OFERTAS</a>
				</li>
			</ul>
		</nav>

		<div id="content">