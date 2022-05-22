<?php

include_once dirname(__DIR__) . '/autoload.php';

use models\Book;
use models\Disc;
use models\Furniture;

require_once __DIR__ . '/../controller/producttype.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = $_POST;
    //check to see if it contains form data and sanitise inputs
    $productType = isset($formData["type"]) ? $formData["type"] : "";
    $sku = isset($formData["sku"]) ? $formData["sku"] : "";
    $name = isset($formData["name"]) ? $formData["name"] : "";
    $price = isset($formData["price"]) ? $formData["price"] : "";
    $weight = isset($formData["weight"]) ? $formData["weight"] : "";
    $size = isset($formData["size"]) ? $formData["size"] : "";
    $height = isset($formData["height"]) ? $formData["height"] : "";
    $width = isset($formData["width"]) ? $formData["width"] : "";
    $length = isset($formData["length"]) ? $formData["length"] : "";
    //get formatted value of (Book, Disc....) as difference in product type
    $products = new ProductTypeDifference($weight, $size, $height, $width, $length);
    //assign formated value to attribute to save into attribute column in database
    $attribute = $products->formatProductType();
    $class = '\\models\\' . ucwords($productType);
    //debug_to_console($_SERVER['REQUEST_METHOD']);
    $product = new $class();
    $checkUniqueSku = $product->validateSku($sku);
    //check that sku is unique else pass data for saving into database
    if ($checkUniqueSku != 0) {
        $skuUniqueValidate = "SKU already exist. Please provide different SKU.";
    } else {
        $product->setSKU($sku);
        $product->setName($name);
        $product->setType($productType);
        $product->setPrice($price);
        $product->setAttribute($attribute);
        $is_sucessful = $product->save();
        $host  = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        if ($is_sucessful == true) {
            header("Location: http://localhost/application/");
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCANDIWEB - Add Product</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css" type="text/css">
</head>

<body class="bg-light">
    <header>
    <h4> SCANDIWEB TEST TASK</h4>
    </header>

        <form id="product_form" class="products" action="add-product" method="POST">
            <section class="container mt-1">
                <div class="d-flex justify-content-between p-2">
                    <h3 class="my-0">Add Product</h3>
                    <div class="d-flex">
                        <button class="w-100 btn  btn-sm px-4 save" type="button">Save</button>
                        <span class="mx-2"></span>
                        <a type="button" class="btn btn-secondary btn-sm px-4 cancel" href="http://localhost/application/">Cancel</a>
                    </div>
                </div>
            </section>

            <div class="py-1">
                <div class="container">
                    <div class="row g-5 mt-0 px-3">
                        <div class="col-md-7 col-lg-8 mt-1">
                            <hr class="my-1">
                            <div class="row g-3">
                                <div class="col-sm-12 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="">
                                                <label for="sku" class="form-label">SKU</label>
                                                <div class="col-sm-12 mt-2">
                                                    <input type="text" class="form-control" id="sku" name="sku" placeholder="" value="<?php echo isset($_POST["sku"]) ? $_POST["sku"] : ""; ?>">
                                                    <div id="skuErrorMessage" class="text-danger">
                                                        <span>
                                                            <?php
                                                            if (isset($skuUniqueValidate)) {
                                                                echo $skuUniqueValidate;
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="col-sm-12 mt-2">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="">
                                            <label for="name" class="form-label">Name</label>
                                            <div class="col-sm-12 mt-2">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ""; ?>">
                                                <div id="nameErrorMessage" class="text-danger">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-2">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="">
                                            <label for="price" class="form-label">Price</label>
                                            <div class="col-sm-12 mt-2">
                                                <input type="text" class="form-control" id="price" name="price" placeholder="" value="<?php echo isset($_POST["price"]) ? $_POST["price"] : ""; ?>">
                                                <div id="priceErrorMessage" class="text-danger">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="">
                                            <label for="type" class="form-label">Type</label>
                                            <div class="col-sm-12 mt-2">
                                                <select id="productType" class="form-select" name="type" onChange="prodType(this.value);">
                                                    <option selected value="0">Select type</option>
                                                    <option value="Book" <?php echo isset($_POST["type"]) && $_POST["type"] == 'Book' ? 'selected' : ""; ?>>Book</option>
                                                    <option value="Disc" <?php echo isset($_POST["type"]) && $_POST["type"] == 'Disc' ? 'selected' : ""; ?>>Disc</option>
                                                    <option value="Furniture" <?php echo isset($_POST["type"]) && $_POST["type"] == 'Funiture' ? 'selected' : ""; ?>>Furniture</option>
                                                </select>
                                                <div id="productTypeErrorMessage" class="text-danger">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-2">

                            <div class="col-sm-12 mt-2 forfield size">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="inputbox" id="size">
                                            <label for="price" class="form-label">Size (MB)</label>
                                            <div class="col-sm-12 mt-2">
                                                <input type="text" class="form-control" id="prod_size" name="size" value="<?php echo isset($_POST["size"]) ? $_POST["size"] : ""; ?>"> <br>
                                                <div id="sizeErrorMessage" class="text-danger">
                                                </div>
                                                <p>Please, provide size</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-2 forfield dimensions">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="inputbox" id="height">
                                            <label for="price" class="form-label">Height (CM)</label>
                                            <div class="col-sm-12 mt-2">
                                                <input type="text" class="form-control" id="prod_height" name="height" value="<?php echo isset($_POST["height"]) ? $_POST["height"] : ""; ?>">
                                                <div id="heightErrorMessage" class="text-danger"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-100 my-1"></div>

                                    <div class="col-sm-6">
                                        <div class="inputbox" id="width">
                                            <label for="price" class="form-label">Width (CM)</label>
                                            <div class="col-sm-12 mt-2">
                                                <input type="text" class="form-control" id="prod_width" name="height" value="<?php echo isset($_POST["width"]) ? $_POST["width"] : ""; ?>">
                                                <div id="widthErrorMessage" class="text-danger"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-100 my-1"></div>

                                    <div class="col-sm-6">
                                        <div class="inputbox" id="length">
                                            <label for="price" class="form-label">Length (CM)</label>
                                            <div class="col-sm-12 mt-2">
                                                <input type="text" class="form-control" id="prod_length" name="length" value="<?php echo isset($_POST["length"]) ? $_POST["length"] : ""; ?>">
                                                <div id="lengthErrorMessage" class="text-danger">
                                                </div>
                                                <p>Please, provide dimensions in height, width and length</p>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-2 forfield weight">
                                <div class="col-sm-6">
                                    <div class="inputbox" id="weight">
                                        <label for="price" class="form-label">Weight (KG)</label>
                                        <div class="col-sm-12 mt-2">
                                            <input type="text" class="form-control" id="prod_weight" name="weight" value="<?php echo isset($_POST["weight"]) ? $_POST["weight"] : ""; ?>"> <br>
                                            <div id="weightErrorMessage" class="text-danger">
                                            </div>
                                            <p>Please, provide weight</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <footer class="my-auto">
        <div class="container">
            <p class="float-end mb-1">
                <a href="">Back to top</a>
            </p>
            <p>© Copyright, 2022 urhomwosa</p>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/index.js"></script>
</body>

</html>