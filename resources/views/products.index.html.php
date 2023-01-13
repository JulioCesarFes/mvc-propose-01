
<a href="/novo-produto">Novo</a>

<table border=1>

	<?php foreach ($products as $key => $product) { ?>
		
		<tr>
			<td><?php echo $product->id ?></td>
			<td><?php echo $product->name ?></td>
			<td><a href="/editar-produto/<?php echo $product->id ?>">editar</a></td>
			<td><a href="/apagar-produto/<?php echo $product->id ?>">apagar</a></td>
		</tr>

	<?php } ?>

</table>
