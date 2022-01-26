<h1>Algunos de nuestros productos</h1>

<?php while($product = $productos->fetch_object()): ?>
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
<?php endwhile; ?>
