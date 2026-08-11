<?php

require_once __DIR__ . '/../config/database.php';

class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    protected function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
