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
	
	<link rel="stylesheet" type="text/css" href="<?= base_url ?>assets/css/customstyles.css" /> 
</head>

<body>

	<div id="container">
		<!-- CABECERA -->
		<header id="header">
			<div class="container-fluid col-11 m-auto p-0 row bg-light border-bottom">

				<div class="col-1 col-lg-1 order-1 order-lg-1 p-1">
					<img src="<?= base_url ?>assets/img/camiseta.png" class="img-fluid" alt="Camiseta Logo" />
				</div>

				<div class="col-9 col-lg-3 order-2 order-lg-2 p-0 my-auto mx-0 ">
					<a href="<?= base_url ?>" class="text-uppercase fs-4" id="tituloHeader">Tienda de camisetas</a>
				</div>

				<div class="col-1 col-lg-1 order-3 order-lg-4 position-relative p-0 my-auto">&nbsp;
					<i class="bi bi-person position-absolute end-0 fs-4"></i>
				</div>

				<div class="col-1 col-lg-1 order-4 order-lg-5 position-relative p-0 my-auto">
				<?php $stats = Utils::statsCarrito(); ?>&nbsp;
					<a href="<?=base_url?>carrito/index">
						<i class="bi bi-cart2 position-absolute end-0 fs-4"><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?=$stats['count']?></span></i>
					</a>	
				</div>
				
				<div class="col-12 col-lg-6 order-4 oreder-5 order-lg-3 p-0 my-auto mx-0">
				<div class="input-group p-0">
					<input class="form-control m-0 border-end-0 border-2 border-warning" type="text" placeholder="¡Busca aquí tus temas preferidos!" aria-label="Search docs for...">
					<span class="input-group-append border border-2 border-start-0 border-warning rounded-end">
						<button class="btn bg-white" type="button">
						<i class="bi bi-search"></i>
						</button>
					</span>
				</div>
				</div>

			</div>
		</header>

		<!-- MENU sm-->
		<nav class="navbar navbar-light d-sm-none">
                      <div class="container-fluid col-11 m-auto ps-0">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                          <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="visibility: hidden;" aria-hidden="true">
                          <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                              Categorías
                            </h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                          </div>
                          <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
							  <?php $categorias = Utils::showCategorias(); ?>
							  	<?php while ($cat = $categorias->fetch_object()) : ?>
									<li class="nav-item">
										<hr>
										<a class="nav-link active" aria-current="page" href="<?= base_url ?>categoria/ver&id=<?= $cat->id ?>"><?= $cat->nombre ?></a>
									</li>
								<?php endwhile; ?>
								<li class="nav-item">
							  	<hr>
                                <a class="nav-link active" aria-current="page" href="<?= base_url ?>categoria/ver&oferta=true">OFERTAS</a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </nav>
		<!-- MENU sm-->
		<div class="d-none d-sm-block">
		<div class="container-fluid col-11">
			<?php $categorias = Utils::showCategorias(); ?>
			<ul class="nav justify-content-center">
			<?php while ($cat = $categorias->fetch_object()) : ?>
				<!-- <a href="<?= base_url ?>categoria/ver&id=<?= $cat->id ?>" class="col-1"><?= $cat->nombre ?></a> -->
				<li class="nav-item">
					<a class="nav-link active text-body text-uppercase" aria-current="page" href="<?= base_url ?>categoria/ver&id=<?= $cat->id ?>"><?= $cat->nombre ?></a>
				</li>

			<?php endwhile; ?>
			<!-- <a href="<?= base_url ?>categoria/ver&oferta=true" class="col align-self-center">OFERTAS</a> -->
			<li class="nav-item ">
					<a class="nav-link active text-body text-uppercase" aria-current="page" href="<?= base_url ?>categoria/ver&oferta=true">OFERTAS</a>
			</li>		
		</div>
		</div>





		<!-- <?php $categorias = Utils::showCategorias(); ?>
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
		</nav> -->

		<div id="content">