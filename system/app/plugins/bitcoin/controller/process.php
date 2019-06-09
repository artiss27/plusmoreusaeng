<?php


class Process_Controller extends iMVC_Controller
{
	
	public function anyIpn()
	{
		
		$f = fopen("storage/logs/coinpayments.log", "ab+");
		fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
		fclose($f);
		
		$plugin_lang = CoreHelp::getLangPlugin('members', 'bitcoin');
		$processor   = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='bitcoin'");
		$extra_code  = unserialize($processor['extra_code']);
		
		$response = '';
		
		$cp_merchant_id = $processor['account_id']; 
		$cp_ipn_secret = $extra_code['ipn_secret']; 
		$order_currency = $extra_code['currency']; 
		
		if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
			$f = fopen("storage/logs/coinpayments.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "IPN Mode is not HMAC\n\n");
			fclose($f);
			die('IPN Mode is not HMAC'); 
		} 
     
		if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
			$f = fopen("storage/logs/coinpayments.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "No HMAC signature sent\n\n");
			fclose($f);
        	die('No HMAC signature sent.'); 
		} 
     
		$request = file_get_contents('php://input'); 
		if ($request === FALSE || empty($request)) { 
			$f = fopen("storage/logs/coinpayments.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "Error reading POST data\n\n");
			fclose($f);
        	die('Error reading POST data'); 
		} 
     
		if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
			$f = fopen("storage/logs/coinpayments.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "No or incorrect Merchant ID passed\n\n");
			fclose($f);
       		die('No or incorrect Merchant ID passed'); 
		} 
         
		$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
		if ($hmac != $_SERVER['HTTP_HMAC']) { 
			$f = fopen("storage/logs/coinpayments.log", "ab+");
			fwrite($f, date("d.m.Y H:i") . "HMAC signature does not match\n\n");
			fclose($f);
        	die('HMAC signature does not match'); 
		} 
     
		// HMAC Signature verified at this point, load some variables. 
	$txn_id = $_POST['txn_id']; 
    $item_name = $_POST['item_name']; 
    $item_number = $_POST['item_number']; 
    $amount1 = floatval($_POST['amount1']); 
    $amount2 = floatval($_POST['amount2']); 
    $currency1 = $_POST['currency1']; 
    $currency2 = $_POST['currency2']; 
    $status = intval($_POST['status']); 
    $status_text = $_POST['status_text']; 
	
	$txnid = $this->core->db->queryFirstField("SELECT id FROM wallet_deposit WHERE transaction_id='" . CoreHelp::sanitizeSQL($txn_id) . "'");
	if($txnid > 0) {
		$f = fopen("storage/logs/coinpayments.log", "ab+");
		fwrite($f, date("d.m.Y H:i") . "Transaction already processed\n\n");
		fclose($f);
		die('IPN OK'); 
	}
    
	list($memberId, $amount) = explode('|', \tmvc::instance()->controller->cache->get(CoreHelp::GetQuery('invoice')));	
	if(!$memberId) {
		//cache got deleted
		$confirm = $this->core->db->queryFirstRow("SELECT * FROM btc_confirmations WHERE transaction_id='" . CoreHelp::sanitizeSQL($txn_id) . "'");
		$memberId = $confirm['member_id'];
		$amount = $confirm['amount'];
	}
	
    //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point 

    // Check the original currency to make sure the buyer didn't change it. 
    if ($currency1 != $order_currency) { 
		$f = fopen("storage/logs/coinpayments.log", "ab+");
		fwrite($f, date("d.m.Y H:i") . "Original currency mismatch\n\n");
		fclose($f);
        die('Original currency mismatch!'); 
    }     
     
    // Check amount against order total 
    if ($amount1 < $amount) { 
		$f = fopen("storage/logs/coinpayments.log", "ab+");
		fwrite($f, date("d.m.Y H:i") . "Amount is diffente than price\n\n");
		fclose($f);
        die('Amount is diffente than price!'); 
    } 
   
    if ($status >= 100 || $status == 2) { 
		if($_POST['received_amount'] == $_POST['amount2'] && $_POST['received_confirms'] >= 2) {
        // payment is complete or queued for nightly payout, success 
		$this->core->db->insert('wallet_deposit', array(
					'member_id' => $memberId,
					'amount' => number_format($amount, 2, '.', ''),
					'processor_id' => $processor['processor_id'],
					'transaction_id' => $_POST['txn_id'],
					'transaction_date' => time(),
					'descr' => $plugin_lang['from_account'] . ' ' . $_POST['email'] . ' ' . $plugin_lang['to_account'] . ' ' . $cp_merchant_id
				));
		}
    } else if ($status < 0) { 
		$f = fopen("storage/logs/bitcoin_error.log", "ab+");
		fwrite($f, date("d.m.Y H:i") . "; REASON: error; POST: " . serialize($_POST) . ";\n\n");
		fclose($f);
    } else { 		
		$txnid = $this->core->db->queryFirstField("SELECT id FROM btc_confirmations WHERE transaction_id='" . CoreHelp::sanitizeSQL($txn_id) . "'");
			if($txnid > 0) { 
				$this->core->db->query("UPDATE btc_confirmations SET confirmation='".CoreHelp::sanitizeSQL($_POST['received_confirms'])."' WHERE txnid='".CoreHelp::sanitizeSQL($_POST['txn_id'])."'");
			} else {
				$this->core->db->insert('btc_confirmations', array('member_id' => $memberId,
											'txnid' => $_POST['txn_id'],
											'confirmation' => $_POST['received_confirms'],
											'amount' => $amount,
											'log' => json_encode($_POST),
											'status' => $_POST['status_text']										
											));
			}
	
		$f = fopen("storage/logs/bitcoin_pending.log", "ab+");
		fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
		fclose($f);
    } 
    die('IPN OK'); 
	

	}
	
	public function anySuccess()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'bitcoin');
		CoreHelp::setSession('message', 'Your bitcoin deposit will appear shortly in your account, it can take up to 30 min to process.');
		CoreHelp::redirect('/members/depositwallet');
	}
	
	public function anyCancel()
	{
		$plugin_lang = CoreHelp::getLangPlugin('members', 'bitcoin');
		CoreHelp::setSession('error', 'Your bitcoin deposit was cancelled');
		CoreHelp::redirect('/members/depositwallet');
	}
	
}
