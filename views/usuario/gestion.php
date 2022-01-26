<h1>Crear nuevo usuario</h1>

	
<div class="form_container">
	
	<form action="<?=base_url?>usuario/saveAdmin" method="POST">
		<label for="nombre">Nombre</label>
        <input type="text" name="nombre" value="<?= $usu->nombre ?>"/>

		<label for="descripcion">Apellidos</label>
        <input type="text" name="apellidos" value="<?= $usu->apellidos ?>"/>

		<label for="precio">Email</label>
        <input type="text" name="email" value="<?= $usu->email ?>"/>

		<label for="stock">rol</label>
        <input type="text" name="rol" value="<?= $usu->rol ?>"/>
		
		<label for="imagen">Imagen</label>
		<?php if(!empty($usu->imagen)): ?>
			<img src="<?=base_url?>uploads/images/<?=$usu->imagen?>" class="thumb"/> 
		<?php endif; ?>
		<input type="file" name="imagen" />
		
		<input type="submit" value="Guardar" />
	</form>
</div>