<?php
header('Content-Type: application/json');
session_start();

$aResult = array();

switch ($_POST['functionname']) {
    case 'get_timeout':
        require("../template/database.php");
        $timeout = $get_option("timeout");
        $aResult['timeout'] = $timeout;
        $aResult['exist'] = true;
        break;
    default:
        $aResult['error'] = 'Not found function ' . $_POST['functionname'] . '!';
        break;
}

echo json_encode($aResult);
?>