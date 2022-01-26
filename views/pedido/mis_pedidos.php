<?php if (isset($gestion)): ?>
	<h1>Gestionar pedidos</h1>
<?php else: ?>
	<h1>Mis pedidos</h1>
<?php endif; ?>
<table>
	<tr>
		<th>Nº Pedido</th>
		<th>Coste</th>
		<th>Fecha</th>
		<th>Estado</th>
		<th></th>
	</tr>
	<?php
	while ($ped = $pedidos->fetch_object()):
		?>

		<tr>
			<td>
				<a href="<?= base_url ?>pedido/detalle&id=<?= $ped->id ?>"><?= $ped->id ?></a>
			</td>
			<td>
				<?= $ped->coste ?> $
			</td>
			<td>
				<?= $ped->fecha ?>
			</td>
			<td>
				<?=Utils::showStatus($ped->estado)?>
			</td>
			<td>
				<?php if($_SESSION['admin']): ?>
					<a href="<?=base_url?>pedido/albaran&id=<?= $ped->id ?>" class="button button-gestion">Albaran</a>
				<?php else: ?>
					<a href="<?=base_url?>pedido/detalle&id=<?= $ped->id ?>" class="button button-gestion">Detalles</a>
				<?php endif; ?>

			</td>
		</tr>

	<?php endwhile; ?>
</table>