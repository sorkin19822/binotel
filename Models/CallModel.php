<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 15.05.2018
 * Time: 15:48
 */

class Call{
    private $id;
    private $didNumber;
    private $externalNumber;
    private $internalNumber;
    private $generalCallID;
    private $callType;
    private $companyID;
    private $requestType;
    private $createAt;

    public function __construct($didNumber, $externalNumber,$internalNumber, $generalCallID, $callType,  $companyID, $requestType, $id = null, $createAt = null)
    {
        $this->id = $id;
        $this->didNumber = $didNumber;
        $this->externalNumber = $externalNumber;
        $this->internalNumber = $internalNumber;
        $this->generalCallID = $generalCallID;
        $this->callType = $callType;
        $this->companyID = $companyID;
        $this->requestType = $requestType;
        $this->createAt = is_null($createAt) ? date("Y-m-d H:i:s") : $createAt;
    }

    public function save(){
        if(!$this->generalCallID){
            throw new ValidationException("Given data is not valid");
        }
        return is_null($this->id) ? $this->create() : $this->update();
    }

    public function create(){
        $db = DB::getInstance();
        $query = "
        INSERT INTO `callin` SET
            `didNumber`='{$this->didNumber}',
            `externalNumber`='{$this->externalNumber}',
            `internalNumber`='{$this->internalNumber}',
            `generalCallID`='{$this->generalCallID}',
            `callType`='{$this->callType}',
            `companyID`='{$this->companyID}',
            `requestType`='{$this->requestType}'
    ";
        $db->query($query);
        return (bool) $db->insert_id;
    }

    public function update()
    {
        $db = DB::getInstance();
        $query = "
        UPDATE `callin`
            SET
            `didNumber`='{$this->didNumber}',
            `externalNumber`='{$this->externalNumber}',
            `internalNumber`='{$this->internalNumber}',
            `generalCallID`='{$this->generalCallID}',
             `callType`='{$this->callType}',
             `companyID`='{$this->companyID}',
              `requestType`='{$this->requestType}' WHERE `id`='{$this->id}' LIMIT 
              1";
        $db->query($query);
        return (bool) $db->affected_rows;
    }


    public function remove(){
        $db = DB::getInstance();
        $db->query("DELETE FROM `callin` WHERE 'id'={$this->id} LIMIT 1");
        return (bool) $db->affected_rows;
    }

    public static function findById($id){
        $id = intval($id);
        $db = DB::getInstance();
        $res = $db->query("SELECT * FROM `comments` WHERE `id` = $id LIMIT 1")->fetch_assoc();
        if(!$res){
            throw new NotFoundException("404 comment not found");
        }
        return new self(
            $res['id'],
            $res['didNumber'],
            $res['externalNumber'],
            $res['internalNumber'],
            $res['generalCallID'],
            $res['callType'],
            $res['companyID'],
            $res['requestType'],
            $res['createAt']
        );

    }

    public static function getCallList(){
        $db = DB::getInstance();
        return $db->query("SELECT * FROM 'call'")->fetch_all(MYSQLI_ASSOC);
    }

    public function setDidNumber($didNumber){
        $this->didNumber = $didNumber;
    }

    public function setExternalNumber($externalNumber){
        $this->externalNumber = $externalNumber;
    }

    public function setInternalNumber($internalNumber){
        $this->internalNumber = $internalNumber;
    }

    public function setGeneralCallID($generalCallID){
        $this->generalCallID = $generalCallID;
    }

    public function setCallType($callType){
        $this->callType = $callType;
    }

    public function setCompanyID($companyID){
        $this->companyID = $companyID;
    }

    public function setRequestType($requestType){
        $this->requestType = $requestType;
    }

}