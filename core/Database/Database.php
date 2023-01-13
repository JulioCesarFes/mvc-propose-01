<?php

namespace Core\Database;


use Core\Contract\Database\DatabaseInterface;

class Database extends Connection implements DatabaseInterface
{
    protected ?string $table;

    /**
     * @var Where[]
     */
    protected array $where = [];

    protected array $values = [];

    protected array $commands = [];

    public static function table(string $name): DatabaseInterface
    {
        $db = new Database();

        $db->table = $name;

        return $db;
    }

    public function where(string $condition, array $values = [], string $conector = 'AND'): DatabaseInterface
    {
        $this->where[] = new Where($condition, $conector);
        $this->values = array_merge($this->values, $values);
        return $this;
    }

    public function orWhere(string $condition, array $values = []): DatabaseInterface
    {
        return $this->where($condition, $values, 'OR');
    }

    public function groupBy(string $column): DatabaseInterface
    {
        $this->commands[__FUNCTION__] = "GROUP BY $column";
        return $this;
    }

    public function orderBy(string $column, OrderBy $orientation = OrderBy::ASCENDING): DatabaseInterface
    {
        $this->commands[__FUNCTION__] = "ORDER BY $column {$orientation->value}";

        return $this;
    }

    public function offset(int $value): DatabaseInterface
    {
        $this->commands[__FUNCTION__] = "OFFSET $value";

        return $this;
    }

    public function limit(int $value): DatabaseInterface
    {
        $this->commands[__FUNCTION__] = "LIMIT $value";

        return $this;
    }

    public function get(array $columns = ['*']): array|null
    {
        $query = $this->buildSelectQuery($columns);

        return $this->executeSelect($query, $this->values);
    }

    public function toSql(array $columns = ['*']): string
    {
        return $this->buildSelectQuery($columns);
    }

    public function first(array $columns = ['*']): array|object|null
    {
        $results = $this->limit(1)->get($columns);

        return count($results) > 0 ? reset($results) : null;
    }

    public function update(array $values): int
    {
        $query = "UPDATE $this->table SET {$this->getSqlValues($values)} {$this->getSqlWheres()}";

        echo "<pre>";
        var_dump(array_merge($this->values, array_values($values)));
        echo "</pre>";

        return $this->execute($query, array_merge(array_values($values), $this->values));
    }

    public function insert(array $values): false|string|null
    {
        $keys = implode(', ', array_keys($values));

        $values_string = implode(', ', array_fill(0, count($values), '?'));

        $query = "INSERT INTO $this->table ($keys) VALUES ($values_string)";

        return $this->executeInsert($query, array_values($values));
    }

    private function getSqlValues(array $values): string
    {
        $query = [];

        foreach ($values as $column => $value)
        {
            $query[] = "$column = ?";
        }

        return implode(', ', $query);
    }

    protected function buildSelectQuery(array $columns = ['*']): string
    {
        $commands = [];

        $commands[] = "SELECT {$this->getSqlColumns($columns)}";
        $commands[] = "FROM $this->table";
        $commands[] = $this->getSqlWheres();
        $commands[] = $this->getSqlCommand('groupBy');
        $commands[] = $this->getSqlCommand('orderBy');
        $commands[] = $this->getSqlCommand('limit');
        $commands[] = $this->getSqlCommand('offset');

        return implode(' ', $commands) . ';';
    }

    private function getSqlCommand(string $name): string|null
    {
        return $this->commands[$name] ?? null;
    }

    private function getSqlColumns(array $columns): string
    {
        return implode(', ', $columns);
    }

    private function getSqlWheres(): string|null
    {
        if (empty($this->where))
        {
            return null;
        }

        $query = [];

        foreach ($this->where as $index => $where)
        {
            $condition = $where->getCondition();
            $conector = $where->getConector();

            if ($index == 0)
            {
                $query[] = $condition;
                continue;
            }

            $query[] = "$conector $condition";
        }

        return "WHERE " . implode(' ', $query);
    }
}