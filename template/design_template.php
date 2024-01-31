    <!--This HTML code is used as a template to use the navbar in the same way on all pages.-->

    <?php
        require('database.php');
    ?>

    <!--In the first line we create the navbar together with Bootstrap.-->
    <nav class="navbar navbar-expand-lg">
        <!--The div is simply used to customize the styling for the content to our needs.-->
        <div class="container-fluid justify-content-start">
            <!--The <a> tag with the class is used for styling purposes in the CSS file. 
            The first items in the tag are our own NanoStore logo and also the logo of the producer. 
            To change the logo of the producer, you simply have to change it in the provided database, 
            by your new logo.-->
            <a class="navbar-brand">
                <img src="../pictures/logo.png" width="170" height="40">
                
                <!--We use php code here to retrieve the logo URL from the producer in the database--> 
                <?php
                    echo '<img id="producer-logo" src="'. $get_option("logo"). '" width="50" height="40">'
                ?>
            </a>

            <!--Here we use PHP to read the name of the producer and display it in the navbar.-->
            <?php 
                    /* Initialize cUrl */
                    $ch = curl_init();

                    /* Set cUrl options */
                    curl_setopt($ch, CURLOPT_URL, 'https://openfoodnetwork.de/admin/enterprises/visible.json?ams_prefix=basic&q%5Bis_primary_producer_eq%5D=true');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            
                    /* Adding a header to the cUrl options */
                    $headers = array();
                    $headers[] = 'Cookie: _ofn_session_id=6f2880ec6cff90bf6d7d300efab522da';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
                    /* cUrl is executed. After that we ask if there was an error and output it accordingly. */
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }

                    /* Here we close cUrl */
                    curl_close($ch);
            
                    /* Decode the result of cUrl to JSON format. */
                    $obj = json_decode($result, TRUE);

                    /* The name of the producer is output based on the result of the JSON. */
                    echo '<p class="producer-name">'. $obj[0]['name']. '</p>';
                ?>
        </div>
    </nav>