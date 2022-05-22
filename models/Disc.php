<?php

namespace models;

use models\Product;

class Disc extends Product
{
    public function getAttribute()
    {
        return  "Size: $this->attribute MB";
    }
}