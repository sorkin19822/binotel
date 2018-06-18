<?php
require_once (__DIR__ .'/Service/bootstrap.php');

spl_autoload_register(function ($class) {
    include 'Models/' . $class . 'Model.php';
});
/*
	Примеры API CALL COMPLETED.

	API CALL COMPLETED: используется для уведомления Вашего скрипта о каждом завершенном звонке. Обычно используется для интеграции АТС Binotel с Вашей CRM.
	
	Этот способ работает через HTTP протокол, данные отправляются методом POST.

	С протоколом HTTP можно ознакомится по ссылке: http://ru.wikipedia.org/wiki/HTTP
	С методом POST можно ознакомится по ссылке: http://ru.wikipedia.org/wiki/HTTP#POST


	Ссылку на Ваш скрипт нужно передать в отдел технической поддержки.
*/


/*
	API CALL COMPLETED имеет 6 попыток для отправления информации:
		1 попытка сразу после завершения звонка
		2 попытка через 10 минут от последней попытки
		3 попытка через 30 минут от последней попытки
		4 попытка через 60 минут от последней попытки
		5 попытка через 4 часа от последней попытки
		6 попытка через 10 часов от последней попытки

	ВНИМАНИЕ! Для подтверждения получения информации нужно вернуть строку: {"status":"success"}
 */


/*
	Разъяснения данных, посылаемых от АТС Binotel:
		requestType - тип запроса, для API CALL COMPLETED: apiCallCompleted
		callDetails - информация о звонке (ассоциативный массив)

	Структура данных идентична структуре данных в API-REST в категории stats: API-REST/samples-api-rest-stats.php
*/

/*Забросил коллтрекинг в таблицу*/
$completed=$_POST;
if (array_key_exists('callTrackingData', $completed['callDetails'])) {
    $completed["callDetails"]["callTrackingData"]=['generalCallID'=>$completed["callDetails"]["generalCallID"]]+$completed["callDetails"]["callTrackingData"];
    /*vardump($completed["callDetails"]["generalCallID"]);*/
    unset($completed["callDetails"]["callTrackingData"]["id"]);
    $data[]=$completed["callDetails"]["callTrackingData"];
    CallTrackingCompleted::createSt($data);
}

if (array_key_exists('getCallData', $completed['callDetails'])) {
    $completed["callDetails"]["getCallData"]=['generalCallID'=>$completed["callDetails"]["generalCallID"]]+$completed["callDetails"]["getCallData"];
    /*vardump($completed["callDetails"]["generalCallID"]);*/
    unset($completed["callDetails"]["getCallData"]["id"]);
    $data[]=$completed["callDetails"]["getCallData"];
    getCallData::createSt($data);
}


/* 
	Пример логирования POST данных, отправляемых Вашему скрипту при завершении звонка в АТС Binotel.
*/


$content = sprintf('%s%s[%s] Received new POST data!%s', PHP_EOL, PHP_EOL, date('r'), PHP_EOL);
$content .= var_export($_POST, TRUE) . PHP_EOL;
file_put_contents(sprintf('%s/api-call-completed.log', __DIR__), $content, FILE_APPEND);
header('Content-Type: application/json');
die(json_encode(["status" => "success"]));
