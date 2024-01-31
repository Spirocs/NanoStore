<html>
    <head>
        <link href="../template/design_template.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <link href="welcome.css" rel="stylesheet" type="text/css">
        <script src="welcome.js"></script>
    </head>

    <body>
        <div id="content">
            <?php
                include('../template/design_template.php');

                session_start();
                session_unset();
                session_destroy();
                session_write_close();
                setcookie(session_name(),'',0,'/');
                session_regenerate_id(true);

                session_start();

                $welcomeh1 = $get_option("welcome-h1");
                $welcomeh2 = $get_option("welcome-h2");
            ?>

            <div class="container">
                <div class="text">
                    <p class="welcome" id="header_1"><?php echo $welcomeh1 ?></p>
                    <p class="help text-break" id="header_2"><?php echo $welcomeh2 ?></p>
                    <img id="card" src="../pictures/card.png">
                </div>
                <div>
                    <img class="bg" src="../pictures/plant.jpg" width="80%" height="200%">
                </div>
            </div>
        </div>
    </body>
</html>