<?php
header('Content-Type: application/json');
session_start();
require_once '../../vendor/autoload.php';

$aResult = array();

switch ($_POST['functionname']) {
    case 'check_code':
        $code = str_replace('Shift', '', strval($_POST['argument']));
        $obj = $_SESSION['product_array'];
        
        foreach($obj as $key => $p) {
                if (strcmp($p["sku"], strval($code)) == 0) {
                    $aResult['exist'] = true;
                    $aResult['name'] = $p["name"];
                    $aResult['price'] = $p["price"];
                    $aResult['img'] = $p['image'];
                    $aResult['id'] = $key;
                    echo json_encode($aResult);
                    return;
                } else {
                    $aResult["exist"] = $p;
                }
        }
        break;
    case 'check_name':
        $name = $_POST['argument'];
        $obj = $_SESSION['product_weight_array'];
        
        foreach($obj as $key => $p) {
                if (strcmp($p["name"], strval($name)) == 0) {
                    $aResult['exist'] = true;
                    $aResult['name'] = $p["name"];
                    $aResult['id'] = $key;
                    break;
                } else {
                    $aResult["exist"] = false;
                }
        }

        $aResult["gName"] = $name;
        break;
    case 'safe':
        $_SESSION['cart'] = $_POST['argument'];
        $aResult['safed'] = true;
        break;
    case 'safe_order':
        $fp = fopen("../../../Orders/". $_SESSION['date']. '-'. $_SESSION['customerFullname']. ".xls", 'w');
        $list = $_POST['argument'];
        array_unshift($list, array('KundenID', $_SESSION['customerId']));

        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        break;
    case 'delete':
        unlink("../../../Orders/". $_SESSION['date']. '-'. $_SESSION['customerFullname']. ".xls");
        $aResult['deleted'] = true;
        break;
    default:
        $aResult['error'] = 'Not found function ' . $_POST['functionname'] . '!';
        break;
}

echo json_encode($aResult);
?>