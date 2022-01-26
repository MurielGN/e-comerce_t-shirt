<h1>Gestionar categorias</h1>

<a href="<?=base_url?>categoria/crear" class="button button-small">
	Crear categoria
</a>

<?php if(isset($_SESSION['categoria']) && $_SESSION['categoria'] == 'complete'): ?>
	<strong class="alert_green">El categoria se ha creado correctamente</strong>
<?php elseif(isset($_SESSION['categoria']) && $_SESSION['categoria'] != 'complete'): ?>	
	<strong class="alert_red">El categoria NO se ha creado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('categoria'); ?>
	
<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
	<strong class="alert_green">El categoria se ha borrado correctamente</strong>
<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] != 'complete'): ?>	
	<strong class="alert_red">El categoria NO se ha borrado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('delete'); ?>

<table>
	<tr>
		<th>ID</th>
		<th>NOMBRE</th>
		<th>TOTAL VENDIDO</th>
		<th>STOCK</th>
	</tr>
	<?php while($cat = $categorias->fetch_object()): ?>
		<tr>
			<td><?=$cat->id;?></td>
			<td><?=$cat->nombre;?></td>
			<!-- My code -->
			<td><?=$cat->totalSold;?>€</td>
			<td><?=$cat->stock;?>€</td>
			<td>
				<a href="<?=base_url?>categoria/editar&id=<?=$cat->id?>" class="button button-gestion">Editar</a>
				<a href="<?=base_url?>categoria/eliminar&id=<?=$cat->id?>" class="button button-gestion button-red">Eliminar</a>
			</td>
			<!-- End My code -->
		</tr>
	<?php endwhile; ?>
</table>
