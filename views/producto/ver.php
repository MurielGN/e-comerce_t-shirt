<?php if (isset($product)): ?>
	<h1><?= $product->nombre ?></h1>
	<div id="detail-product">
		<div class="image">
			<?php if ($product->imagen != null): ?>
				<img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
			<?php else: ?>
				<img src="<?= base_url ?>assets/img/camiseta.png" />
			<?php endif; ?>
		</div>
		<div class="data">
			<p class="description"><?= $product->descripcion ?></p>

			<?php if($product->descuento == 0):?>
				<p class="price"><?= $product->precio ?>$</p>
				<?php else: ?>
					<div id="oferta">
						<div class="ofertaNueva"><p class="price"><?= $product->precio * (100 - $product->descuento )/100 ?></p></div>
						<div class="ofertaAntigua"><p class="price"><?= $product->precio ?></p></div>
					</div>
				<?php endif; ?>

			
			<?php if($product->stock > 0):?>
				<a href="<?=base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
			<?php else: ?>
				<a" class="button button-gestion button-red">SIN STOCK</a>
			<?php endif; ?>
		</div>
	</div>
<?php else: ?>
	<h1>El producto no existe</h1>
<?php endif; ?>
