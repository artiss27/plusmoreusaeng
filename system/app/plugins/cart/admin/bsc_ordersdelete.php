<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "bsc_ordersinfo.php" ?>
<?php include_once "bsc_admininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$bsc_orders_delete = NULL; // Initialize page object first

class cbsc_orders_delete extends cbsc_orders {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{FCDE03AD-398F-498B-9AE7-440F035B7773}";

	// Table name
	var $TableName = 'bsc_orders';

	// Page object name
	var $PageObjName = 'bsc_orders_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language, $UserAgent;

		// User agent
		$UserAgent = ew_UserAgent();
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (bsc_orders)
		if (!isset($GLOBALS["bsc_orders"])) {
			$GLOBALS["bsc_orders"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["bsc_orders"];
		}

		// Table object (bsc_admin)
		if (!isset($GLOBALS['bsc_admin'])) $GLOBALS['bsc_admin'] = new cbsc_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'bsc_orders', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("bsc_orderslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in bsc_orders class, bsc_ordersinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->idCategory->setDbValue($rs->fields('idCategory'));
		$this->img->setDbValue($rs->fields('img'));
		$this->name->setDbValue($rs->fields('name'));
		$this->description->setDbValue($rs->fields('description'));
		$this->type->setDbValue($rs->fields('type'));
		$this->price->setDbValue($rs->fields('price'));
		$this->price_offer->setDbValue($rs->fields('price_offer'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->idCategory->DbValue = $row['idCategory'];
		$this->img->DbValue = $row['img'];
		$this->name->DbValue = $row['name'];
		$this->description->DbValue = $row['description'];
		$this->type->DbValue = $row['type'];
		$this->price->DbValue = $row['price'];
		$this->price_offer->DbValue = $row['price_offer'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->price->FormValue == $this->price->CurrentValue && is_numeric(ew_StrToFloat($this->price->CurrentValue)))
			$this->price->CurrentValue = ew_StrToFloat($this->price->CurrentValue);

		// Convert decimal values if posted back
		if ($this->price_offer->FormValue == $this->price_offer->CurrentValue && is_numeric(ew_StrToFloat($this->price_offer->CurrentValue)))
			$this->price_offer->CurrentValue = ew_StrToFloat($this->price_offer->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// idCategory
		// img
		// name
		// description
		// type
		// price
		// price_offer

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// idCategory
			$this->idCategory->ViewValue = $this->idCategory->CurrentValue;
			$this->idCategory->ViewCustomAttributes = "";

			// img
			$this->img->ViewValue = $this->img->CurrentValue;
			$this->img->ViewCustomAttributes = "";

			// name
			$this->name->ViewValue = $this->name->CurrentValue;
			$this->name->ViewCustomAttributes = "";

			// type
			if (strval($this->type->CurrentValue) <> "") {
				switch ($this->type->CurrentValue) {
					case $this->type->FldTagValue(1):
						$this->type->ViewValue = $this->type->FldTagCaption(1) <> "" ? $this->type->FldTagCaption(1) : $this->type->CurrentValue;
						break;
					default:
						$this->type->ViewValue = $this->type->CurrentValue;
				}
			} else {
				$this->type->ViewValue = NULL;
			}
			$this->type->ViewCustomAttributes = "";

			// price
			$this->price->ViewValue = $this->price->CurrentValue;
			$this->price->ViewCustomAttributes = "";

			// price_offer
			$this->price_offer->ViewValue = $this->price_offer->CurrentValue;
			$this->price_offer->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// idCategory
			$this->idCategory->LinkCustomAttributes = "";
			$this->idCategory->HrefValue = "";
			$this->idCategory->TooltipValue = "";

			// img
			$this->img->LinkCustomAttributes = "";
			$this->img->HrefValue = "";
			$this->img->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// type
			$this->type->LinkCustomAttributes = "";
			$this->type->HrefValue = "";
			$this->type->TooltipValue = "";

			// price
			$this->price->LinkCustomAttributes = "";
			$this->price->HrefValue = "";
			$this->price->TooltipValue = "";

			// price_offer
			$this->price_offer->LinkCustomAttributes = "";
			$this->price_offer->HrefValue = "";
			$this->price_offer->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "bsc_orderslist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($bsc_orders_delete)) $bsc_orders_delete = new cbsc_orders_delete();

// Page init
$bsc_orders_delete->Page_Init();

// Page main
$bsc_orders_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$bsc_orders_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var bsc_orders_delete = new ew_Page("bsc_orders_delete");
bsc_orders_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = bsc_orders_delete.PageID; // For backward compatibility

// Form object
var fbsc_ordersdelete = new ew_Form("fbsc_ordersdelete");

// Form_CustomValidate event
fbsc_ordersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbsc_ordersdelete.ValidateRequired = true;
<?php } else { ?>
fbsc_ordersdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($bsc_orders_delete->Recordset = $bsc_orders_delete->LoadRecordset())
	$bsc_orders_deleteTotalRecs = $bsc_orders_delete->Recordset->RecordCount(); // Get record count
if ($bsc_orders_deleteTotalRecs <= 0) { // No record found, exit
	if ($bsc_orders_delete->Recordset)
		$bsc_orders_delete->Recordset->Close();
	$bsc_orders_delete->Page_Terminate("bsc_orderslist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $bsc_orders_delete->ShowPageHeader(); ?>
<?php
$bsc_orders_delete->ShowMessage();
?>
<form name="fbsc_ordersdelete" id="fbsc_ordersdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="bsc_orders">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($bsc_orders_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_bsc_ordersdelete" class="ewTable ewTableSeparate">
<?php echo $bsc_orders->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_bsc_orders_id" class="bsc_orders_id"><?php echo $bsc_orders->id->FldCaption() ?></span></td>
		<td><span id="elh_bsc_orders_idCategory" class="bsc_orders_idCategory"><?php echo $bsc_orders->idCategory->FldCaption() ?></span></td>
		<td><span id="elh_bsc_orders_img" class="bsc_orders_img"><?php echo $bsc_orders->img->FldCaption() ?></span></td>
		<td><span id="elh_bsc_orders_name" class="bsc_orders_name"><?php echo $bsc_orders->name->FldCaption() ?></span></td>
		<td><span id="elh_bsc_orders_type" class="bsc_orders_type"><?php echo $bsc_orders->type->FldCaption() ?></span></td>
		<td><span id="elh_bsc_orders_price" class="bsc_orders_price"><?php echo $bsc_orders->price->FldCaption() ?></span></td>
		<td><span id="elh_bsc_orders_price_offer" class="bsc_orders_price_offer"><?php echo $bsc_orders->price_offer->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$bsc_orders_delete->RecCnt = 0;
$i = 0;
while (!$bsc_orders_delete->Recordset->EOF) {
	$bsc_orders_delete->RecCnt++;
	$bsc_orders_delete->RowCnt++;

	// Set row properties
	$bsc_orders->ResetAttrs();
	$bsc_orders->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$bsc_orders_delete->LoadRowValues($bsc_orders_delete->Recordset);

	// Render row
	$bsc_orders_delete->RenderRow();
?>
	<tr<?php echo $bsc_orders->RowAttributes() ?>>
		<td<?php echo $bsc_orders->id->CellAttributes() ?>><span id="el<?php echo $bsc_orders_delete->RowCnt ?>_bsc_orders_id" class="control-group bsc_orders_id">
<span<?php echo $bsc_orders->id->ViewAttributes() ?>>
<?php echo $bsc_orders->id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $bsc_orders->idCategory->CellAttributes() ?>><span id="el<?php echo $bsc_orders_delete->RowCnt ?>_bsc_orders_idCategory" class="control-group bsc_orders_idCategory">
<span<?php echo $bsc_orders->idCategory->ViewAttributes() ?>>
<?php echo $bsc_orders->idCategory->ListViewValue() ?></span>
</span></td>
		<td<?php echo $bsc_orders->img->CellAttributes() ?>><span id="el<?php echo $bsc_orders_delete->RowCnt ?>_bsc_orders_img" class="control-group bsc_orders_img">
<span<?php echo $bsc_orders->img->ViewAttributes() ?>>
<?php echo $bsc_orders->img->ListViewValue() ?></span>
</span></td>
		<td<?php echo $bsc_orders->name->CellAttributes() ?>><span id="el<?php echo $bsc_orders_delete->RowCnt ?>_bsc_orders_name" class="control-group bsc_orders_name">
<span<?php echo $bsc_orders->name->ViewAttributes() ?>>
<?php echo $bsc_orders->name->ListViewValue() ?></span>
</span></td>
		<td<?php echo $bsc_orders->type->CellAttributes() ?>><span id="el<?php echo $bsc_orders_delete->RowCnt ?>_bsc_orders_type" class="control-group bsc_orders_type">
<span<?php echo $bsc_orders->type->ViewAttributes() ?>>
<?php echo $bsc_orders->type->ListViewValue() ?></span>
</span></td>
		<td<?php echo $bsc_orders->price->CellAttributes() ?>><span id="el<?php echo $bsc_orders_delete->RowCnt ?>_bsc_orders_price" class="control-group bsc_orders_price">
<span<?php echo $bsc_orders->price->ViewAttributes() ?>>
<?php echo $bsc_orders->price->ListViewValue() ?></span>
</span></td>
		<td<?php echo $bsc_orders->price_offer->CellAttributes() ?>><span id="el<?php echo $bsc_orders_delete->RowCnt ?>_bsc_orders_price_offer" class="control-group bsc_orders_price_offer">
<span<?php echo $bsc_orders->price_offer->ViewAttributes() ?>>
<?php echo $bsc_orders->price_offer->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$bsc_orders_delete->Recordset->MoveNext();
}
$bsc_orders_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fbsc_ordersdelete.Init();
</script>
<?php
$bsc_orders_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$bsc_orders_delete->Page_Terminate();
?>
