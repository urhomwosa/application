<?php

namespace models;

use models\Product;

class Furniture extends Product
{
    public function getAttribute()
    {
        return  "Dimension: $this->attribute";
    }
}