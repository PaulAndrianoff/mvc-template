<?php

namespace App\Models;

use App\EntityUtilities\Entity;
use App\Helper\Debug;

class Product extends Entity {

    protected $tableName = 'product';

    private $id;

    private $title;

    private $description;

    private $price;

    private $sku;

    private $image;

    // CRUD OPERATIONS
    public function create(array $data)
    {
        $columns = $this->fetchFields();
        $values = $data;

        $this->insert($columns, $values);
    }

    public function read(int $id)
    {
        $product = $this->findById($id);
        
        if ('object' === gettype($product)) {
            $this->setId($product->getId());
            $this->setTitle($product->getTitle());
            $this->setDescription($product->getDescription());
            $this->setPrice($product->getPrice());
            $this->setSku($product->getSku());
            $this->setImage($product->getImage());
        }
    }

    /**
     * @return int|null
     */
    public function getId():?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle():?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDescription():?string
    {
        return $this->description;
    }

    /**
     * @return float|null
     */
    public function getPrice():?float
    {
        return $this->price;
    }

    /**
     * @return int|null
     */
    public function getSku():?int
    {
        return $this->sku;
    }

    /**
     * @return string|null
     */
    public function getImage():?string
    {
        return $this->image;
    }

    /**
     * @param int|null
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @param string|null
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }

    /**
     * @param string|null
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    /**
     * @param float|null
     */
    public function setPrice(?float $price)
    {
        $this->price = $price;
    }

    /**
     * @param string|null
     */
    public function setSku(?string $sku)
    {
        $this->sku = $sku;
    }

    /**
     * @param string|null
     */
    public function setImage(?string $image)
    {
        $this->image = $image;
    }
}