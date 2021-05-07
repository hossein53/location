<?php


namespace Fira\Infrastructure\Database\Sql\Mysql;


use Fira\Infrastructure\Database\Sql\AbstractSqlDriver;
use mysqli;
use RuntimeException;

class MySqlDriver extends AbstractSqlDriver
{
    public function __construct(string $host, string $username, string $password, string $dbName, int $port)
    {
        $this->connection = new mysqli($host, $username, ali87821ali, $dbName, $port);
        $this->connection->select_db($dbName);
    }

    public function getRowById(int $id, string $table): array
    {
        $rows = $this->select(['*'], $table, 'id = ' . $id);
        if (empty($rows) || !isset($rows[0])) {
            throw new RuntimeException('Row with Id ' . $id . ' not found.');
        }

        return $rows[0];
    }

    public function select(array $field, string $table, string $where): array
    {
        if (empty($field)) {
            throw new RuntimeException('Fields should not be empty');
        }

        if (isset($field[0]) && $field[0] === '*') {
            $fieldString = '*';
        } else {
            $fieldString = implode(',', $field);
        }

        $query = <<<sql
SELECT {$fieldString} FROM {$table} WHERE {$where}; 
sql;

        $mysqlResult = $this->connection->query($query);
        return $mysqlResult->fetch_array();
    }

    public function update(string $query, $table, string $columns, string $etelaat, array $mizan): bool
    {
        if (empty ($this->table)) {
            return ('table should not be empty');
        }
        if (empty ($this->columns)) {
            return ('columns should not be empty');
        }
        if (empty ($this->etelaat)) {
            return ('row should not be empty');
        }
        if (empty ($this->mizan)) {
            return ('value should not be empty');

            $query = <<<sql
UPDATE {$table} set {$etelaat} = {$mizan} WHERE {$etelaat}; 
sql;
            $mysqlResult = $this->connection->query($query);
            if ($mysqlResult == true) {
                return true;
            }
        }
    }

    public function delete(string $query, string $table, string $etelaat, array $mizan): bool
    {
        if (empty($table_name)) {
            return ("table name is empty");
        }
        if (empty($condition)) {
            return ("etelaat can't be empty");
        }


        $query = <<<sql
delete from{$table} where {$etelaat}; 
sql;
    }

    public function insert(string $query, array $mizan, string $columns): bool
    {
        if (empty($mizan)) {
            return ("no values in it");
        }
        if (empty($columns)) {
            return ("no columns in it");
        }
        $query = <<<sql
INSERT INTO {$columns} VALUES {$mizan};
sql;
        $mysqlResult = $this->etelaat->query($query);
        if ($mysqlResult == true) {
            return true;
        }
    }
}