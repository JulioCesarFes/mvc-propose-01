<?php

namespace Core\Database;

class Where
{
    protected string $condition;

    protected string $conector;

    public function __construct(string $condition, string $conector)
    {
        $this->condition = $condition;
        $this->conector = $conector;
    }

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function getConector(): string
    {
        return $this->conector;
    }
}