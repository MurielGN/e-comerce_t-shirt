<!-- All is my code -->
<h1>Gestionar usuarios</h1>

<a href="<?=base_url?>usuario/crear" class="button button-small">
	Crear usuario
</a>

<?php if(isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'complete'): ?>
	<strong class="alert_green">El usuario se ha creado correctamente</strong>
<?php elseif(isset($_SESSION['usuario']) && $_SESSION['usuario'] != 'complete'): ?>	
	<strong class="alert_red">El usuario NO se ha creado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('usuario'); ?>
	
<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == 'complete'): ?>
	<strong class="alert_green">El usuario se ha borrado correctamente</strong>
<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] != 'complete'): ?>	
	<strong class="alert_red">El usuario NO se ha borrado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('delete'); ?>

<table>
	<tr>
		<th>ID</th>
		<th>NOMBRE</th>
		<th>APELLIDOS</th>
		<th>EMAIL</th>
        <th>ROL</th>
		<th>COSTE PEDIDOS</th>
		<th>NUM. PEDIDOS PENDT.</th>
	</tr>
	<?php while($us= $usuarios->fetch_object()): ?>
		<tr>
			<td><?=$us->id;?></td>
			<td><?=$us->nombre;?></td>
			<td><?=$us->apellidos;?></td>
			<td><?=$us->email;?></td>
            <td><?=$us->rol;?></td>
            <td><?=$us->Coste_Pedidos;?></td>
            <td><?=$us->Pendientes;?></td>
			<td>
				<a href="<?=base_url?>usuario/editar&id=<?=$us->id?>" class="button button-gestion">Editar</a>
				<a href="<?=base_url?>usuario/eliminar&id=<?=$us->id?>" class="button button-gestion button-red">Eliminar</a>
			</td>
		</tr>
	<?php endwhile; ?>
</table>