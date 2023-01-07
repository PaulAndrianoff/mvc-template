<?php

namespace App\Interfaces;

interface EntityInterface {

    /**
     * @param string $dbName
     * 
     * @return object
     */
    public function prepareQuery (string $dbName = DB_NAME);

    /**
     * @param array $columns
     * @param array $values
     * @return mixed
     */
    public function insert (array $columns, array $values);

    /**
     * @param array $columns
     * @param array $values
     * @return mixed
     */
    public function update (array $columns, array $values);

    /**
     * @param string $columns
     * @param array $conditions
     * @param int $limit
     * @param int $offset
     * @return object
     */
    public function select (string $columns,  array $conditions, int $limit = -1, int $offset = -1);

    /**
     * @param array $conditions
     * @return mixed
     */
    public function delete (array $conditions);

    /**
     * @return array
     */
    public function fetchFields ();

    public function getId();
}