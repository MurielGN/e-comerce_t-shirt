<h1>Modificar usuario</h1>

<?php if(isset($_SESSION['userMod']) && $_SESSION['userMod'] == 'complete'): ?>
	<strong class="alert_green">El suario se ha modificado correctamente</strong>
<?php elseif(isset($_SESSION['userMod']) && $_SESSION['userMod'] != 'complete'): ?>	
	<strong class="alert_red">El usuario NO se ha modificado correctamente</strong>
<?php endif; ?>
<?php Utils::deleteSession('userMod'); ?>
	
<div class="form_container">
	
	<form action="<?=base_url?>usuario/mod" method="POST" enctype="multipart/form-data">
		<label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?= $usu->nombre ?>"/>

		<label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" value="<?= $usu->apellidos ?>"/>

		<label for="email">Email</label>
        <input type="text" name="email" value="<?= $usu->email ?>"/>

		<label for="direccion">Dirección habitual de envios</label>
		<input type="text" name="direccion" value="<?= $usu->emdireccionail ?>"/>

        <label for="passwordA">Contraseña Antigua:</label>
        <input type="password" name="password"/>
        <label for="password">Contraseña Nueva:</label>
        <input type="password" name="passwordN1"/>
        <label for="password1">Repetir Contraseña:</label>
        <input type="password" name="passwordN2"/>
		
		<label for="imagen">Imagen</label>
		<?php if(isset($usu) && is_object($usu) && !empty($usu->imagen)): ?>
			<img src="<?=base_url?>uploads/images/<?=$usu->imagen?>" class="thumb"/> 
		<?php endif; ?>
		<input type="file" name="imagen" />
		
		<input type="submit" value="Guardar" />
	</form>
</div>