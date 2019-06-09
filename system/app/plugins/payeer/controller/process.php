<?php
class Process_Controller extends iMVC_Controller
{
    public function anyIpn()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'payeer');
        $processor   = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='payeer'");
        $extra_code  = unserialize($processor['extra_code']);
        $m_key       = $extra_code['merchant_key'];
        $m_shop      = CoreHelp::GetQuery('m_shop');
        $m_orderid   = CoreHelp::GetQuery('m_orderid');
        $m_amount    = CoreHelp::GetQuery('m_amount');
        $m_curr      = CoreHelp::GetQuery('m_curr');
        $m_desc      = CoreHelp::GetQuery('m_desc');
        $checksum    = CoreHelp::GetQuery('m_sign');
        if (isset($_POST['m_operation_id']) && isset($checksum)) {
             $arHash = array($_POST['m_operation_id'],
				$_POST['m_operation_ps'],
				$_POST['m_operation_date'],
				$_POST['m_operation_pay_date'],
				$_POST['m_shop'],
				$_POST['m_orderid'],
				$_POST['m_amount'],
				$_POST['m_curr'],
				$_POST['m_desc'],
				$_POST['m_status'],
				$m_key
			);
            $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));
            if ($sign_hash == $checksum) {
                list($memberId, $amount) = explode('|', \tmvc::instance()->controller->cache->get($m_orderid));
                $status = CoreHelp::GetQuery('m_status');
                if ($status == 'success' && $m_shop == $processor['account_id'] && $m_amount == $amount && strtolower($m_curr) == strtolower($extra_code['currency']) && $memberId) {
                    \tmvc::instance()->controller->cache->set($m_orderid, '', 1);
                    if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
                        $amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
                    }
                    $this->core->db->insert('wallet_deposit', array(
                        'member_id' => $memberId,
                        'amount' => number_format($amount, 2, '.', ''),
                        'processor_id' => $processor['processor_id'],
                        'transaction_id' => CoreHelp::GetQuery('m_operation_id'),
                        'transaction_date' => time(),
                        'descr' => $plugin_lang['from_account'] . ' ' . CoreHelp::GetQuery('m_shop') . ' ' . $plugin_lang['to_account'] . ' ' . CoreHelp::GetQuery('m_shop')
                    ));
                    $f = fopen("storage/logs/payeer_success.log", "ab+");
                    fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
                    fclose($f);
                } else {
                    $f = fopen("storage/logs/payeer_error.log", "ab+");
                    fwrite($f, date("d.m.Y H:i") . "; REASON: fake data; POST: " . serialize($_POST) . ";\n\n");
                    fclose($f);
                }
            } else {
                // IPN not verified or connection errors
                // If status != 200 IPN will be repeated later
                $f = fopen("storage/logs/payeer_error.log", "ab+");
                fwrite($f, date("d.m.Y H:i") . "; REASON: INVALID SIGNATURE; POST: " . serialize($_POST) . ";\n\n");
                fclose($f);
                exit;
            }
        }
    }
    public function anySuccess()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'payeer');
        CoreHelp::setSession('message', $plugin_lang['your_payeer_deposit_will_appear_shortly_in_your_account']);
        CoreHelp::redirect('/members/depositwallet');
    }
    public function anyCancel()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'payeer');
        CoreHelp::setSession('error', $plugin_lang['your_payeer_deposit_was_cancelled']);
        CoreHelp::redirect('/members/depositwallet');
    }
}
