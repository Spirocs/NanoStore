<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>NanoStore</title>
    <link href="../template/design_template.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <link href="confirmation.css" rel="stylesheet" type="text/css" />
    <script src="confirmation.js"></script>
</head>

<body>
    <div id="content">
        <?php
            include('../template/design_template.php');
        ?>

        <div class="container">
            <div class="info">
                <h1 class="text-center">Einkauf war erfolgreich!</h1>
                <p class="text-center text-break fs-3">Der Kassenbeleg wird automatisch per E-Mail an Sie
                    gesendet.</p>
                <p class="text-center text-break fs-3">Sie werden nun abgemeldet. Beehren Sie uns gerne bald wieder!</p>
            </div>
            <div>
                <img class="bg" src="../pictures/plant.jpg" width="80%" height="200%">
            </div>
        </div>
    </div>

    <?php
            session_start();

            unlink("../../Orders/". $_SESSION['date']. '-'. $_SESSION['customerFullname']. ".xls");
        ?>
</body>

</html>