<?php

/*
	Примеры категории stats.
*/

/*
	ВНИМАНИЕ! В bootstrap.php - прописаны данные для авторизации и инициализация API библиотеки.
	Пожалуйста ознакомьтесь с этим файлом.
*/

require_once('bootstrap.php');

spl_autoload_register(function ($class) {
    include 'Models/' . $class . 'Model.php';
});

/*

	Разъяснения данных в информации о звонке:
		- companyID - идентификатор компании в АТС Binotel
		- generalCallID  - главный идентификатор звонка
		- callID  - идентификатор записи разговора (используется для получения ссылки на запись разговора)
		- startTime  - время начала звонка
		- callType  - тип звонка: входящий - 0, исходящий  - 1
		- internalNumber  - внутренний номер сотрудника / группы в виртуальной АТС (если звонок не был принят)
		- internalAdditionalData  - номер группы в виртуальной АТС (если звонок был принят)
		- externalNumber  - телефонный номер клиента
		- customerData:
			- id  - идентификатор клиента в Мои клинтах
			- name  - имя клиента в Мои клинтах
		- employeeName  - имя сотрудника
		- employeeEmail  - email сотрудника
		- dstNumbers  - спискок номеров которые были в обработке звонка (когда звонок входящий это будет список попыток звонков)
			- dstNumber  - номер кому звонили (когда звонок входящий это будет внутренняя линия сотрудника или группа при груповом звонке, при исхощяем звонке это будет номер на который звонит сотрудник)
		- waitsec  - ожидание до соединения
		- billsec  - длительность разговора
		- disposition  - состояние звонка (ANSWER - успешный звонок, TRANSFER - успешный звонок который был переведен, ONLINE - звонок в онлайне, BUSY - неуспешный звонок по причине занятости, NOANSWER - неуспешный звонок по причине не ответа, CANCEL - неуспешный звонок по причине отмены звонка, CONGESTION - неуспешный звонок, CHANUNAVAIL - неуспешный звонок, VM - голосовая почта без сообщения, VM-SUCCESS - голосовая почта с сообщением, SMS-SENDING - SMS сообщение на отправке, SMS-SUCCESS - SMS сообщение успешно отправлено, SMS-FAILED - SMS сообщение не отправлено, SUCCESS - успешно принятый факс, FAILED - непринятый факс)
		- isNewCall  - был ли входящий звонок новым
		- didNumber  - номер на который пришел вызов во входящем звонке
		- didName  - имя номера на который пришел вызов во входящем звонке
		- trunkNumber  - номер через который совершался исходящий звонок
		- smsContent  - содержимое SMS сообщения

		- callTrackingData - Call Tracking информация (если звонок осуществлялся по Call Tracking номеру)
			- id  - Call Tracking id
			- gaClientId  - Google Analytics Client ID
			- gaTrackingId  - идентификатор отслеживания сайта в Google Analytics
			- utm_source  - метка utm_source
			- utm_medium  - метка utm_medium
			- utm_campaign  - метка utm_campaign
			- utm_content  - метка utm_content
			- utm_term  - метка utm_term
			- ipAddress  - IP адрес клиента
			- geoipCountry - страна по geoip
			- geoipRegion - регион по geoip
			- geoipCity - город по geoip
			- geoipOrg - организация по geoip
			- domain  - сайт
			- timeSpentOnSiteBeforeMakeCall  - пребывания на сайте до совершения звонка в секундах
			- firstVisitAt  - клиент зашел на сайт впервые

		- getCallData - GetCall информация (если звонок осуществлялся используя активный виджет заказа звонка на сайте)
			- id  - GetCall id
			- gaClientId  - Google Analytics Client ID
			- gaTrackingId  - идентификатор отслеживания сайта в Google Analytics
			- utm_source  - метка utm_source
			- utm_medium  - метка utm_medium
			- utm_campaign  - метка utm_campaign
			- utm_content  - метка utm_content
			- utm_term  - метка utm_term
			- ipAddress  - IP адрес клиента
			- geoipCountry - страна по geoip
			- geoipRegion - регион по geoip
			- geoipCity - город по geoip
			- geoipOrg - организация по geoip
			- domain  - сайт
			- isNewNumber  - заказ сделан впервые
			- createdAt  - звонок заказан в
			- callAt  - звонок заказан на
			- processedAt  - звонок обработан в
			- isProcessed  - звонок обработан
			- requestsCounter  - количество попыток заказа звонка клиентом
			- attemptsCounter  - количество попыток соединения сотрудника с клиентом
			- employeesDontAnswerCounter  - сколько раз не взяли трубку сотрудники
			- fullUrl  - заказ сделан со страницы
			- description  - дополнительное описание

*/



/*
	Пример 1: входящие или исходящие звонки за период времени.

	Вариант адреса:
		- incoming-calls-for-period - для входящих звонков
		- outgoing-calls-for-period - для исходящих звонков
		- calltracking-calls-for-period - для CallTracking звонков

	Параметры:
		- startTime  - время начала выбора звонков (в формате unix timestamp)
		- stopTime  - время окончания выбора звонков (в формате unix timestamp)
*/
$day=date("Y-m-d",time()-86400);
$startAt=strtotime($day." 00:00:00");
$endAt=strtotime($day." 23:59:59");

$result = $api->sendRequest('stats/calltracking-calls-for-period', array(
	'startTime' => $startAt, // Sat, 01 Jun 2013 00:00:00 +0300
	'stopTime' => $endAt // Sat, 01 Jun 2013 23:59:59 +0300
));

if ($result['status'] === 'success') {
	foreach ($result['callDetails'] as $one){
		$one['callTrackingData']=['generalCallID'=>$one['generalCallID']]+$one['callTrackingData'];
		/*var_dump($one['callTrackingData']);
		echo '<hr>';*/
		$data[]=$one['callTrackingData'];
	};
	CallTracking::createSt($data);
	
} else {
	printf('REST API ошибка %s: %s %s', $result['code'], $result['message'], PHP_EOL);
}



