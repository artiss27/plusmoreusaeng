<?php
class Messages_Model extends iMVC_Model
{
    private $members;
    private $dateformat;
    
    public function __construct()
    {
        $this->members    = new Members_Model();
        $this->dateformat = "F j Y h:i:s A";
		parent::__construct();        
    }
    
    public function viewed($message)
    {
        $sql = "UPDATE messages SET to_viewed = '1', to_vdate = NOW() WHERE id = '" . CoreHelp::sanitizeSQL($message) . "' LIMIT 1";
        $this->db->query($sql);
        return true;
    }
    
    public function deleted($message)
    {
        $sql = "UPDATE messages SET to_deleted = '1', to_ddate = NOW() WHERE id = '" . CoreHelp::sanitizeSQL($message) . "' LIMIT 1";
        $this->db->query($sql);
        return true;
    }
    
    public function sendmessage($to, $from, $title, $message, $priority, $type, $msgid)
    {
        if (!is_numeric($to)) {
            $to = $this->members->getUserId($to);
        }
        $sql = "INSERT INTO messages SET `to` = '" . CoreHelp::sanitizeSQL($to) . "', `from` = '" . CoreHelp::sanitizeSQL($from) . "', `title` = '" . CoreHelp::sanitizeSQL($title) . "', `message` = '" . CoreHelp::sanitizeSQL($message) . "', `created` = NOW(), `priority` = '" . CoreHelp::sanitizeSQL($priority) . "', `message_type` = '" . CoreHelp::sanitizeSQL($type) . "', `message_id` = '" . CoreHelp::sanitizeSQL($msgid) . "'";
        $this->db->query($sql);
        return true;
    }
    
    public function getmessage($message, $userId)
    {

        $row    = $this->db->queryFirstRow("SELECT * FROM messages WHERE `id` = '" . CoreHelp::sanitizeSQL($message) . "' AND (`from` = '" . CoreHelp::sanitizeSQL($userId) . "' or `to` = '" . CoreHelp::sanitizeSQL($userId) . "') LIMIT 1");
        if ($row) {
            $messages[0]['id']           = $row['id'];
            $messages[0]['title']        = $row['title'];
            $messages[0]['message']      = $row['message'];
            $messages[0]['fromid']       = $row['from'];
            $messages[0]['toid']         = $row['to'];
            $messages[0]['from']         = $this->members->getUsername($row['from']);
            $messages[0]['to']           = $this->members->getUsername($row['to']);
            $messages[0]['from_viewed']  = $row['from_viewed'];
            $messages[0]['to_viewed']    = $row['to_viewed'];
            $messages[0]['from_deleted'] = $row['from_deleted'];
            $messages[0]['to_deleted']   = $row['to_deleted'];
            $messages[0]['from_vdate']   = date($this->dateformat, strtotime($row['from_vdate']));
            $messages[0]['to_vdate']     = date($this->dateformat, strtotime($row['to_vdate']));
            $messages[0]['from_ddate']   = date($this->dateformat, strtotime($row['from_ddate']));
            $messages[0]['to_ddate']     = date($this->dateformat, strtotime($row['to_ddate']));
            $messages[0]['created']      = date($this->dateformat, strtotime($row['created']));
        } else {
            return false;
        }
        return $messages;
    }
    public function getmessages($type = 0, $userId)
    {
        switch ($type) {
            case "0":
                $sql = "SELECT * FROM messages WHERE `to` = '" . CoreHelp::sanitizeSQL($userId) . "' && `to_viewed` = '0' && `to_deleted` = '0' ORDER BY `created` DESC";
                break; // New messages
            case "1":
                $sql = "SELECT * FROM messages WHERE `to` = '" . CoreHelp::sanitizeSQL($userId) . "' && `to_viewed` = '1' && `to_deleted` = '0' ORDER BY `to_vdate` DESC";
                break; // Read messages
            case "2":
                $sql = "SELECT * FROM messages WHERE `from` = '" . CoreHelp::sanitizeSQL($userId) . "' group by message_id ORDER BY `created` DESC";
                break; // Send messages
            case "3":
                $sql = "SELECT * FROM messages WHERE `to` = '" . CoreHelp::sanitizeSQL($userId) . "' && `to_deleted` = '1' ORDER BY `to_ddate` DESC";
                break; // Deleted messages
            default:
                $sql = "SELECT * FROM messages WHERE `to` = '" . CoreHelp::sanitizeSQL($userId) . "' && `to_viewed` = '0' ORDER BY `created` DESC";
                break; // New messages
        }
        $result = $this->db->query($sql);
        if (count($result) > 0) {
            $i        = 0;
            $messages = array();
            foreach ($result as $row) {
                $messages[$i]['id']           = $row['id'];
                $messages[$i]['title']        = $row['title'];
                $messages[$i]['message']      = $row['message'];
                $messages[$i]['fromid']       = $row['from'];
                $messages[$i]['toid']         = $row['to'];
                $messages[$i]['from']         = $this->members->getUsername($row['from']);
                $messages[$i]['to']           = $this->members->getUsername($row['to']);
                $messages[$i]['from_viewed']  = $row['from_viewed'];
                $messages[$i]['to_viewed']    = $row['to_viewed'];
                $messages[$i]['from_deleted'] = $row['from_deleted'];
                $messages[$i]['to_deleted']   = $row['to_deleted'];
                $messages[$i]['from_vdate']   = date($this->dateformat, strtotime($row['from_vdate']));
                $messages[$i]['to_vdate']     = date($this->dateformat, strtotime($row['to_vdate']));
                $messages[$i]['from_ddate']   = date($this->dateformat, strtotime($row['from_ddate']));
                $messages[$i]['to_ddate']     = date($this->dateformat, strtotime($row['to_ddate']));
                $messages[$i]['created']      = date($this->dateformat, strtotime($row['created']));
                $messages[$i]['priority']     = $row['priority'];
                $messages[$i]['message_type'] = $row['message_type'];
                $i++;
            }
        } else {
            return false;
        }
        return $messages;
    }
    
}
?>