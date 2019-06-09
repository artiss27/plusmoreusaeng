<?php
class Admin_Model extends iMVC_Model
{
    public function SetSetting($keyname, $default_value = "")
    {
        if ($default_value === "") {
            return;
        }
        $result = $this->db->replace('settings', array(
            'keyname' => $keyname,
            'value' => $default_value
        ));
        return;
    }
    public function GetSiteSettings()
    {
        $result = $this->db->query("SELECT keyname, value FROM settings");
        if (isset($result)) {
            foreach ($result as $row) {
                $kname       = $row['keyname'];
                $ret[$kname] = $row['value'];
            }
            return $ret;
        }
    }
    public function CheckLogin()
    {
        if (!isset($_SESSION['LoggedIn'])) {
            CoreHelp::redirect('/admin/login');
            exit;
        }
        $adminInactivity = $this->GetSiteSetting('admin_inactivity');
        if (isset($_SESSION['last_activity'])) {
            if ($_SESSION['last_activity'] < time() - (60 * $adminInactivity)) {
                session_destroy();
                CoreHelp::redirect('back');
            } else {
                $_SESSION['last_activity'] = time();
            }
        }
    }
    public function enc($value)
    {
        $search  = array(
            "/</",
            "/>/",
            "/'/"
        );
        $replace = array(
            "&lt;",
            "&gt;",
            "&#039;"
        );
        return preg_replace($search, $replace, $value);
    }
    public function SetError($key, $text)
    {
        $this->errors['err_count']++;
        $this->errors[$key] = $text;
    }
    public function Redirect($targetURL)
    {
        header("Location: $targetURL");
        exit();
    }

