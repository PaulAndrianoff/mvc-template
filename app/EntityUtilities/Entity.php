<?php

namespace App\EntityUtilities;

use App\Interfaces\EntityInterface;

use PDO;

class Entity implements EntityInterface {

    /**
     * @var string $tableName
     */
    protected $tableName;

    /**
     * @param string $dbName
     * 
     * @return object
     */
    public function prepareQuery (string $dbName = DB_NAME):object {
        // Try to connect to database
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . $dbName, DB_USER, DB_PASS);

        // Set fetch mode to object
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // permet de ne pas dupliquer les résultats
        
        return $pdo;
    }

    /**
     * @return array
     */
    public function fetchFields ():array {
        $result = [];

        $sql = "SELECT COLUMN_NAME FROM COLUMNS WHERE TABLE_NAME = '{$this->tableName}'";

        $raw = $this->prepareQuery('INFORMATION_SCHEMA')->query($sql);
        foreach ($raw as $rawRow) {
            if ('id' !== $rawRow->COLUMN_NAME) {
                $result[] = $rawRow->COLUMN_NAME;
            }
        }
        
        return $result;
    }

    /**
     * @param array $columns
     * @param array $values
     */
    public function insert (array $columns, array $values):void {
        $sql = "INSERT INTO {$this->tableName}";

        if (count($columns) > count($values)) {
            for ($i=0; $i <= count($columns) - count($values); $i++) { 
                $values[] = "''";
            }
        }

        $sql .= ' (' . implode(', ', $columns) . ')';
        $sql .= ' VALUES (' . implode(', ', $values) . ')';

        $this->prepareQuery()->query($sql);
    }

    /**
     * @param array $columns
     * @param array $values
     */
    public function update (array $columns, array $values):void {
        $sql = "UPDATE {$this->tableName} SET ";

        for ($i=0; $i < count($columns); $i++) { 
            $sql .= $columns[$i] . ' = ' . $values[$i];
        }

        $sql .= ' WHERE id = ' . $this->getId();

        $this->prepareQuery()->query($sql);
    }

    /**
     * @param array $conditions
     * 
     * @return mixed
     */
    public function delete (array $conditions) {
        $sql = "DELETE FROM {$this->tableName}" . $this->conditions($conditions);
        $this->prepareQuery()->query($sql);
    }

    /**
     * @param string $columns
     * @param array $conditions
     * @param int $limit
     * @param int $offset
     * 
     * @return array
     */
    public function select (string $columns,  array $conditions, int $limit = -1, int $offset = -1):array
    {

        $result = [];
        $sql = "SELECT {$columns} FROM {$this->tableName}" . $this->conditions($conditions);

        if (-1 < $limit) {
           $sql .= " LIMIT {$limit}";
        }

        if (-1 < $offset) {
           $sql .= " OFFSET  {$offset}";
        }

        $raw = $this->prepareQuery()->query($sql);
        foreach ($raw as $rawRow) {
            $result[] = $this->morph((array)$rawRow);
        }
    
        return $result;
    }

    public function findById ($id) {
        $request = $this->select('*', ['id' => $id], 1);

        if (count($request) > 0) {
            return $request[0];
        }
        
        return $request;
    }

    public function findAll ():array {
        $request = $this->select('*', []);
        
        return $request;
    }

    /**
     * @param array $conditions
     * 
     * @return string
     */
    private function conditions ($conditions):string {
        $whereClause = '';
        $whereConditions = [];

        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $whereConditions[] = '`' . $key . '` = "' . $value . '"';
            }

            $whereClause = " WHERE " . implode(' AND ', $whereConditions);
        }

        return $whereClause;
    }

    /**
     * @param array $object
     * 
     * @return mixed
     */
    private function morph(array $object):mixed {
        $class = new \ReflectionClass(get_called_class()); // this is static method that's why i use get_called_class
      
        $entity = $class->newInstance();
      
        foreach($class->getProperties(\ReflectionProperty::IS_PRIVATE) as $prop) {
            
            if (isset($object[$prop->getName()])) {
                $prop->setValue($entity, $object[$prop->getName()]);
            }
        }
      
        return $entity;
    }

    /**
     * @return int|null
     */
    public function getId():?int {
        return 0;
    }

}