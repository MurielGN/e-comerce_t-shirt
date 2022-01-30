<h1 class="col-11 mx-auto my-3 text-center">Algunos de nuestros productos</h1>

<div class="container-fluid col-11 m-auto row p-0 m-0"> <!-- Probar con grid -->
<?php while($product = $productos->fetch_object()): ?>
	<div class="col-6 col-sm-4 col-lg-3 p-0 my-2 m-auto border-top border-2">
	
		<div class="h-75 m-1 p-0">
		<a href="<?=base_url?>producto/ver&id=<?=$product->id?>">
			<?php if($product->imagen != null): ?>
				<img src="<?=base_url?>uploads/images/<?=$product->imagen?>" class="img-fluid"/>
			<?php else: ?>
				<img src="<?=base_url?>assets/img/camiseta.png" class="img-fluid"/>
			<?php endif; ?>
		</a>
		</div>


		<h2 class="m-0 p-0 text-capitalize fs-6 fw-bolder text-dark text-opacity-75"><?=$product->nombre?></h2>
		

			<?php if($product->descuento == 0):?>
			<p class=" text-muted my-0 py-0"><?= $product->precio ?> €</p>
			<?php else: ?>
				<p class="ms-1 text-success fw-bold my-0 py-0"><?= $product->precio * (100 - $product->descuento )/100 ?> €
				<span class="ms-1 text-danger text-decoration-line-through fs-6 my-0 py-0"><?= $product->precio ?> €</span></p>
			<?php endif; ?>

			<?php if($product->stock > 0):?>
				<a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="btn btn-success w-100 mt-0 mb-5">Comprar</a>
			<?php else: ?>
				<span class="btn btn-danger w-100 mt-0 mb-5">SIN STOCK</span>
			<?php endif; ?>
	</div>
<?php endwhile; ?>
</div>

<!-- <?php while($product = $productos->fetch_object()): ?>
	<div class="product">
		<a href="<?=base_url?>producto/ver&id=<?=$product->id?>">

			<?php if($product->imagen != null): ?>
				<img src="<?=base_url?>uploads/images/<?=$product->imagen?>" />
			<?php else: ?>
				<img src="<?=base_url?>assets/img/camiseta.png" />
			<?php endif; ?>
			<h2><?=$product->nombre?></h2>
		</a>
		
		<?php if($product->descuento == 0):?>
			<p><?= $product->precio ?></p>
		<?php else: ?>
			<p class="ofertaNueva"><?= $product->precio * (100 - $product->descuento )/100 ?>
			<span class="ofertaAntigua"><?= $product->precio ?></span></p>
		<?php endif; ?>

		<?php if($product->stock > 0):?>
			<a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
			<?php else: ?>
				<span class="sinStock">SIN STOCK</span>
			<?php endif; ?>
		
	</div>
<?php endwhile; ?> -->
