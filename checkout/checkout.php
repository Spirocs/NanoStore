<html>
    <?php
      session_start();
      $value = str_replace('.', '', $_GET["value"]);
      $_SESSION['value'] = $value;
    ?>

    <head>
      <link href="../template/design_template.css" rel="stylesheet" type="text/css" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
      </script>
      <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
      <script src="https://js.stripe.com/v3/"></script>
      <link rel="stylesheet" href="checkout.css" />
      <script src="checkout.js" defer></script>
    </head>

    <body>
    <div id="content">
        <?php
            include('../template/design_template.php');
        ?>

        <div class="container">
            <div class="header">
                <h1>Payment - Checkout</h1>
            </div>
            <div class="content">
                <div class="textOnInput">
                    <label for="inputText">Name</label>
                    <?php
                      echo '<input class="form-control" id="name" type="text" disabled="true" value="'. $_SESSION['customerFullname'] . '">';
                    ?>
                </div>
                <div class="textOnInput">
                    <label for="inputText">Email</label>
                    <?php
                      echo '<input class="form-control" id="email" type="text" disabled="true" value="'. $_SESSION['customerMail'] . '">';
                    ?>
                </div>
                <div class="textOnInput">
                    <label for="inputText">IBAN</label>
                    <?php
                      echo '<input class="form-control" id="iban" type="text" disabled="true" value="'. $_SESSION['iban'] . '">'
                    ?>
                </div>

                <?php
                  echo '<a>Summe: '. $_GET["value"]. '€</a>';
                ?>
            </div>
            <div class="footer">
                <button type="button" onclick="handleSubmit()" class="pay btn">Bestätigen und kaufen</button>
                <button type="button" onclick="end()" class="cancel btn">Kauf abbrechen und beenden</button>
            </div>
            <div>
                <img class="bg" src="../pictures/plant.jpg" width="80%" height="200%">
            </div>
        </div>
      </div>
    </body>
</html>