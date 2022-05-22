<?php

namespace models;


use models\Database;
use Exception;


abstract class Product extends Database
{
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $attribute;

    public function __construct(
        string $sku   = '',
        string $name  = '',
        string $price = '',
        string $type  = '',
        string $attribute = ''
    ) {

        parent::__construct();

        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
        $this->attribute = $attribute;
    }

    public function getSKU()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getType()
    {
        return $this->type;
    }

    abstract public function getAttribute();


    public function setSKU($sku)
    {
        $this->sku = $sku;
    }

    public function validateSku($data)
    {
        $query = "SELECT sku FROM products WHERE sku='".$data."' ";
        $a_product = $this->getConnection()->query($query);
        $sku = 0;

        while ($products = $a_product->fetch_assoc()) {
            $sku = $products['sku'];
           
        }
        return $sku;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    public function save(): bool
    {

        var_dump('save->sku', $this->sku);

        // if (!$this->sku)
        //     throw new Exception("sku was not set");

        // if (!$this->name)
        //     throw new Exception("name was not set");

        // if (!$this->price)
        //     throw new Exception("price was not set");

        // if (!$this->type)
        //     throw new Exception("type was not set");

        // if (!$this->attribute)
        //     throw new Exception("attribute was not set");


        $query = "INSERT INTO products (sku, name, price, type, attribute)
                VALUES ('$this->sku', '$this->name', '$this->price', '$this->type', '$this->attribute')";

        $insert_product = $this->getConnection()->query($query);

        if ($insert_product === TRUE) {
            return true;
        } else {
            echo "Error deleting record: " . $this->getConnection()->error;
        }
    }
}
?>