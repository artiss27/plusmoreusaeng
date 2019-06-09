<?php
class Process_Controller extends iMVC_Controller
{
    public function anyIpn()
    {
        $plugin_lang    = CoreHelp::getLangPlugin('members', 'advcash');
        $processor      = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='advcash'");
        $extra_code     = unserialize($processor['extra_code']);
        $transactionID  = CoreHelp::GetQuery('ac_transfer');
        $orderid        = CoreHelp::GetQuery('ac_order_id');
        $payerAccount   = CoreHelp::GetQuery('ac_src_wallet');
        $AmountReceived = number_format(CoreHelp::GetQuery('ac_amount'), 2, '.', '');
        if ($AmountReceived <= 0)
            exit;
        $receivedMerchantEmailAddress = CoreHelp::GetQuery('ac_dest_wallet');
        $currency                     = CoreHelp::GetQuery('ac_merchant_currency');
        $getData                      = explode('|', CoreHelp::GetQuery('custom'));
        $sci_name                     = CoreHelp::GetQuery('ac_sci_name');
        $c_sign                       = CoreHelp::GetQuery('ac_hash');
       $sign                         = hash('sha256', CoreHelp::GetQuery('ac_transfer') . ':' . CoreHelp::GetQuery('ac_start_date') . ':' . CoreHelp::GetQuery('ac_sci_name') . ':' . CoreHelp::GetQuery('ac_src_wallet')  . ':' . CoreHelp::GetQuery('ac_dest_wallet') . ':' . CoreHelp::GetQuery('ac_order_id')  . ':' .  number_format(CoreHelp::GetQuery('ac_amount'), 2, '.', '') . ':' . CoreHelp::GetQuery('ac_merchant_currency') . ':' . $extra_code['secondary_password']);
        if ($sign == $c_sign) {
            list($memberId, $amount) = explode('|', \tmvc::instance()->controller->cache->get($orderid));
            $status = CoreHelp::GetQuery('status');
            if ($AmountReceived == $amount && strtolower($currency) == strtolower($extra_code['currency']) && $memberId) {
                \tmvc::instance()->controller->cache->set($orderid, '', 1);
                if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
                    $amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
                }
                $this->core->db->insert('wallet_deposit', array(
                    'member_id' => $memberId,
                    'amount' => number_format($amount, 2, '.', ''),
                    'processor_id' => $processor['processor_id'],
                    'transaction_id' => CoreHelp::GetQuery('ac_transfer'),
                    'transaction_date' => time(),
                    'descr' => $plugin_lang['from_account'] . ' ' . CoreHelp::GetQuery('ac_src_wallet') . ' ' . $plugin_lang['to_account'] . ' ' . CoreHelp::GetQuery('ac_dest_wallet')
                ));
                $f = fopen("storage/logs/advcash_success.log", "ab+");
                fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
                fclose($f);
            } else {
                $f = fopen("storage/logs/advcash_error.log", "ab+");
                fwrite($f, date("d.m.Y H:i") . "; REASON: fake data; POST: " . serialize($_POST) . ";\n\n");
                fclose($f);
            }
        } else {
            // IPN not verified or connection errors
            // If status != 200 IPN will be repeated later
            $f = fopen("storage/logs/advcash_error.log", "ab+");
            fwrite($f, date("d.m.Y H:i") . "; REASON: INVALID SIGNATURE; POST: " . serialize($_POST) . ";\n\n");
            fclose($f);
            exit;
        }
    }
    public function anySuccess()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'advcash');
        CoreHelp::setSession('message', $plugin_lang['your_advcash_deposit_will_appear_shortly_in_your_account']);
        CoreHelp::redirect('/members/depositwallet');
    }
    public function anyCancel()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'advcash');
        CoreHelp::setSession('error', $plugin_lang['your_advcash_deposit_was_cancelled']);
        CoreHelp::redirect('/members/depositwallet');
    }
}
