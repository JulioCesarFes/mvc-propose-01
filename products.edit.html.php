<form action="/editar-produto/<?php echo $product->id ?>" method="post">

	<h1>Editar Novo Produto</h1>

	<label>Nome</label> <br>
	<input type="text" name="name" placeholder="Digite aqui..." value="<?php echo $product->name ?>">

	<br>
	<br>

	<button>Editar</button>
	<a href="/produtos">Cancelar</a>

</form>