<?php

namespace Core\Contract\Database;

use Core\Database\OrderBy;

interface DatabaseInterface
{
    public static function table(string $name): DatabaseInterface;

    public function where(string $condition, array $values = [], string $conector = 'AND'): DatabaseInterface;

    public function orWhere(string $condition, array $values = []): DatabaseInterface;

    public function groupBy(string $column): DatabaseInterface;

    public function orderBy(string $column, OrderBy $orientation = OrderBy::ASCENDING): DatabaseInterface;

    public function offset(int $value): DatabaseInterface;

    public function limit(int $value): DatabaseInterface;

    public function toSql(array $columns = ['*']): string;

    public function get(array $columns = ['*']): array|null;

    public function first(array $columns = ['*']): array|object|null;

    public function update(array $values): int;

    public function insert(array $values): false|string|null;
}