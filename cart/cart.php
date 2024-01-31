<html>

<head>
    <link href="../template/design_template.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <link href="scan.css" rel="stylesheet" type="text/css">
    <script src="scan/cart.js"></script>
</head>

<body>
    <div id="content">
        <?php
                    include('../template/design_template.php');
                    session_start();
                ?>

        <div>
            <img class="bg" src="../pictures/fruits.png">
        </div>

        <div class="container">
            <div class="left"></div>
            <div class="header">
                <h1><?php echo $get_option("cart-h1") ?></h1>
            </div>
            <div class="table">
                <div class="test">
                    <table id="table" style="width= 100%;">
                        <colgroup>
                            <col span="1" style="width: 60%;">
                            <col span="1" style="width: 20%;">
                            <col span="1" style="width: 20%;">
                        </colgroup>

                        <thead height="50px">
                            <tr id="test">
                                <th scope="col">Dein Einkauf</th>
                                <th scope="col">EUR</th>
                                <th scope="col" style="border-left-style: hidden;"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        </tbody>
                        <tfoot height="50px">
                            <tr id="foot">
                                <th id="sum">Summe</th>
                                <th id="eur">00.00</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="weight" id="weight">
                <?php
                    $categories = $_SESSION['taxes_array'];

                    foreach ($categories as $c) {
                        echo '<button type="button" id="' . $c['id'] . '" class="btn btn-sm btn-outline-primary">' . $c['name'] . '</button>';
                    }
                ?>
            </div>
            <div class="choose">
                <button type="button" id="pay-button" onclick="pay()" class="btn btn-lg">Bezahlung (via Stripe)</button>
                <button type="button" id="end-button" onclick="end()" class="btn btn-lg btn-outline-danger">Kauf abbrechen und beenden</button>
            </div>
            <div class="right"></div>
        </div>
    </div>

    <div class="modal fade" id="weightModal" tabindex="-1" aria-labelledby="weightModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header weightHeader">
                        <img id="pImage" src="" class="rounded">
                        <h1 class="modal-title fs-5" id="weightModalLabel"></h1>
                        <p class="gramm" id="gramm">0.000 kg</p>
                    </div>
                    <div class="modal-body">
                    <p>Bitte das gewünschte Produt auf die Waage legen.</p>
                    <p>Sobald das Produkt gewogen ist, können Sie es zum Warenkorb hinzufügen</p>
                    <div class="d-flex flex-grow-1 me-2">
                        <h4 id="price">0.80€</h4>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeWeightModal()" class="btn btn-outline-danger">Abbruch</button>
                        <button type="button" onclick="populate()" class="btn btn-primary add-cart">+ Zum Warenkorb hinzufügen</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-center" id="productModalLabel">Bitte wähle das gewünschte Produkt:</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body container-fluid">
                    <?php
                        $products = $_SESSION['product_weight_array'];
                        
                        foreach($products as $key => $p) {
                            echo '<button class="btn product-btn" type="button" onclick="show(this.id)" style="display: none" id="category'. $p['cId']. '">
                                    <img src="'. $p['image']. '" class="figure-img img-fluid rounded">
                                    <br><a>'. $p['name'].'</a>
                                    <br><a>'. $p['price']. '€</a></button>';
                        }
                    ?>
                </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-danger">Abbruch</button>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>