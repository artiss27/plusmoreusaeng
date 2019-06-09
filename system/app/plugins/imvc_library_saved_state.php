<?php

 

class iMVC_Library_Saved_State
{ 
    public $obj; 
    public $currentPage;
	public $rowsPerPage;
	public $rowsOptions;
	public $orderBy;
	public $orderDir;
	public $orderDefault;
    public $statusDefault;
	 
    public function __construct() 
    { 
		
	}
	
	public function saveStateValue($key2, $value)
	{
		$key1                   = "a_" . $this->obj;
		$_SESSION[$key1][$key2] = $value;
	}
	
	public function removeStateValue($key2)
	{
		$key1 = "a_" . $this->obj;
		unset($_SESSION[$key1][$key2]);
	}
	
	public function saveState()
	{
		$key                     = "a_" . $this->obj;
		$_SESSION[$key]['pg']    = $this->currentPage;
		$_SESSION[$key]['rows']  = $this->rowsPerPage;
		$_SESSION[$key]['order'] = $this->orderBy;
		$_SESSION[$key]['drctn'] = $this->orderDir;
	}	
	public function restoreState()
	{
		$this->currentPage = (CoreHelp::GetQuery("pg") != "") ? CoreHelp::GetQuery("pg") : $this->GetStateValue("pg", 0);
		$this->rowsPerPage = (CoreHelp::GetQuery("rpp") != "") ? CoreHelp::GetQuery("rpp") : $this->GetStateValue("rpp", 20);
		$this->orderBy     = (CoreHelp::GetQuery("order") != "") ? CoreHelp::GetQuery("order") : $this->GetStateValue("order", $this->orderDefault);
		$this->orderDir    = (CoreHelp::GetQuery("drctn") != "") ? CoreHelp::GetQuery("drctn") : $this->GetStateValue("drctn", "asc");
		$this->saveState();
	}
	public function getStateValue($key2, $default_value = "")
	{
		
		$this_return = $default_value;
		$key1        = "a_" . $this->obj;
		if (array_key_exists($key1, $_SESSION)) {
			if (array_key_exists($key2, $_SESSION[$key1])) {
				$this_return = $_SESSION[$key1][$key2];
			}
		}
		return $this_return;
	}
     
	public function pagesGetLinks($totalRows, $link)
	{
		$lang = CoreHelp::getLang(tmvc::instance()->url_segments[1]); // admin or members backoffice
		$divider     = "&nbsp;&nbsp;";
		$left        = "[";
		$right       = "]";
		$this_return = "<table width='100%' cellspacing='0' cellpadding='0'><tr>";
		$this_return .= "<td valign='top' align='left'><b>" . $lang['rows_per_page'] . ":</b> &nbsp;";
		foreach ($this->rowsOptions as $val) {
			$this_return .= ($val == $this->rowsPerPage) ? "<b class='pages'>{$val}</b>$divider" : "<a href='{$link}rpp=$val&pg=0' class='pages'>$val</a>$divider";
		}
		$this_return .= "</td>";
		$this_return .= "<td valign='top' align='right'>";
		$totalPages = ceil($totalRows / $this->rowsPerPage);
		if ($totalPages > 1) {
			for ($i = 0; $i < $totalPages; $i++) {
				$start = $i * $this->rowsPerPage + 1;
				$end   = $start + $this->rowsPerPage - 1;
				if ($end > $totalRows)
					$end = $totalRows;
				$pageNo = $left . "$start-$end" . $right;
				if ($i == $this->currentPage)
					$this_return .= "$divider<b class='pages'>$pageNo</b>";
				else
					$this_return .= "$divider<a href='" . $link . "pg=$i' class='pages'>$pageNo</a>";
			}
		}
		$this_return .= "</td>";
		return $this_return . "</tr></table>";
	}     

  
} 

?>