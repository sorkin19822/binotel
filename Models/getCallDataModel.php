<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 15.05.2018
 * Time: 15:48
 */

class getCallData
{
    private $id;
    private $generalCallID;
    private $isNewNumber;
    private $createdAt;
    private $callAt;
    private $processedAt;
    private $isProcessed;
    private $requestsCounter;
    private $attemptsCounter;
    private $employeesDontAnswerCounter;
    private $fullUrl;
    private $description;
    private $gaTrackingId;
    private $gaClientId;
    private $utm_source;
    private $utm_medium;
    private $utm_campaign;
    private $utm_content;
    private $utm_term;
    private $ipAddress;
    private $geoipCountry;
    private $geoipRegion;
    private $geoipCity;
    private $geoipOrg;
    private $domain;



    public function __construct(
								$generalCallID,
                                $isNewNumber,
                                $createdAt,
                                $callAt,
                                $processedAt,
                                $isProcessed,
                                $requestsCounter,
                                $attemptsCounter,
                                $employeesDontAnswerCounter,
                                $fullUrl,
                                $description,
                                $gaTrackingId,
                                $gaClientId,
                                $utm_source,
                                $utm_medium,
                                $utm_campaign,
                                $utm_content,
                                $utm_term,
                                $ipAddress,
                                $geoipCountry,
                                $geoipRegion,
                                $geoipCity,
                                $geoipOrg,
                                $domain,
								$id = null 
								)
    {
        $this->generalCallID=$generalCallID;
        $this->isNewNumber=$isNewNumber;
        $this->createdAt=$createdAt;
        $this->callAt=$callAt;
        $this->processedAt=$processedAt;
        $this->isProcessed=$isProcessed;
        $this->requestsCounter=$requestsCounter;
        $this->attemptsCounter=$attemptsCounter;
        $this->employeesDontAnswerCounter=$employeesDontAnswerCounter;
        $this->fullUrl=$fullUrl;
        $this->description=$description;
        $this->gaTrackingId=$gaTrackingId;
        $this->gaClientId=$gaClientId;
        $this->utm_source=$utm_source;
        $this->utm_medium=$utm_medium;
        $this->utm_campaign=$utm_campaign;
        $this->utm_content=$utm_content;
        $this->utm_term=$utm_term;
        $this->ipAddress=$ipAddress;
        $this->geoipCountry=$geoipCountry;
        $this->geoipRegion=$geoipRegion;
        $this->geoipCity=$geoipCity;
        $this->geoipOrg=$geoipOrg;
        $this->domain=$domain;
        $this->id=$id;
    }
    public function save()
    {
        if(!$this->generalCallID){
            throw new ValidationException("Given data is not valid");
        }
        return is_null($this->id) ? $this->create() : $this->update();
    }
    private function create()
    {
        $db = DB::getInstance();
        $query = "INSERT INTO `getCallCompleted` SET 
                      `generalCallID`='{$this->generalCallID}',
                        `isNewNumber` = '{$this->isNewNumber}',
                        `createdAt` = '{$this->createdAt}',
                        `callAt`='{$this->callAt}',
                        `processedAt`='{$this->processedAt}',
                        `isProcessed`='{$this->isProcessed}',
                        `requestsCounter`='{$this->requestsCounter}',
                        `attemptsCounter`='{$this->attemptsCounter}',
                        `employeesDontAnswerCounter`='{$this->employeesDontAnswerCounter}',
                        `fullUrl` = '{$this->fullUrl}',
                        `description`='{$this->description}',
                        `gaTrackingId`='{$this->gaTrackingId}',
                        `gaClientId`='{$this->gaClientId}',
                        `utm_source`='{$this->utm_source}',
                      `utm_medium`='{$this->utm_medium}',
                      `utm_campaign`='{$this->utm_campaign}',
                      `utm_content`='{$this->utm_content}',
                      `utm_term`='{$this->utm_term}',
                      `ipAddress`='{$this->ipAddress}',
                      `geoipCountry`='{$this->geoipCountry}',
                      `geoipRegion`='{$this->geoipRegion}',
                      `geoipCity`='{$this->geoipCity}',
                      `geoipOrg`='{$this->geoipOrg}',
                      `domain`='{$this->domain}'
                  ";
        $db->query($query);
        return (bool) $db->insert_id;
    }
    private function update()
    {
        $db=DB::getInstance();
        $query="
        UPDATE `getCallCompleted`
            SET
                      `generalCallID`='{$this->generalCallID}',
                        `isNewNumber` = '{$this->isNewNumber}',
                        `createdAt` = '{$this->createdAt}',
                        `callAt`='{$this->callAt}',
                        `processedAt`='{$this->processedAt}',
                        `isProcessed`='{$this->isProcessed}',
                        `requestsCounter`='{$this->requestsCounter}',
                        `attemptsCounter`='{$this->attemptsCounter}',
                        `employeesDontAnswerCounter`='{$this->employeesDontAnswerCounter}',
                        `fullUrl` = '{$this->fullUrl}',
                        `description`='{$this->description}',
                        `gaTrackingId`='{$this->gaTrackingId}',
                        `gaClientId`='{$this->gaClientId}',
                        `utm_source`='{$this->utm_source}',
                      `utm_medium`='{$this->utm_medium}',
                      `utm_campaign`='{$this->utm_campaign}',
                      `utm_content`='{$this->utm_content}',
                      `utm_term`='{$this->utm_term}',
                      `ipAddress`='{$this->ipAddress}',
                      `geoipCountry`='{$this->geoipCountry}',
                      `geoipRegion`='{$this->geoipRegion}',
                      `geoipCity`='{$this->geoipCity}',
                      `geoipOrg`='{$this->geoipOrg}',
                      `domain`='{$this->domain}'
        ";
        $db->query($query);
        return (bool) $db->affected_rows;
    }


