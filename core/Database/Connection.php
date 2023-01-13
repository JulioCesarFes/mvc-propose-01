<?php

namespace Core\Database;

use PDO;

class Connection
{
    protected static array $config = [
        'host' => 'localhost',
        'port' => 3306,
        'database' => 'dbname',
        'user' => 'root',
        'password' => ''
    ];

    private \PDO $connection;

    public function __construct()
    {
        $this->connection = $this->newPdo();
    }

    public static function configure(array $config): void
    {
        static::$config = array_merge(static::$config, $config);
    }

    protected function getConfig(string $key): string|int|null
    {
        return self::$config[$key] ?? null;
    }

    protected function newPdo(): PDO
    {
        return new PDO(
            "mysql:host={$this->getConfig('host')};port={$this->getConfig('port')};dbname={$this->getConfig('database')}",
            $this->getConfig('user'),
            $this->getConfig('password')
        );
    }

    private function prepare(string $query): false|\PDOStatement
    {
        return $this->connection->prepare($query);
    }

    final protected function executeSelect($query, array $values): array|null
    {
        $statement = $this->prepare($query);

        if ($statement and $statement->execute(array_values($values)))
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return null;
    }

    final protected function executeInsert($query, array $values): false|string|null
    {
        $statement = $this->prepare($query);
        if ($statement && $statement->execute(array_values($values)))
        {
            return $this->connection->lastInsertId();
        }

        return null;
    }

    final protected function execute($sql, array $values): ?int
    {
        $statement = $this->prepare($sql);

        if ($statement && $statement->execute(array_values($values)))
        {
            return $statement->rowCount();
        }

        return null;
    }
}