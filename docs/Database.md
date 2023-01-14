# Database Query Builder

### Oque é um query builder ?

Um query builder é uma ferramenta que permite construir consultas SQL de forma programática, sem a necessidade de
escrever manualmente cada parte da consulta. Ele fornece uma interface fácil de usar que permite adicionar cláusulas,
definir valores e executar consultas, com a finalidade de facilitar a interação com o banco de dados. O objetivo é
permitir que os desenvolvedores escrevam código mais limpo, legível e seguro, sem se preocupar com a sintaxe SQL.

## Uso da classe Database

### Configuração

Antes de começar a usar a classe Database, é necessário configurar a conexão com o banco de dados. Isso pode ser feito
usando o método estático `configure`. Ele espera um array com as configurações de conexão, incluindo
o nome do host, a porta, o nome do banco de dados, o nome de usuário e a senha.

```php
\Core\Database\Database::configure([
    'host' => 'localhost',
    'port' => 3306,
    'database' => 'dbname',
    'user' => 'root',
    'password' => ''
]);
```

Para começar a usar o query builder basta passar a tabela que ira sera usada usando o metodo `table()` que é um metodo
statico que retorna uma instância do querybuilder pronto para executar os demais metodos e criar a sua query

```php
Database::table('products');
```

A partir daí, você ja pode usar os métodos fornecidos para construir a sua query. Segue os metodos disponiveis:

### Consultas Select

```php
Database::table('products')
    ->get();
```

### Where e OrWhere

```php
Database::table('products')
    ->where('id = ?', [1])
    ->orWhere('name = ?', ['bob'])
    ->get();
```

### Limit

```php
Database::table('products')
    ->limit(10)
    ->get();
```

### Offset

```php
Database::table('products')
    ->offset(5)
    ->get();
```

### GroupBy

```php
Database::table('products')
    ->groupBy('name')
    ->get()
```

### OrderBy

```php
Database::table('products')
    ->groupBy('name', OrderBy::DESCENDING)
    ->groupBy('id', OrderBy::ASCENDING)
    ->get()
```

### Insert

```php
Database::table('products')
    ->insert([
        'name' => 'dipirona'
    ])
```

### Update

```php
Database::table('products')
    ->where('id = ?', [1])
    ->update([
        'name' => 'dipirona'
    ])
```
