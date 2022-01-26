<?php if (isset($categoria)): ?>
	<h1><?= $categoria->nombre ?></h1>
	<?php if ($productos->num_rows == 0): ?>
		<p>No hay productos para mostrar</p>
	<?php else: ?>

		<?php while ($product = $productos->fetch_object()): ?>
			<div class="product">
				<a href="<?= base_url ?>producto/ver&id=<?= $product->id ?>">
					<?php if ($product->imagen != null): ?>
						<img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
					<?php else: ?>
						<img src="<?= base_url ?>assets/img/camiseta.png" />
					<?php endif; ?>
					<h2><?= $product->nombre ?></h2>
				</a>

				<?php if($product->descuento == 0):?>
					<p><?= $product->precio ?></p>
				<?php else: ?>
					<p class="ofertaNueva"><?= $product->precio * (100 - $product->descuento )/100 ?></p>
					<p class="ofertaAntigua"><?= $product->precio ?></p>
				<?php endif; ?>
				
				<?php if($product->stock > 0):?>
					<a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
				<?php else: ?>
					<a" class="button button-gestion button-red">SIN STOCK</a>
				<?php endif; ?>
			
			</div>
		<?php endwhile; ?>

	<?php endif; ?>
<?php elseif($_GET['oferta']): ?>
	<h1>OFERTAS</h1>
	<?php if ($productos->num_rows == 0): ?>
		<p>No hay ofertas para mostrar</p>
	<?php else: ?>
		<?php while ($product = $productos->fetch_object()): ?>
			<div class="product">
				<a href="<?= base_url ?>producto/ver&id=<?= $product->id ?>">
					<?php if ($product->imagen != null): ?>
						<img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
					<?php else: ?>
						<img src="<?= base_url ?>assets/img/camiseta.png" />
					<?php endif; ?>
					<h2><?= $product->nombre ?></h2>
				</a>

					<p class="ofertaNueva"><?= $product->precio * (100 - $product->descuento )/100 ?></p>
					<p class="ofertaAntigua"><?= $product->precio ?></p>

				<a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
			</div>
		<?php endwhile; ?>

	<?php endif; ?>


<?php else: ?>
	<h1>La categoría no existe</h1>
<?php endif; ?>
