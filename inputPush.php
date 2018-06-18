<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 10.05.2018
 * Time: 15:54
 */
spl_autoload_register(function ($class) {
    include 'Models/' . $class . 'Model.php';
});

class NotFoundException extends Exception{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class ValidationException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}






    $didNumber = htmlspecialchars($_POST['didNumber']);
    $externalNumber = htmlspecialchars($_POST['externalNumber']);
    $internalNumber = htmlspecialchars($_POST['internalNumber']);
    $generalCallID = htmlspecialchars($_POST['generalCallID']);
    $callType = htmlspecialchars($_POST['callType']);
    $companyID = htmlspecialchars($_POST['companyID']);
    $requestType = htmlspecialchars($_POST['requestType']);
    $billsec = htmlspecialchars($_POST['billsec']);
    $disposition = htmlspecialchars($_POST['disposition']);
switch($requestType) {
    case 'receivedTheCall':
        $bin = new Call($didNumber,$externalNumber,$internalNumber,$generalCallID,$callType,$companyID,$requestType);
        $bin->save();
        http_response_code(200);
        die("200 Status insert OK!");
        break;
    case 'hangupTheCall':
        $bin = new Called($generalCallID, $billsec, $disposition, $requestType);
        $bin->save();
        http_response_code(200);
        die("200 Status insert OK!");
        break;
    default :
        echo 'feil';
        break;
}


?>