    public function GetMembers($filter, $paging)
    {
        $results = $this->db->query("SELECT * FROM members");
        return results;
    }
    public function selectSearch($parameter, $value = "")
    {
        $this_return = "<select name='s_field' style='width:180px;' class='form-select form-control b-m'>";
        foreach ($parameter as $name => $field)
            $this_return .= ($value == $field) ? "<option value='$field' selected>$name</option>" : "<option value='$field'>$name</option>";
        $this_return .= "</select>";
        return $this_return;
    }
    public function InsertMembership($name)
    {
        $result = $this->db->insert('memberships', array(
            'membership' => $name
        ));
        return results;
    }
    public function GetMemberships()
    {
        $result = $this->db->query("SELECT id, membership FROM memberships");
        if (isset($result)) {
            foreach ($result as $row) {
                $kname         = $row['id'];
                $ret["$kname"] = $row['membership'];
            }
            return $ret;
        }
    }
    public function DeleteMembership($id)
    {
        $result = $this->db->query("DELETE FROM memberships where id=%d", $id);
    }
    public function SaveMembership($id, $name)
    {
        $result = $this->db->update('memberships', array(
            'membership' => $name
        ), "id=%d", $id);
    }
    public function getMonthSelect($value = "", $name = "dateMonth", $straif = 0)
    {
        if ($value == "" Or $value == 0)
            $value = date("m") + $straif;
        if ($value > 12)
            $value = $value - 12;
        if ($value < 1)
            $value = $value + 12;
        $getval = "<select name='$name' class='form-select form-control m-b'>";
        if ($value == 1)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='1' $check>January</option>";
        if ($value == 2)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='2' $check>February</option>";
        if ($value == 3)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='3' $check>March</option>";
        if ($value == 4)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='4' $check>April</option>";
        if ($value == 5)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='5' $check>May</option>";
        if ($value == 6)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='6' $check>June</option>";
        if ($value == 7)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='7' $check>July</option>";
        if ($value == 8)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='8' $check>August</option>";
        if ($value == 9)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='9' $check>September</option>";
        if ($value == 10)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='10' $check>October</option>";
        if ($value == 11)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='11' $check>November</option>";
        if ($value == 12)
            $check = "selected";
        else
            $check = "";
        $getval .= "<option value='12' $check>December</option>";
        return $getval . "</select>";
    }
    public function getYearSelect($value = "", $name = "dateYear", $table = "", $field = "")
    {
        $getval = "<select name='$name' class='form-select form-control m-b'>";
        if ($value == "" Or $value == 0)
            $value = date("Y");
        $start = date("Y") - 3;
        if ($value < $start)
            $start = $value - 1;
        if ($table != "" And $field != "") {
            $start = $this->db->queryFirstField("Select Min($field) From $table");
            $start = date("Y", $start);
        }
        for ($i = $start; $i <= (date("Y") + 3); $i++) {
            if ($value == $i)
                $check = "selected";
            else
                $check = "";
            $getval .= "<option value='$i' $check> $i </option>";
        }
        return $getval . "</select>";
    }
    public function getDays($month, $year)
    {
        switch ($month) {
            case 1:
                $days = 31;
                break;
            case 2:
                $days = (floor($year / 4) == $year / 4) ? 29 : 28;
                break;
            case 3:
                $days = 31;
                break;
            case 4:
                $days = 30;
                break;
            case 5:
                $days = 31;
                break;
            case 6:
                $days = 30;
                break;
            case 7:
                $days = 31;
                break;
            case 8:
                $days = 31;
                break;
            case 9:
                $days = 30;
                break;
            case 10:
                $days = 31;
                break;
            case 11:
                $days = 30;
                break;
            case 12:
                $days = 31;
                break;
            default:
                $days = 30;
        }
        return $days;
    }
    public function getDaySelect($value = "", $name = "dateDay")
    {
        if ($value == "" Or $value == 0)
            $value = date("d");
        $getval = "<select name='$name' class='form-select form-control m-b'>";
        for ($i = 1; $i < 32; $i++) {
            if ($value == $i)
                $check = "selected";
            else
                $check = "";
            if (strlen($i) == 1)
                $i = "0" . $i;
            $getval .= "<option value='$i' $check> $i </option>";
        }
        return $getval . "</select>";
    }
    public function SaveStateValue($key2, $value)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $key1                   = "a_" . $this->obj;
        $_SESSION[$key1][$key2] = $value;
    }
    public function RemoveStateValue($key2)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $key1 = "a_" . $this->obj;
        unset($_SESSION[$key1][$key2]);
    }
    public function SaveState()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $key                     = "a_" . $this->obj;
        $_SESSION[$key]['pg']    = $this->currentPage;
        $_SESSION[$key]['rows']  = $this->rowsPerPage;
        $_SESSION[$key]['order'] = $this->orderBy;
        $_SESSION[$key]['drctn'] = $this->orderDir;
    }
    public function RestoreState()
    {
        $this->currentPage = (CoreHelp::GetQuery("pg") != "") ? CoreHelp::GetQuery("pg") : 1;
        $this->rowsPerPage = (CoreHelp::GetQuery("rows") != "") ? CoreHelp::GetQuery("rows") : $this->GetStateValue("rows", 20);
        $this->orderBy     = (CoreHelp::GetQuery("order") != "") ? CoreHelp::GetQuery("order") : $this->GetStateValue("order", $this->orderDefault);
        $this->orderDir    = (CoreHelp::GetQuery("drctn") != "") ? CoreHelp::GetQuery("drctn") : $this->GetStateValue("drctn", "asc");
        $this->SaveState();
    }
    public function GetStateValue($key2, $default_valueue = "")
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this_return = $default_valueue;
        $key1        = "a_" . $this->obj;
        if (array_key_exists($key1, $_SESSION)) {
            if (array_key_exists($key2, $_SESSION[$key1])) {
                $this_return = $_SESSION[$key1][$key2];
            }
        }
        return $this_return;
    }
    public function Header_GetSortLink($field, $title = "")
    {
        if ($title == "")
            $title = $field;
        $drctn       = ($this->orderDir == "asc") ? "desc" : "asc";
        $this_return = "<a href='{$this->pageUrl}?order=$field&drctn=$drctn'><b>$title</b></a>";
        if ($field == $this->orderBy) {
            $this_return .= "&nbsp;<img src='/assets/admin/images/sort-{$this->orderDir}.png' width='10' border='0'>";
        }
        return $this_return;
    }
	
	public function createLinks( $links, $list_class ) {
    if ( $this->_limit == 'all' ) {
        return '';
    }
 	$url 		=  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $last       = ceil( $this->_total / $this->_limit );
 
    $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
    $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
 
    $html       = '<ul class="' . $list_class . '">';
 
    $class      = ( $this->_page == 1 ) ? "disabled" : "";
    $html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
 
    if ( $start > 1 ) {
        $html   .= '<li><a href="?limit=' . $this->_limit . '&page=1">1</a></li>';
        $html   .= '<li class="disabled"><span>...</span></li>';
    }
 
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $this->_page == $i ) ? "active" : "";
        $html   .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
    }
 
    if ( $end < $last ) {
        $html   .= '<li class="disabled"><span>...</span></li>';
        $html   .= '<li><a href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
    }
 
    $class      = ( $this->_page == $last ) ? "disabled" : "";
    $html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
 
    $html       .= '</ul>';
 
    return $html;
}
	
    public function Pages_GetLinks($totalRows, $link, $links = 4)
    {
        $divider     = "&nbsp;&nbsp;";
        $left        = "[";
        $right       = "]";
        $this_return = "<table width='100%' cellspacing='0' cellpadding='0'><tr>";
        $this_return .= "<td valign='top' align='left'><b>Rows per page:</b> &nbsp;";
        foreach ($this->rowsOptions as $val) {
            $this_return .= ($val == $this->rowsPerPage) ? "<b class='pages'>{$val}</b>$divider" : "<a href='{$link}rows=$val&pg=1' class='pages'>$val</a>$divider";
        }
        $this_return .= "</td>";
        $this_return .= "<td valign='top' align='right'>";
        $this_return .= '<div class="col-sm-6 pull-right">
			<div class="dataTables_paginate paging_simple_numbers" id="transaction_paginate">
			<ul class="pagination">';
		$last       = ceil( $totalRows / $this->rowsPerPage );	
		$start      = ( ( $this->currentPage - $links ) > 0 ) ? $this->currentPage - $links : 1;
    	$end        = ( ( $this->currentPage + $links ) <= $last ) ? $this->currentPage + $links : $last;	
        $totalPages = ceil($totalRows / $this->rowsPerPage);
        if (($this->currentPage + 1) > $totalPages) {
            $next = "disabled";
        }
        if (($this->currentPage - 1) < 1) {
            $prev = "disabled";
        }
		echo "<!-- last: $last | start: $start | end: $end | total_pages: $totalPages -->\n";
        if ($totalPages > 1) {
            $this_return .= '<li class="paginate_button previous ' . $prev . '" id="transaction_previous"><a href="#">Previous</a></li>';
			if ( $start > 1 ) {
				$this_return   .= '<li class="paginate_button"><a href='.$link.'pg=1">1</a></li>';
       			$this_return   .= '<li class="paginate_button disabled"><span>...</span></li>';
    		}
			
            for ($i = $start; $i <= $end; $i++) {
                $start_ = $i * $this->rowsPerPage + 1;
                $end_   = $start_ + $this->rowsPerPage - 1;
                if ($end_ > $totalRows)
                    $end_ = $totalRows;
                $pageNo = $left . "$start_-$end_" . $right;
                if ($i == $this->currentPage)
                    $this_return .= "<li class='paginate_button active' tabindex='" . ($i) . "'><a href='" . $link . "pg=" . ($i) . "'>$i</a></li>";
                else
                    $this_return .= "<li class='paginate_button' tabindex='" . $i . "'><a href='" . $link . "pg=" . ($i) . "'>$i</a></li>";
            }
			 if ( $end < $last ) {
        		$this_return   .= '<li class="paginate_button disabled"><span>...</span></li>';
        		$this_return   .= '<li class="paginate_button"><a href="'.$link.'pg=' . $last . '">' . $last . '</a></li>';
   			 }
            $this_return .= '<li class="paginate_button next ' . $next . '" id="transaction_next"><a href="' . $link . 'pg=' . ($this->currentPage + 1) . '">Next</a></li>
									</ul>
									</div>
									</div>';
        }
        $this_return .= "</td>";
        return $this_return . "</tr></table>";
    }
    public function dec($value)
    {
        $search  = array(
            "/&lt;/",
            "/&gt;/",
            "/&#039;/"
        );
        $replace = array(
            "<",
            ">",
            "'"
        );
        return preg_replace($search, $replace, $value);
    }
    public function getStatusSelect($value = "")
    {
        $this->statusList = array(
            "3" => "All",
            "0" => "Pending",
            "1" => "Completed",
            "2" => "Declined"
        );
        $this_return      = "<select name='status' class='form-select form-control m-b' style='width:140px;' onChange='this.form.submit()';>";
        foreach ($this->statusList as $k => $v)
            $this_return .= ($value == $k) ? "<option value='$k' selected>$v</option>" : "<option value='$k'>$v</option>";
        $this_return .= "</select>";
        return $this_return;
    }
	
	public function getProcessorStatusSelect($value = "")
    {
		$processors = $this->db->query("SELECT * FROM payment_processors");
        $this_return      = "<select name='processor' class='form-select form-control m-b' style='width:200px;' onChange='this.form.submit()';>";
		$this_return 	 .= "<option value='0'>All</option>"; 
        foreach ($processors as $processor)
            $this_return .= ($value == $processor['processor_id']) ? "<option value='".$processor['processor_id']."' selected>".$processor['name']."</option>" : "<option value='".$processor['processor_id']."'>".$processor['name']."</option>";
        $this_return .= "</select>";
        return $this_return;
    }
	
    public function GetJavaScript()
    {
        return "
	    <script type=\"text/javascript\" language=\"JavaScript\">	
	        <!--	
	        public function insertText (text)	
	        {	
	            var taField = document.form1.message;	
	            //IE support	
	            if (document.selection)	
	            {	
	                taField.focus();	
	                sel = document.selection.createRange ();	
	                sel.text = text;	
	            }
	
	
	        //MOZILLA/NETSCAPE support	
	            else if (taField.selectionStart || taField.selectionStart == '0')	
	            {	
	                var startPos = taField.selectionStart;	
	                var endPos = taField.selectionEnd;	
	                taField.value = taField.value.substring (0, startPos) + text + taField.value.substring (endPos, taField.value.length);	
	            } else	
	            {	
	                taField.value += text;	
	            }	
	        }	
	        -->	
	    </script>	
	";
    }
    public function getPageSelect($value = 0)
    {
        $this_return = "<select name='emailtempl' class='form-control b-m' style='display:inline;' onChange='this.form.submit();'> \r\n";
        $result      = $this->db->query("Select * From emailtemplates Order By emailtempl_id");
        foreach ($result as $row) {
            $selected = ($row['emailtempl_id'] == $value) ? "selected" : "";
            $this_return .= "<option value='" . $row['emailtempl_id'] . "' $selected>" . $row['description'] . "</option>";
        }
        return $this_return . "</select>\r\n";
    }
    public function getPageSelect2($value = 0)
    {
        $this_return = "<b>Select subject: &nbsp;</b> <select name='emailtempl_adm' style='width:242px;' onChange='this.form.submit();'> \r\n";
        $result      = $this->db->query("Select * From emailtemplates Where code='FromAdminToMembers' Order By emailtempl_id ");
        foreach ($result as $row) {
            $selected = ($row['emailtempl_id'] == $value) ? "selected" : "";
            $this_return .= "<option value='" . $row['emailtempl_id'] . "' $selected>" . $row['subject'] . "</option>";
        }
        return $this_return . "</select>\r\n";
    }
    public function cpm($user, $date = "d.m.Y - H:i")
    {
        $this->userid     = $user;
        $this->dateformat = $date;
    }
    public function getmessages($type = 0)
    {
        switch ($type) {
            case "0":
                $sql = "SELECT * FROM messages WHERE `to` = '" . $this->userid . "' && `to_viewed` = '0' && `to_deleted` = '0' ORDER BY `created` DESC";
                break;
            case "1":
                $sql = "SELECT * FROM messages WHERE `to` = '" . $this->userid . "' && `to_viewed` = '1' && `to_deleted` = '0' ORDER BY `to_vdate` DESC";
                break;
            case "2":
                $sql = "SELECT * FROM messages WHERE `from` = '" . $this->userid . "' group by message_id ORDER BY `created` DESC";
                break;
            case "3":
                $sql = "SELECT * FROM messages WHERE `to` = '" . $this->userid . "' && `to_deleted` = '1' ORDER BY `to_ddate` DESC";
                break;
            default:
                $sql = "SELECT * FROM messages WHERE `to` = '" . $this->userid . "' && `to_viewed` = '0' ORDER BY `created` DESC";
                break;
        }
        $result = $this->db->query($sql);
        if (count($result) > 0) {
            $i              = 0;
            $this->messages = array();
            foreach ($result as $row) {
                $this->messages[$i]['id']           = $row['id'];
                $this->messages[$i]['title']        = $row['title'];
                $this->messages[$i]['message']      = $row['message'];
                $this->messages[$i]['fromid']       = $row['from'];
                $this->messages[$i]['toid']         = $row['to'];
                $this->messages[$i]['from']         = $this->getusername($row['from']);
                $this->messages[$i]['to']           = $this->getusername($row['to']);
                $this->messages[$i]['from_viewed']  = $row['from_viewed'];
                $this->messages[$i]['to_viewed']    = $row['to_viewed'];
                $this->messages[$i]['from_deleted'] = $row['from_deleted'];
                $this->messages[$i]['to_deleted']   = $row['to_deleted'];
                $this->messages[$i]['from_vdate']   = date($this->dateformat, strtotime($row['from_vdate']));
                $this->messages[$i]['to_vdate']     = date($this->dateformat, strtotime($row['to_vdate']));
                $this->messages[$i]['from_ddate']   = date($this->dateformat, strtotime($row['from_ddate']));
                $this->messages[$i]['to_ddate']     = date($this->dateformat, strtotime($row['to_ddate']));
                $this->messages[$i]['created']      = date($this->dateformat, strtotime($row['created']));
                $this->messages[$i]['priority']     = $row['priority'];
                $this->messages[$i]['message_type'] = $row['message_type'];
                $i++;
            }
        } else {
            return false;
        }
    }
    public function getusername($userid)
    {
        if ($userid == 0) {
            return "System";
        } else {
            $sql      = "SELECT username FROM members WHERE member_id = '" . $userid . "' LIMIT 1";
            $username = $this->FirstField($sql, "0");
            if ($username) {
                return $username;
            } else {
                return "Unknown";
            }
        }
    }
    public function getmessage($message)
    {
        $sql = "SELECT * FROM messages WHERE `id` = '" . $message . "' and (`from` = '" . $this->userid . "' or `to` = '" . $this->userid . "') LIMIT 1";
        $row = $this->db->queryFirstRow($sql);
        if ($row) {
            $this->messages                    = array();
            $this->messages[0]['id']           = $row['id'];
            $this->messages[0]['title']        = $row['title'];
            $this->messages[0]['message']      = $row['message'];
            $this->messages[0]['fromid']       = $row['from'];
            $this->messages[0]['toid']         = $row['to'];
            $this->messages[0]['from']         = $this->getusername($row['from']);
            $this->messages[0]['to']           = $this->getusername($row['to']);
            $this->messages[0]['from_viewed']  = $row['from_viewed'];
            $this->messages[0]['to_viewed']    = $row['to_viewed'];
            $this->messages[0]['from_deleted'] = $row['from_deleted'];
            $this->messages[0]['to_deleted']   = $row['to_deleted'];
            $this->messages[0]['from_vdate']   = date($this->dateformat, strtotime($row['from_vdate']));
            $this->messages[0]['to_vdate']     = date($this->dateformat, strtotime($row['to_vdate']));
            $this->messages[0]['from_ddate']   = date($this->dateformat, strtotime($row['from_ddate']));
            $this->messages[0]['to_ddate']     = date($this->dateformat, strtotime($row['to_ddate']));
            $this->messages[0]['created']      = date($this->dateformat, strtotime($row['created']));
        } else {
            return false;
        }
    }
    public function getuserid($username)
    {
        $sql  = "SELECT member_id FROM members WHERE username = '" . $username . "' LIMIT 1";
        $meid = $this->FirstField($sql);
        if ($meid) {
            return $meid;
        } else {
            return false;
        }
    }
    public function viewed($message)
    {
        $sql = "UPDATE messages SET to_viewed = '1', to_vdate = NOW() WHERE id = '" . $message . "' LIMIT 1";
        $this->db->query($sql);
        return true;
    }
    public function deleted($message)
    {
        $sql = "UPDATE messages SET to_deleted = '1', to_ddate = NOW() WHERE id = '" . $message . "' LIMIT 1";
        $this->db->query($sql);
        return true;
    }
    public function sendmessage($to, $title, $message, $priority, $type, $msgid)
    {
        if (!is_numeric($to)) {
            $to = $this->getuserid($to);
        }
        $sql = "INSERT INTO messages SET `to` = '" . $to . "', `from` = '" . $this->userid . "', `title` = '" . $title . "', `message` = '" . $message . "', `created` = NOW(), `priority` = '" . $priority . "', `message_type` = '" . $type . "', `message_id` = '" . $msgid . "'";
        $this->db->query($sql);
        return true;
    }
    public function render($message)
    {
        $message = strip_tags($message, '');
        $message = stripslashes($message);
        $message = nl2br($message);
        return $message;
    }

    public function file_extension($filename)
    {
        $path_info = pathinfo($filename);
        return $path_info['extension'];
    }
    public function FirstField($sql, $default_value = "")
    {
        $this_return = $default_value;
        $result      = $this->db->queryFirstField($sql);
        if ($result != false) {
            $this_return = $result;
        }
        if ($this_return == NULL)
            $this_return = $default_value;
        return $this_return;
    }
    public function GetSiteSetting($keyname, $default_value = "")
    {
        $this_return = $default_value;
        $result      = $this->db->queryFirstField('select value from settings where keyname=%s', $keyname);
        if ($result != false) {
            $this_return = $result;
        }
        if ($this_return == NULL)
            $this_return = $default_value;
        return $this_return;
    }
}
?>