    static function createSt($values)
    {
        $db = DB::getInstance();
        $columns = implode(", ",array_keys($values[0]));
        $query = "INSERT INTO `getCallCompleted` ($columns) VALUES ";
        foreach($values as $value) {
            $query.= "(\"".implode("\", \"",$value)."\"),";
        }
        $query=substr($query, 0, -1);
        $db->query($query);
        return (bool) $db->insert_id;
    }


    public function remove()
    {
        $db = DB::getInstance();
        $db->query("DELETE FROM 'getCallCompleted' WHERE `id`={$this->id} LIMIT 1");
        return (bool) $db->affected_rows;
    }
    public static function findById($id)
    {
        $id = intval($id);
        $db = DB::getInstance();
        $res = $db->query("SELECT * FROM `getCallCompleted` WHERE `id`=$id LIMIT 1")->fetch_assoc();
        if (!$res){
            throw new NotFoundException("404 comment not found");
        }
        return new self(
            $res['generalCallID'],
            $res['isNewNumber'],
            $res['createdAt'],
            $res['callAt'],
            $res['processedAt'],
            $res['isProcessed'],
            $res['requestsCounter'],
            $res['attemptsCounter'],
            $res['employeesDontAnswerCounter'],
            $res['fullUrl'],
            $res['description'],
            $res['gaTrackingId'],
            $res['gaClientId'],
            $res['utm_source'],
            $res['utm_medium'],
            $res['utm_campaign'],
            $res['utm_content'],
            $res['utm_term'],
            $res['ipAddress'],
            $res['geoipCountry'],
            $res['geoipRegion'],
            $res['geoipCity'],
            $res['geoipOrg'],
            $res['domain'],
            $res['gaTrackingId']
        );
    }
    public static function getCommentsList()
    {
        $db = DB::getInstance();
        return $db->query("SELECT * FROM `getCallCompleted`")->fetch_all(MYSQLI_ASSOC);

    }

    public function setGeneralCallID($generalCallID)
    {
        $this->generalCallID = $generalCallID;
    }

    public function setIsNewNumber($isNewNumber)
    {
        $this->isNewNumber = $isNewNumber;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    public function setCallAt($callAt)
    {
        $this->callAt = $callAt;
    }
    public function setProcessedAt($processedAt)
    {
        $this->callAt = $processedAt;
    }
    public function setIsProcessed($isProcessed)
    {
        $this->isProcessed = $isProcessed;
    }

    public function setRequestsCounter($isRequestsCounter)
    {
        $this->isRequestsCounter = $isRequestsCounter;
    }

    public function setAttemptsCounter($isAttemptsCounter)
    {
        $this->isAttemptsCounter = $isAttemptsCounter;
    }

    public function setEmployeesDontAnswerCounter($employeesDontAnswerCounter)
    {
        $this->isEmployeesDontAnswerCounter = $employeesDontAnswerCounter;
    }

	    public function setFullUrl($fullUrl)
    {
        $this->fullUrl = $fullUrl;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setGaTrackingId($gaTrackingId)
    {
        $this->gaTrackingId = $gaTrackingId;
    }

    public function setGaClientId($gaClientId)
    {
        $this->gaClientId = $gaClientId;
    }

    public function setUtm_source($utm_source)
    {
        $this->utm_source = $utm_source;
    }

    public function setUtm_medium($utm_medium)
    {
        $this->utm_medium = $utm_medium;
    }

    public function setUtm_campaign($utm_campaign)
    {
        $this->utm_campaign = $utm_campaign;
    }

    public function setUtm_content($utm_content)
    {
        $this->utm_content = $utm_content;
    }

    public function setUtm_term($utm_term)
    {
        $this->utm_term = $utm_term;
    }

    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }
    public function setGeoipCountry($geoipCountry)
    {
        $this->geoipCountry = $geoipCountry;
    }
    public function setGeoipRegion($geoipRegion)
    {
        $this->geoipRegion = $geoipRegion;
    }
    public function setGeoipCity($geoipCity)
    {
        $this->geoipCity = $geoipCity;
    }
    public function setGeoipOrg($geoipOrg)
    {
        $this->geoipOrg = $geoipOrg;
    }
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

}