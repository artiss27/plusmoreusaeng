<?php
class Process_Controller extends iMVC_Controller
{
    public function anyIpn()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'okpay');
        $processor   = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='okpay'");
        $extra_code  = unserialize($processor['extra_code']);
        // Read the post from OKPAY and add 'ok_verify'
        $request     = 'ok_verify=true';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $request .= "&$key=$value";
        }
        $fsocket = false;
        $result  = false;
        // Try to connect via SSL due sucurity reason
        if ($fp = @fsockopen('ssl://checkout.okpay.com', 443, $errno, $errstr, 30)) {
            // Connected via HTTPS
            $fsocket = true;
        } elseif ($fp = @fsockopen('checkout.okpay.com', 80, $errno, $errstr, 30)) {
            // Connected via HTTP
            $fsocket = true;
        }
        // If connected to OKPAY
        if ($fsocket == true) {
            $header = 'POST /ipn-verify HTTP/1.1' . "\r\n" . 'Host: checkout.okpay.com' . "\r\n" . 'Content-Type: application/x-www-form-urlencoded' . "\r\n" . 'Content-Length: ' . strlen($request) . "\r\n" . 'Connection: close' . "\r\n\r\n";
            @fputs($fp, $header . $request);
            $string = '';
            while (!@feof($fp)) {
                $res = @fgets($fp, 1024);
                $string .= $res;
                // Find verification result in response
                if ($res == 'VERIFIED' || $res == 'INVALID' || $res == 'TEST') {
                    $result = $res;
                    break;
                }
            }
            @fclose($fp);
        }
        if ($result == 'VERIFIED' && CoreHelp::GetQuery('ok_item_1_article')) {
            list($memberId, $amount) = explode('|', \tmvc::instance()->controller->cache->get(CoreHelp::GetQuery('ok_item_1_article')));
            if (CoreHelp::GetQuery('ok_txn_status') == "completed" && CoreHelp::GetQuery('ok_receiver_email') == $processor['account_id'] && CoreHelp::GetQuery('ok_txn_gross') == $amount && strtolower(CoreHelp::GetQuery('ok_txn_currency')) == strtolower($extra_code['currency']) && $memberId) {
                \tmvc::instance()->controller->cache->set(CoreHelp::GetQuery('ok_item_1_article'), '', 1);
                if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
                    $amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
                }
                $this->core->db->insert('wallet_deposit', array(
                    'member_id' => $memberId,
                    'amount' => number_format($amount, 2, '.', ''),
                    'processor_id' => $processor['processor_id'],
                    'transaction_id' => CoreHelp::GetQuery('ok_txn_id'),
                    'transaction_date' => time(),
                    'descr' => $plugin_lang['from_account'] . ' ' . CoreHelp::GetQuery('ok_payer_email') . ' ' . $plugin_lang['to_account'] . ' ' . CoreHelp::GetQuery('ok_receiver_email')
                ));
                $f = fopen("storage/logs/okpay_success.log", "ab+");
                fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
                fclose($f);
            } else {
                $f = fopen("storage/logs/okpay_error.log", "ab+");
                fwrite($f, date("d.m.Y H:i") . "; REASON: fake data; POST: " . serialize($_POST) . ";\n\n");
                fclose($f);
            }
        } elseif ($result == 'INVALID') {
            $f = fopen("storage/logs/okpay_error.log", "ab+");
            fwrite($f, date("d.m.Y H:i") . "; REASON: INVALID; POST: " . serialize($_POST) . ";\n\n");
            fclose($f);
        } elseif ($result == 'TEST') {
            $f = fopen("storage/logs/okpay_error.log", "ab+");
            fwrite($f, date("d.m.Y H:i") . "; REASON: TEST; POST: " . serialize($_POST) . ";\n\n");
            fclose($f);
        } else {
            // IPN not verified or connection errors
            // If status != 200 IPN will be repeated later
            $f = fopen("storage/logs/okpay_error.log", "ab+");
            fwrite($f, date("d.m.Y H:i") . "; REASON: CONNECTION TO IPN ERROR; POST: " . serialize($_POST) . ";\n\n");
            fclose($f);
            header("HTTP/1.1 404 Not Found");
            exit;
        }
    }
    public function anySuccess()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'okpay');
        CoreHelp::setSession('message', $plugin_lang['your_okpay_deposit_will_appear_shortly_in_your_account']);
        CoreHelp::redirect('/members/depositwallet');
    }
	
    public function anyCancel()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'okpay');
        CoreHelp::setSession('error', $plugin_lang['your_okpay_deposit_was_cancelled']);
        CoreHelp::redirect('/members/depositwallet');
    }
}
