<?php
include_once dirname(__DIR__) . '/autoload.php';


use models\Products;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['method'] == 'delete') {
    # code...

    $products = new Products();


    if (isset($_POST['product'])) {
        $products_ids = $_POST['product'];
        $products->deleteSelected($products_ids);
    } else {
        $errorMessage = "please select one or more products for mass delete";
    }

    //var_dump($products_ids);

    // echo "<script>location.reload(true); </script>";

}

$products = new Products();
$result = $products->selectAll();
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SCANDIWEB-Store Front</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css" type="text/css">
</head>

<body>
    <header>
    <h4> SCANDIWEB TEST TASK</h4>
    </header>

    <form action="#" method="post">
        <input type="hidden" name="method" value="delete" />
        <section class="container mt-5">
            <div class="d-flex justify-content-between p-2">
                <h2 class="mb-0">Product List</h2>
                <div>
                    <a type="button" class="btn  add" href="http://localhost/application/add-product">Add</a>
                    <button type="submit" value="<?= $row['id'] ?>" id="delete-product-_btn" class="btn btn-danger">Mass Delete</button>
                </div>
            </div>
        </section>

        <main>
            <div class="album py-4">
                <div class="container">
                    <h3>
                        <?php
                        if (isset($errorMessage)) {
                            echo $errorMessage;
                        }

                        ?>
                    </h3>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">

                        <?php foreach ($result as $product) : ?>

                            <div class="col">
                                <div class="card shadow-sm" style="height: 18rem;">
                                    <div class="p-3">
                                        <input class="delete-checkbox form-check-input" type="checkbox" name="product[]" value="<?php echo $product->getSKU(); ?>" />
                                    </div>

                                    <div class="mt-4">
                                        <div class="card-body text-center">
                                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $product->getSKU(); ?></h6>
                                            <h5 class="card-title mb-3"><?php echo $product->getName(); ?></h5>
                                            <p class="mb-0"><?php echo number_format($product->getPrice(), 2) . ' $'; ?></p>
                                            <p class="mb-0"><?php echo $product->getAttribute(); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
        </main>
    </form>

    <footer class="mt-auto">
        <div class="container">
            <p class="float-end mb-1">
                <a href="">Back to top</a>
            </p>
            <p>© Copyright, 2022 urhomwosa</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>