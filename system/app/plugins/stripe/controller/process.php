<?php
class Process_Controller extends iMVC_Controller
{
    public function anyIpn()
    {
        session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include(__DIR__."/../api/init.php");
        $plugin_lang = CoreHelp::getLangPlugin('members', 'stripe');
        $processor   = $this->core->db->queryFirstRow("SELECT * FROM payment_processors WHERE code='stripe'");
        $extra_code  = unserialize($processor['extra_code']);

                   
                    // Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey($extra_code['api_secret_key']);

// Token is created using Stripe.js or Checkout!
// Get the payment token ID submitted by the form:
if (isset($_POST['stripeToken'])) {
    # code...

$token = $_POST['stripeToken'];

// Charge the user's card:
$charge = \Stripe\Charge::create(array(
  "amount" => $_SESSION['stripe_amount'],
  "currency" => "usd",
  "description" => "Example charge",
  "source" => $token,
));
//var_dump($charge);
$status=$charge->status;

        //var_dump($_SESSION);
            $amount=$_SESSION['stripe_amount'];
                $memberId = \CoreHelp::getMemberId();
              
   
                     if ($status == 'succeeded' && $memberId) {
                  
                  
                    \tmvc::instance()->controller->cache->set($_SESSION['m_orderid'], '', 1);
                    if ($this->core->GetSiteSetting("processor_fee_by") != 'owner') {
                        $amount=$amount/100;
                        $amount = round(($amount - $processor['fee_flat']) / (1 + $processor['fee_percent'] / 100), 2);
                    }

                    $this->core->db->insert('wallet_deposit', array(
                        'member_id' => $memberId,
                        'amount' => $amount, 
                        'processor_id' => $processor['processor_id'],
                        'transaction_id' => CoreHelp::GetQuery('m_operation_id'),
                        'transaction_date' => time(),
                        'descr' => $plugin_lang['from_account'] . ' ' . $processor['account_id'] . ' ' . $plugin_lang['to_account'] . ' ' . $processor['account_id']
                    ));
                    $f = fopen("storage/logs/stripe_success.log", "ab+");
                    fwrite($f, date("d.m.Y H:i") . "; POST: " . serialize($_POST) . ";\n\n");
                    fclose($f);
                    CoreHelp::redirect(\CoreHelp::getSiteUrl().'plugins/stripe/process/Success');
                } else {
                    $f = fopen("storage/logs/stripe_error.log", "ab+");
                    fwrite($f, date("d.m.Y H:i") . "; REASON: fake data; POST: " . serialize($_POST) . ";\n\n");
                    fclose($f);
                    CoreHelp::redirect(\CoreHelp::getSiteUrl().'plugins/stripe/process/Cancel');
                }
                }else {
                    $f = fopen("storage/logs/stripe_error.log", "ab+");
                    fwrite($f, date("d.m.Y H:i") . "; REASON: fake data; POST: " . serialize($_POST) . ";\n\n");
                    fclose($f);
                    CoreHelp::redirect(\CoreHelp::getSiteUrl().'plugins/stripe/process/Cancel');
                }
            
        
    }
    public function anySuccess()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'stripe');
        CoreHelp::setSession('message', $plugin_lang['your_stripe_deposit_will_appear_shortly_in_your_account']);
        CoreHelp::redirect('/members/depositwallet');
    }
    public function anyCancel()
    {
        $plugin_lang = CoreHelp::getLangPlugin('members', 'stripe');
        CoreHelp::setSession('error', $plugin_lang['your_stripe_deposit_was_cancelled']);
        CoreHelp::redirect('/members/depositwallet');
    }
}
