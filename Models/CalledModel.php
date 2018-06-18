<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 15.05.2018
 * Time: 15:48
 */

class Called
{
    private $id;
    private $generalCallID;
    private $billsec;
    private $disposition;
    private $companyID;
    private $requestType;

    public function __construct($generalCallID, $billsec, $disposition, $requestType, $id = null, $createAt = null)
    {
        $this->id = $id;
        $this->generalCallID = $generalCallID;
        $this->billsec = $billsec;
        $this->disposition = $disposition;
        $this->requestType = $requestType;
        $this->createAt = is_null($createAt) ? date("Y-m-d H:i:s") : $createAt;
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
        $query = "INSERT INTO `called` SET 
                      `generalCallID`='{$this->generalCallID}',
                      `billsec`  ='{$this->billsec}',
                      `disposition`='{$this->disposition}',
                      `requestType`='{$this->requestType}'
                  ";
        $db->query($query);
        return (bool) $db->insert_id;

    }
    private function update()
    {
        $db=DB::getInstance();
        $query="
        UPDATE `called`
            SET
              `generalCallID`='{$this->generalCallID}',
              `billsec`  ='{$this->billsec}',
              `disposition`='{$this->disposition}',
              `requestType`='{$this->requestType}',
        ";
        $db->query($query);
        return (bool) $db->affected_rows;
    }
    public function remove()
    {
        $db = DB::getInstance();
        $db->query("DELETE FROM 'called' WHERE `id`={$this->id} LIMIT 1");
        return (bool) $db->affected_rows;
    }
    public static function findById($id)
    {
        $id = intval($id);
        $db = DB::getInstance();
        $res = $db->query("SELECT * FROM `called` WHERE `id`=$id LIMIT 1")->fetch_assoc();
        if (!$res){
            throw new NotFoundException("404 comment not found");
        }
        return new self(
            $res['generalCallID'],
            $res['billsec'],
            $res['disposition'],
            $res['requestType'],
            $res['createAt']
        );
    }
    public static function getCommentsList()
    {
        $db = DB::getInstance();
        return $db->query("SELECT * FROM `called`")->fetch_all(MYSQLI_ASSOC);

    }

    public function setGeneralCallID($generalCallID)
    {
        $this->generalCallID = $generalCallID;
    }
    public function setBillsec($billsec)
    {
        $this->billsec = $billsec;
    }
    public function setDisposition($disposition)
    {
        $this->disposition = $disposition;
    }

    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;
    }

}