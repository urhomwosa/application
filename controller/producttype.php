<?php
/**
 * Defined abstract class and method
 * Defined difference in product type class and method 
 * to format input values (based on different product type)
 */
abstract class ProductType 
{
    abstract public function formatProductType();
}

class ProductTypeDifference extends ProductType
{
    var $weight, $size, $height, $width, $length;
    public function __construct($weight, $size, $height, $width, $length) {
        $this->weight = $weight;
        $this->size = $size;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }
    /**
     * Method to format input values based on product type (Book, Disc, Funiture...)
     */
    public function formatProductType()
    {
        $funiture = empty($this->height) && empty($this->width) &&  empty($this->length) ? "" : $this->height. "x". $this->width. "x". $this->length;
        $data = $this->weight. $this->size. $funiture;
        return $data;
    }
}

?>
   