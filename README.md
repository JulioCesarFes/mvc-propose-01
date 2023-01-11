# Proposta de MVC 01

Eu tenho dentro de mim a vondade meio subconsciente de criar um MVC bem simples de se usar.

### O que é MVC?

MVC é um forma de estruturar seu Código. Principalmente quando se trata de uma Aplicação dentro de um servidor, porque essa estrutura é capaz de agilizar o desenvolvimento do seu sistema separando as REGRAS DE NEGÓCIO, FORMAS DE VISUALIZAÇÃO e REGRAS DE ROTAS.

## Como estruturei meu MVC

Na index deixei o `autoloader` para puxar os arquivos de qualquer classe que eu chamasse.

```php
spl_autoload_register(function ($className) { require_once "$className.php"; });
```

### 2. Router

Criei uma maneira simples de registrar a rota e o verbo e para qual controller ele mandaria.

```php
$router->register('/', 'get', 'ProductsController', 'index');
```

As rotas também podem ser criadas passando um parâmetro na URL.

```php
$router->register('/produto/:id', 'get', 'ProductsController', 'show');
```

O primeiro argumento é a Rota.
O segundo argumento é o Verbo.
O terceiro argumento é a Classe do Controller.
O quarto argumento é o Método do Controller. Esse é o que será acionado quando chamarem aquela Rota.

### 3. Controller

O Controller ficou super simples também, basta criar um arquivo com o mesmo nome da Classe e usar as funções.

```php
class ProductsController {
	function index () {}
}
```

Quaso for passado um argumento na rota ele pode ser usado pegando diretamente 
dos argumentos da função.

```php
class ProductsController {
	function show ($id) {}
}
```

4. Views

Quando você chamar um Método do Controller, mesmo que não faça interações com o banco de dados, ele pode exibir uma tela ou redirecionar para outra. Achei conveniente colocar essas duas funcionalidades dentro de uma Classe chamada Views.

Para redirecionar, basta:

```php
Views::redirect('/other/route');
```

Para exibir uma tela, basta:

```php
Views::render('filename', get_defined_vars());
```

O `get_defined_vars` pega todas as variáveis declaradas dentro da função e transfere para dentro do arquivo php

5. Model

O Model é uma classe que contém informações sobre como salvar os arquivos dentro do Banco de Dados, e também outras funcionalidades e regras de negócio.

Diferente dos Controllers as Classes de Model precisam extender a Classe Model.

```php
class UserModel extends Model {}
```

É preciso também registrar sua tabela no banco de dados, seus atributos e quais atributos podem ser alterados pelo usuários do sistema. É necessário para funcionar.

```php
class UserModel extends Model {
  static public $table = 'users';

  public $id;
  public $name;

  protected static $permited_params = ['name'];
}
```

Podem ser criadas outras funcões a partir dai, que serão usadas pelos controllers em tempo de execução. Por exemplo a função `firstname` no caso da classe UserModel.

```php
function firstname() {
  return explode(" ", $this->name)[0];
}
```

Para utilizar o model em tempo de execução existem as seguintes funções:

```php
# Array com Instâncias
$users = UserModel::all();
$users = UserModel::where('name = ?', 'Joe');

# Apenas Instância
$user = UserModel::new(['name' => 'Joe']);
$user = UserModel::find(1);
$user->update(['name' => 'John Doe']);
UserModel::destroy(1);
```

# Coias para futuras versões

- templates e partials
- verificar se apenas controller são chamados no registro de rotas
- separar models, controllers e views em pastas (verificar se spl_autoloader tem mais argumentos que só o ClassName)
