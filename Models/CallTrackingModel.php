<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 15.05.2018
 * Time: 15:48
 */

class CallTracking
{
    private $id;
    private $generalCallID;
    private $gaClientId;
    private $firstVisitAt;
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
    private $gaTrackingId;
    private $timeSpentOnSiteBeforeMakeCall;


    public function __construct(
								$generalCallID, 
								$gaClientId,
								$firstVisitAt,
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
								$gaTrackingId,
								$timeSpentOnSiteBeforeMakeCall,
								$id = null 
								)
    {
        $this->id = $id;
        $this->generalCallID = $generalCallID;
        $this->gaClientId = $gaClientId;
        $this->firstVisitAt = $firstVisitAt;
        $this->utm_source = $utm_source;
        $this->utm_medium = $utm_medium;
        $this->utm_campaign = $utm_campaign;
        $this->utm_content = $utm_content;
        $this->utm_term = $utm_term;
        $this->ipAddress = $ipAddress;
        $this->geoipCountry = $geoipCountry;
        $this->geoipRegion = $geoipRegion;
        $this->geoipCity = $geoipCity;
        $this->geoipOrg = $geoipOrg;
        $this->domain = $domain;
        $this->gaTrackingId = $gaTrackingId;
        $this->timeSpentOnSiteBeforeMakeCall = $timeSpentOnSiteBeforeMakeCall;
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
        $query = "INSERT INTO `callTracking` SET 
                      `generalCallID`='{$this->generalCallID}',
                      `gaClientId`  ='{$this->gaClientId}',
                      `firstVisitAt`='{$this->firstVisitAt}',
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
                      `domain`='{$this->domain}',
                      `gaTrackingId`='{$this->gaTrackingId}',
                      `timeSpentOnSiteBeforeMakeCall`='{$this->timeSpentOnSiteBeforeMakeCall}'
                  ";
        $db->query($query);
        echo "<br> $query"."<hr>";
        var_dump($db->error_list);
        die();
        return (bool) $db->insert_id;

    }
    private function update()
    {
        $db=DB::getInstance();
        $query="
        UPDATE `callTracking`
            SET
                      `generalCallID`='{$this->generalCallID}',
                      `gaClientId`  ='{$this->gaClientId}',
                      `firstVisitAt`='{$this->firstVisitAt}',
                      `utm_source`='{$this->utm_source}',
                      `utm_medium`='{$this->utm_medium}'
                      `utm_campaign`='{$this->utm_campaign}',
                      `utm_content`='{$this->utm_content}',
                      `utm_term`='{$this->utm_term}',
                      `ipAddress`='{$this->ipAddress}',
                      `geoipCountry`='{$this->geoipCountry}',
                      `geoipRegion`='{$this->geoipRegion}',
                      `geoipCity`='{$this->geoipCity}',
                      `geoipOrg`='{$this->geoipOrg}',
                      `domain`='{$this->domain}',
                      `gaTrackingId`='{$this->gaTrackingId}',
                      `timeSpentOnSiteBeforeMakeCall`='{$this->timeSpentOnSiteBeforeMakeCall}'
        ";
        $db->query($query);
        return (bool) $db->affected_rows;
    }


    static function createSt($values)
    {
        $db = DB::getInstance();
        $columns = implode(", ",array_keys($values[0]));
        $query = "INSERT INTO `callTracking` ($columns) VALUES ";
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
        $db->query("DELETE FROM 'callTracking' WHERE `id`={$this->id} LIMIT 1");
        return (bool) $db->affected_rows;
    }
    public static function findById($id)
    {
        $id = intval($id);
        $db = DB::getInstance();
        $res = $db->query("SELECT * FROM `callTracking` WHERE `id`=$id LIMIT 1")->fetch_assoc();
        if (!$res){
            throw new NotFoundException("404 comment not found");
        }
        return new self(
            $res['generalCallID'],
            $res['gaClientId'],
            $res['firstVisitAt'],
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
            $res['gaTrackingId'],
            $res['timeSpentOnSiteBeforeMakeCall']
        );
    }
    public static function getCommentsList()
    {
        $db = DB::getInstance();
        return $db->query("SELECT * FROM `callTracking`")->fetch_all(MYSQLI_ASSOC);

    }

    public function setGeneralCallID($generalCallID)
    {
        $this->generalCallID = $generalCallID;
    }
    public function setGaClientId($gaClientId)
    {
        $this->gaClientId = $gaClientId;
    }
    public function setFirstVisitAt($firstVisitAt)
    {
        $this->firstVisitAt = $firstVisitAt;
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

    public function setGaTrackingId($gaTrackingId)
    {
        $this->gaTrackingId = $gaTrackingId;
    }

    public function setTimeSpentOnSiteBeforeMakeCall($timeSpentOnSiteBeforeMakeCall)
    {
        $this->timeSpentOnSiteBeforeMakeCall = $timeSpentOnSiteBeforeMakeCall;
    }

}