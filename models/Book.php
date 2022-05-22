<?php

namespace models;

use models\Product;


class Book extends Product
{
    public function getAttribute()
    {
        return  "Weight: $this->attribute KG";
    }
}