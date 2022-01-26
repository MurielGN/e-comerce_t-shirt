<h1>Gestión de productos</h1>

<a href="<?=base_url?>producto/crear" class="button button-small">
	Crear producto
</a>

<strong>Total de ventas realizadas: <?= $maxVent ?></strong><br>


<?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'complete'): ?>
	<strong class="alert_green">El producto se ha creado correctamente</strong>
<?php elseif(isset($_SESSION['producto']) && $_SESSION['producto'] != 'complete'): ?>	
	<strong class="alert_red">El producto NO se ha creado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('producto'); ?>
	
<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
	<strong class="alert_green">El producto se ha borrado correctamente</strong>
<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] != 'complete'): ?>	
	<strong class="alert_red">El producto NO se ha borrado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('delete'); ?>
	
<table>
	<tr>
		<th><a href="<?=base_url?>producto/gestion&order=id">ID</a></th>
		<th><a href="<?=base_url?>producto/gestion&order=nombre">NOMBRE</a></th>
		<th><a href="<?=base_url?>producto/gestion&order=precio">PRECIO</a></th>
		<th><a href="<?=base_url?>producto/gestion&order=descuento">DESCUENTO</a></th>
		<th><a href="<?=base_url?>producto/gestion&order=stock">STOCK</a></th>
		<th><a href="<?=base_url?>producto/gestion&order=totalVentas">TOTAL VENTAS</a></th>
		<th>ACCIONES</th>

	</tr>
	<?php for($i = 0; $i< count($arrProductos); $i++): ?>
		<tr>
			<td><?=$arrProductos[$i]->id;?></td>
			<td><?=$arrProductos[$i]->nombre;?></td>
			<td><?=$arrProductos[$i]->precio;?></td>
			<td><?=$arrProductos[$i]->descuento;?></td>
			<td><?=$arrProductos[$i]->stock;?></td>
			<td><?= ($arrProductos[$i]->totalVentas == NULL)? 0 : $arrProductos[$i]->totalVentas ?></td>
			<td>
				<a href="<?=base_url?>producto/editar&id=<?=$arrProductos[$i]->id?>" class="button button-gestion">Editar</a>
				<a href="<?=base_url?>producto/eliminar&id=<?=$arrProductos[$i]->id?>" class="button button-gestion button-red">Eliminar</a>
			</td>
		</tr>
	<?php endfor; ?>
</table>
<div id='paginacion'>
	<div class="container" id="centro">
	<ul class="pagination">
		<li><a href="<?=base_url?>producto/gestion&pag=principio">Principio</a></li>
		<li><a href="<?=base_url?>producto/gestion&pag=anterior">&larr;</a></li>
		<li class="active"><a href="#"><?= $_SESSION['pag'] ?></a></li>
		<li><a href="<?=base_url?>producto/gestion&pag=siguiente">&rarr;</a></li>
		<li><a href="<?=base_url?>producto/gestion&pag=final">Final</a></li>
	</ul>
	</div>
</div>

