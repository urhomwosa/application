<?php

namespace models;

use models\Database;
use models\Book;
use models\Disc;
use models\Furniture;
use Exception;





class Products extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function selectAll()
    {

        $products_array = [];

        $query = "SELECT * FROM products";
        $all_products = $this->getConnection()->query($query);

        while ($products = $all_products->fetch_assoc()) {

            $class = '\\models\\' . ucwords($products['type']);

            $products_array[] = new $class(
                $products['sku'],
                $products['name'],
                $products['price'],
                $products['type'],
                $products['attribute']
            );
        }

        $this->getConnection()->close();

        return $products_array;
    }

    public function selectOne($sku)
    {
        if (!$sku) {
            # code...
            throw new Exception("sku was not found", 2);
        }

        $query = "SELECT * FROM products WHERE sku = ?";
        $single_product = $this->getConnection()->prepare($query);
        $single_product->bind_param("s", $sku);
        $single_product->execute();

        $single_product->bind_result($out_id, $out_label);

        if ($single_product->num_rows > 0) {
            # code...

            $product = $single_product->get_result()->fetch_assoc();

            $class = '\\models\\' . ucwords($product['type']);

            return new $class(
                $product[0]['sku'],
                $product[0]['name'],
                $product[0]['price'],
                $product[0]['type'],
                $product[0]['attribute']
            );
        }

        $this->getConnection()->close();
    }

    public function deleteSelected($ids)
    {

        if (empty($ids)) {
            // throw exception if variable ids is empty
            throw new Exception("no ids supplied for deletion", 3);
        }

        $param = '(';
        $count_ids = count($ids);

        foreach ($ids as $index => $sku) {

            $index = $index + 1;

            $param .= "'$sku'";

            $param .= $index != $count_ids ? ',' : '';
        }

        $param .= ")";

        $query = "DELETE FROM products WHERE sku IN " . $param;

        

        $delete_selected = $this->getConnection()->query($query);

        if ($delete_selected === TRUE) {
           return true;
        } else {
            echo "Error deleting record: " . $this->getConnection()->error;
        }

        $this->getConnection()->close();
    }
}