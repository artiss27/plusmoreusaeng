<?php

/*
 * 
 $cart=new cartshop();
 $cart->init('my_shop');              //initialize the shoppingcart
 $cart->add_cart("100:::",3);        //adding values
 $cart->add_cart("1:::black",5);     //adding values
 $cart->add_cart("3:::white",1);     //adding values
 $cart->update_cart("3:::white",5);  //update cart
 $cart->remove_cart("3:::white");    //remove cart
 $cart->removeall_cart();            //remove all cat
 if(!$cart->get_cart()){             //checking if the cart is empty or not
 echo "no cart found";
 }else{
 print_r($cart->get_cart());      this returns the values stored in a array , you can iterate and get the values after that
 }
 
 echo "<BR>";
 echo $cart->count_cart()." items found";   
 echo "<BR>";
 echo $cart->countall_cart()." total items found"; 
 * 
 */


class shoppingcart
{
    private $cart = array();
    public $sessionname;

    function shoppingcart()
    {
        if (session_id() == "") {
            session_start();
        }
    }

    function init($sessionname)
    {
        $this->sessionname = $sessionname;
        //initializing cart and getting value from session if it exists
        $this->cart = (isset($_SESSION[$this->sessionname])) ? $_SESSION[$this->sessionname] : array();
        $this->writesession($this->cart);
    }

    function add_cart($id, $quantity)
    {

        if (!isset($this->cart[$id])) {
            $this->cart["$id"] = $quantity;
        } else {
            $this->cart["$id"] = $this->cart["$id"] + $quantity;
        }
        $this->writesession($this->cart);
        return true;
    }

    function writesession($cart)
    {
        $_SESSION[$this->sessionname] = $cart;
        return true;
    }

    function get_cart()
    {
        if (count($_SESSION[$this->sessionname]) == 0) {
            return false;
        } else {
            return $_SESSION[$this->sessionname];
        }


    }

    function update_cart($id, $quantity)
    {
        $this->cart["$id"] = $quantity;
        $this->writesession($this->cart);
    }

    function remove_cart($id)
    {
        unset($this->cart["$id"]);
        //no items left in the cart, initialize cart again
        if (count($this->cart) == 0) {
            $this->cart = array();
        }
        $this->writesession($this->cart);
    }

    function removeall_cart()
    {
        unset($this->cart);
        $this->cart = array();
        $this->writesession($this->cart);
    }

    function count_cart()
    {
        return count($this->cart);
    }

    function countall_cart()
    {
        $count = 0;
        foreach ($this->cart as $a => $b) {
            $count += $b;
        }
        return $count;
    }
}

//--------------------------------------------------------
// currency 
//--------------------------------------------------------
function moneyformat($number)
{
    return EW_CURRENCY_SYMBOL . number_format($number, 2, '.', '');
}

//--------------------------------------------------------
// debug
//--------------------------------------------------------
function dd($s)
{
    echo "<pre>";
    print_r($s);
    echo "</pre>";
}

//--------------------------------------------------------
// exract id & type of 1 product
//--------------------------------------------------------
function extractproduct($s)
{
    $productcart = explode(":::", $s);
    return $productcart;
}

//--------------------------------------------------------
// getprice
//--------------------------------------------------------
//
// Gets the price, considering the product variations and discount
//
class getprice
{

    private $price = array();
    private $id;
    private $idtype;

    function __construct($id, $idtype)
    {
        $this->id = $id;
        $this->idtype = $idtype;

    }

    function get()
    {
        // get product
        $db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
        $db->query("SET NAMES 'utf8'"); // formating to utf8
        $rows = $db->search('bsc_products')->setColumns('*')->addFilter("id=%d", $this->id)->addFilter("visible=%d", 1)->sortByOrdering('ASC')->getRows();
        // have types?
        if ($rows[0]['price_offer'] > 0) {
            $this->price = array(
                $rows[0]['price'],
                $rows[0]['price_offer']
            );
        } else {
            $this->price = array(
                $rows[0]['price'],
                0
            );
        }
        // has type?
        if ($this->idtype > 0) {
            $db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
            $db->query("SET NAMES 'utf8'"); // formating to utf8
            // SELECT * FROM bsc_types WHERE idProduct=2 ORDER BY ordering ASC
            $types = $db->search('bsc_types')->setColumns('*')->addFilter("id=%d", $this->idtype)->sortByOrdering('ASC')->getRows();

            if ($types[0]['price_offer'] > 0) {
                $this->price = array(
                    $types[0]['price'],
                    $types[0]['price_offer']
                );
            } else {
                $this->price = array(
                    $types[0]['price'],
                    0
                );
            }
        }
        return ($this->price);
    }
}

//--------------------------------------------------------
// renderchartshop
//--------------------------------------------------------
//
// Take data from the database and creates an array
//
class renderchartshop
{
    private $render = array();
    private $cartline = array(); // only a line
    private $cart = array(); // all cart

    function __construct($shoppingcart)
    {
        $this->cart = $shoppingcart; // load the shoppingcart
    }

    function get()
    {
        foreach ($this->cart as $productcart => $value) {

            $extractproduct = extractproduct($productcart);
            $id = $extractproduct[0];
            $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
            $Db->query("SET NAMES 'utf8'"); // formating to utf8
            $row = $Db->search('bsc_products')->setColumns('*')->addFilter("id=%d", $id)->addFilter("visible=%d", 1)->getRows();
            // read all row
            $name = $row[0]['name'];
            $id_product = $row[0]['id'];
            $img = $row[0]['img'];
            $productCode = $row[0]['productCode'];
            $id_type = 0;
            $name_type = '';
            $price = 0;
            $price_offer = 0;

            // Get price ////////////////////////////
            if ($row[0]['price_offer'] > 0) {
                $price = $row[0]['price'];
                $price_offer = $row[0]['price_offer'];
                $offer = 1;
            } else {
                $price = $row[0]['price'];
                $price_offer = 0;
                $offer = 0;
            }

            // has type? ////////////////////////////
            if (strlen($extractproduct[1]) > 0) {
                $db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
                $db->query("SET NAMES 'utf8'"); // formating to utf8
                // SELECT * FROM bsc_types WHERE idProduct=2 ORDER BY ordering ASC
                $types = $db->search('bsc_types')->setColumns('*')->addFilter("id=%d", $extractproduct[1])->sortByOrdering('ASC')->getRows();
                // Get price ////////////////////////////
                if ($types[0]['price_offer'] > 0) {
                    $price = $types[0]['price'];
                    $price_offer = $types[0]['price_offer'];
                    $offer = 1;
                } else {
                    $price = $types[0]['price'];
                    $price_offer = 0;
                    $offer = 0;
                }
                $id_type = $types[0]['id']; // take type id
                $name_type = $types[0]['name'];
            }

            $newline = array(
                'name' => $name,
                'name_type' => $name_type,
                'quantity' => $value,
                'price' => $price,
                'price_offer' => $price_offer,
                'offer' => $offer,
                'id_product' => $id_product,
                'id_type' => $id_type,
                'type_id' => 0,
                'img' => $img,
                'productCode' => $productCode
            );

            $this->render[] = $newline;
        }
        return ($this->render);
    }
}

//--------------------------------------------------------
// sendmail
//--------------------------------------------------------
/*
 * use:
 $sendmail = new sendmail($name, $to, $subject, $txt, $email);
 if($sendmail->send()=='true'){
 echo 'Email sent';
 }else{
 echo 'Could not send';
 }
 */

class sendmail
{
    function __construct($to, $subject, $message, $sendername, $senderemail)
    {
        $this->address = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers = "MIME-Version: 1.0" . "\r\n";
        $this->headers .= "Content-type:text/html; charset=iso-8859-1" . "\r\n";
        $this->headers .= "From: $sendername <$senderemail>" . "\r\n";
        $this->headers .= "Reply-To: $sendername <$senderemail>" . "\r\n";
        $this->headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    }

    function send()
    {
        if (mail($this->address, $this->subject, $this->message, $this->headers)) {
            return true;
        } else {
            return false;
        }
    }

}


//--------------------------------------------------------
// Check User
//--------------------------------------------------------

function CheckUser($payer_email, $password, $first_name, $last_name, $address_name, $address_country, $address_country_code, $address_zip, $address_state, $address_city, $address_street)
{
    // Its a new user ?
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $row = $Db->getRow('bsc_customers', 'payer_email', $payer_email); // returns the row from 'bsc_order_detail' table where 'payer_email' equals $payer_email
    if (count($row)) { // this user already exist ... then update
        if ($_SESSION['customer'] == $payer_email) {
            $settings = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'address_name' => $address_name,
                'address_country' => $address_country,
                'address_country_code' => $address_country_code,
                'address_zip' => $address_zip,
                'address_state' => $address_state,
                'address_city' => $address_city,
                'address_street' => $address_street
            );
            $filter[] = array(
                'payer_email=%s',
                $payer_email
            );
            $Db->updateRows('bsc_customers', $settings, $filter);
            $row = $Db->getRow('bsc_customers', 'payer_email', $payer_email);
            $_SESSION['customer_data'] = $row;
            return true;
        } else {
            return false;
        }
    } else { // this user dont exist .. then create
        $settings = array(
            'datelastorder' => date('Y-m-d H:i:s'),
            'dateregister' => date('Y-m-d H:i:s'),
            'payer_email' => $payer_email,
            'password' => hash('sha256', $password),
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address_name' => $address_name,
            'address_country' => $address_country,
            'address_country_code' => $address_country_code,
            'address_zip' => $address_zip,
            'address_state' => $address_state,
            'address_city' => $address_city,
            'address_street' => $address_street,
            'store_owner' => $_SESSION['enroller']
        );
        $Db->insertRow('bsc_customers', $settings);
        $row = $Db->getRow('bsc_customers', 'payer_email', $payer_email);
        $_SESSION['customer_data'] = $row;
        return true;
    }
}

function UpdateCreateUser()
{
    // Its a new user ?
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $customer = $Db->getRow('members', 'member_id', $_SESSION['member_id']);
    $sponsor = $Db->getRow('members', 'member_id', $customer['sponsor_id']);
    $row = $Db->getRow('bsc_customers', 'payer_email', $customer['email']); // returns the row from 'bsc_order_detail' table where 'payer_email' equals $payer_email
    if (count($row)) { // this user already exist ... then update
        $settings = array(
            'first_name' => $customer['first_name'],
            'last_name' => $customer['last_name'],
            'address_name' => $customer['first_name'] . ' ' . $customer['last_name'],
            'address_country_code' => $customer['country'],
            'address_zip' => $customer['postal'],
            'address_state' => $customer['state'],
            'address_city' => $customer['city'],
            'address_street' => $customer['street']
        );
        $filter[] = array(
            'payer_email=%s',
            $customer['email']
        );
        $Db->updateRows('bsc_customers', $settings, $filter);
        $row = $Db->getRow('bsc_customers', 'payer_email', $customer['email']);
        $_SESSION['customer_data'] = $row;
        $_SESSION['customer'] = $customer['email'];
    } else { // this user dont exist .. then create
        $settings = array(
            'datelastorder' => date('Y-m-d H:i:s'),
            'dateregister' => date('Y-m-d H:i:s'),
            'payer_email' => $customer['email'],
            'password' => $customer['password'],
            'first_name' => $customer['first_name'],
            'last_name' => $customer['last_name'],
            'address_name' => $customer['first_name'] . ' ' . $customer['last_name'],
            'address_country_code' => $customer['country'],
            'address_zip' => $customer['postal'],
            'address_state' => $customer['state'],
            'address_city' => $customer['city'],
            'address_street' => $customer['street'],
            'store_owner' => $sponsor['username'] ? $sponsor['username'] : $customer['username']
        );
        $Db->insertRow('bsc_customers', $settings);
        $row = $Db->getRow('bsc_customers', 'payer_email', $customer['email']);
        $_SESSION['customer_data'] = $row;
        $_SESSION['customer'] = $customer['email'];
        return true;
    }
}

function CheckLogin($email, $password)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $row = $Db->getRow('bsc_customers', 'payer_email', $email);
    if (hash('sha256', $password) == $row['password']) {
        $_SESSION['customer'] = $email;
        $_SESSION['customer_data'] = $row;
        return true;
    }
    return false;
}

function SendResetEmail($email)
{
    $mainUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/";
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $row = $Db->getRow('bsc_customers', 'payer_email', $email);
    if (isset($row['password'])) {
        $id = md5(uniqid() . $email);
        $data = array(
            'reset_hash' => $id
        );
        $filter[] = array(
            'payer_email=%s',
            $email
        );
        $Db->updateRows('bsc_customers', $data, $filter);
        $link = $mainUrl . 'store/reset/' . $id . '/';
        $subject = $_SESSION['settings']['site_name'] . ' Password Reset';
        $message = "Dear member,\n\nPlease follow the link to reset your password: " . $link . "\n\n\n" . $_SESSION['settings']['site_name'];
        if (sendMail($email, $subject, $message)) {
            return true;
        } else {
            $_SESSION['alert']['type'] = "danger";
            $_SESSION['alert']['message'] = "There was an problem sending the email, please try in few minutes.";
            return false;
        }
    }
    $_SESSION['alert']['type'] = "danger";
    $_SESSION['alert']['message'] = "Email was not found in the system";
    return false;
}

function sendMail($email, $subject, $message, $type = 'text')
{
    trackRetries('send_mail');
    if ($_SESSION['settings']['mailgate'] == 'php') {
        $header = 'From: ' . $_SESSION['settings']['admin_email'] . "\r\n" . 'Reply-To: ' . $_SESSION['settings']['admin_email'] . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        @mail($email, $subject, $message, $header);
    } else {
        try {
            $bodyType = ($type == 'text') ? 'text/plain' : 'text/html';
            $is_ssl = $_SESSION['settings']['mailgate'] == 'smtp_ssl' ? 'ssl' : '';
            $transporter = Swift_SmtpTransport::newInstance($_SESSION['settings']['smtp_host'], $_SESSION['settings']['smtp_port'], "$is_ssl")->setUsername($_SESSION['settings']['smtp_login'])->setPassword($_SESSION['settings']['smtp_password']);
            $mailer = Swift_Mailer::newInstance($transporter);
            $content = Swift_Message::newInstance($subject)->setFrom(array(
                $_SESSION['settings']['admin_email'] => $_SESSION['settings']['site_name']
            ))->setTo(array(
                $email
            ))->setBody($message, $bodyType);
            $result = $mailer->send($content);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    return true;
}

function trackRetries($name)
{
    if (isset($_SESSION['retries'][$name])) {
        if ($_SESSION['retries'][$name]['counter'] >= 3 && $_SESSION['retries'][$name]['last_time'] > time() - 60) {
            $_SESSION['alert']['type'] = "danger";
            $_SESSION['alert']['message'] = "Too many tries in such short period of time, please try again in 1 minute.";
            redirect("back");
        } elseif ($_SESSION['retries'][$name]['counter'] >= 3 && $_SESSION['retries'][$name]['last_time'] < time() - 60) {
            $_SESSION['retries'][$name]['counter'] = 1;
            $_SESSION['retries'][$name]['last_time'] = time();
        } else {
            $_SESSION['retries'][$name]['counter']++;
            $_SESSION['retries'][$name]['last_time'] = time();
        }
    } else {
        $_SESSION['retries'][$name]['counter'] = 1;
        $_SESSION['retries'][$name]['last_time'] = time();
    }
}

function redirect($location)
{
    if ($location == 'back') {
        if ($_SERVER['HTTP_REFERER']) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: /');
        }
        exit;
    } else {
        header('Location: ' . $location);
        exit;
    }
}

function ResetPassword($hash, $password)
{

    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $row = $Db->getRow('bsc_customers', 'reset_hash', $hash);
    if (isset($row['payer_email'])) {
        $data = array(
            'password' => hash('sha256', $password)
        );
        $filter[] = array(
            'reset_hash=%s',
            $hash
        );
        $Db->updateRows('bsc_customers', $data, $filter);
        return true;
    }
    return false;
}

function countries_options($selected = false)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $sort['name'] = 'ASC';
    $rows = $Db->getRows('countries', array(), array(), $sort);
    foreach ($rows as $row) {
        $select = $row['code'] == $selected ? 'selected="selected"' : '';
        echo '<option value="' . $row['code'] . '" ' . $select . '>' . $row['name'] . '</option>';
    }
}

function get_country_by_code($selected = false)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $row = $Db->getRow('countries', 'code', $selected);
    return $row['name'];
}

function GetOrders($selected = false)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $sort['id'] = 'DESC';
    $filter[] = array(
        'payer_email = %s',
        $_SESSION['customer']
    );
    return $Db->getRows('bsc_order_header', array(), $filter, $sort);

}

function GetOrderDetail($invoice)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $sort['id'] = 'DESC';
    $filter[] = array(
        'invoice = %s',
        $invoice
    );
    return $Db->getRows('bsc_order_detail', array(), $filter, $sort);
}

function GetProductImage($item_number)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $product = $Db->getRow('bsc_products', 'productCode', $item_number);
    if (isset($product['img'])) {
        return '<img src="/system/app/plugins/cart/assets/' . $product['img'] . '" width="100">';
    }
}

function PayCommissions($buyer_email, $commissionable, $invoice)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $buyer = $Db->getRow('bsc_customers', 'payer_email', $buyer_email);
    $store_owner_username = $buyer['store_owner'];
    $inner_buyer = $Db->getRow('members', 'email', $buyer_email);
    $seller = $Db->getRow('members', 'username', $store_owner_username);
    //direct selling
    if ($seller) {
        //echo $_SESSION['settings']['settings_cart_direct_commission'] . ' | ' . $commissionable; exit;
        if ($_SESSION['settings']['settings_cart_direct_commission'] > 0) {
            $seller_amount = number_format($_SESSION['settings']['settings_cart_direct_commission'] * $commissionable / 100, 2, '.', '');
            $Db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
				VALUES ('" . $seller_amount . "', '5', '0', '" . $seller['member_id'] . "', '" . time() . "', 'Store Direct Selling Commission For Invoice " . $invoice . "')");
        }
        if (isset($inner_buyer['member_id'])) {
            $seller = $inner_buyer;
        }
        if ($_SESSION['settings']['settings_cart_affiliate_type'] == 'forced') {
            payUplineForced($seller, $commissionable, $invoice);
        } elseif ($_SESSION['settings']['settings_cart_affiliate_type'] == 'unilevel') {
            payUplineUnilevel($seller, $commissionable, $invoice);
        } elseif ($_SESSION['settings']['settings_cart_affiliate_type'] == 'binary') {
            payUplineBinary($seller, $commissionable, $invoice);
        } elseif (substr_count($_SESSION['settings']['settings_cart_affiliate_type'], "hybrid")) {
            $plans = explode('-', str_replace('hybrid-', $_SESSION['settings']['settings_cart_affiliate_type']));
            foreach ($plans as $plan) {
                if ($plan == 'binary') {
                    payUplineBinary($seller, $commissionable, $invoice);
                }
                if ($plan == 'unilevel') {
                    payUplineUnilevel($seller, $commissionable, $invoice);
                }
                if ($plan == 'forced') {
                    payUplineForced($seller, $commissionable, $invoice);
                }
            }
        }

    }
}

function payUplineForced($member, $commissionable, $invoice)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    set_time_limit(60);
    ignore_user_abort(1);
    $depth = 20;
    $depthCounter = 0;
    $referrer = $Db->getRow('matrix', 'member_id', $member['member_id']);
    $referrerId = $referrer['referrer_id'];
    $i = 0;
    while ($depthCounter <= $depth) {
        $i++;
        if ($i > 120) {
            break;
        }
        if ($depthCounter >= $depth || $referrerId == 0) {
            break;
        }
        $uplineMember = $Db->getRow('members', 'member_id', $referrerId);
        $is_expired = ($uplineMember['membership_expiration'] > 0 && $uplineMember['membership_expiration'] < time()) ? 1 : 0;
        if ($uplineMember['membership'] != '0' && $is_expired == 0) { //free / customer dont earn, roll up
            //if (Member::isQualified($uplineMember)) {
            $uplineLevels = isset($_SESSION['settings'][$uplineMember['membership'] . '_cart_levels'])
                ? $_SESSION['settings'][$uplineMember['membership'] . '_cart_levels']
                : 0;
            if ($uplineLevels > $depthCounter) {
                $depthCounter++;
                if (!isset($_SESSION['settings']['settings_cart_level_' . $uplineMember['membership'] . '_' . $depthCounter])) {
                    continue;
                }
                $commision = number_format($_SESSION['settings']['settings_cart_level_' . $uplineMember['membership'] . '_' . $depthCounter] * $commissionable / 100, 2, '.', '');
                $Db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
				VALUES ('" . $commision . "', '5', '" . $member['member_id'] . "', '" . $uplineMember['member_id'] . "', '" . time() . "', 'Store Matrix Commission From Sale on Level " . $depthCounter . " (Invoice: " . $invoice . ") on " . $member['username'] . " Store' )");
            }
            //}
        }
        $referrer = $Db->getRow('matrix', 'member_id', $referrerId);
        $referrerId = $referrer['referrer_id'];
    }
}

function payUplineUnilevel($member, $commissionable, $invoice)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    set_time_limit(60);
    ignore_user_abort(1);
    $depth = 20;
    $depthCounter = 0;
    $referrerId = $member['sponsor_id'];
    $i = 0;

    // add comission for agent and manager
    if (!empty($member['manager_id'])) {
        $commision = number_format($_SESSION['settings']['settings_cart_level_MANAGER_1'] * $commissionable / 100, 2, '.', '');
        $Db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
				VALUES ('" . $commision . "', '5', '" . $member['member_id'] . "', '" . $member['manager_id'] . "', '" . time() . "', 'MANAGER Commission From " . $member['username'] . "' )");
    }

    if (!empty($member['agent_id'])) {
        $commision = number_format($_SESSION['settings']['settings_cart_level_AGENT_1'] * $commissionable / 100, 2, '.', '');
        $Db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
				VALUES ('" . $commision . "', '5', '" . $member['member_id'] . "', '" . $member['agent_id'] . "', '" . time() . "', 'AGENT Commission From " . $member['username'] . "' )");
    }

    // set MEMBERSHIP = RANK
    setMembership($member['member_id']);

    while ($depthCounter <= $depth) {
        $i++;
        if ($i > 120) {
            break;
        }
        if ($depthCounter >= $depth || $referrerId == 0) {
            break;
        }
        $uplineMember = $Db->getRow('members', 'member_id', $referrerId);
        $is_expired = ($uplineMember['membership_expiration'] > 0 && $uplineMember['membership_expiration'] < time()) ? 1 : 0;
        if ($uplineMember['membership'] != '0' && $is_expired == 0) { //free / customer dont earn, roll up
            //if (Member::isQualified($uplineMember)) {
            $uplineLevels = isset($_SESSION['settings'][$uplineMember['membership'] . '_cart_levels'])
                ? $_SESSION['settings'][$uplineMember['membership'] . '_cart_levels']
                : 0;
            if ($uplineLevels > $depthCounter) {
                $depthCounter++;
                if (!isset($_SESSION['settings']['settings_cart_level_' . $uplineMember['membership'] . '_' . $depthCounter])) {
                    $referrerId = $uplineMember['sponsor_id'];
                    continue;
                }
                $commision = number_format($_SESSION['settings']['settings_cart_level_' . $uplineMember['membership'] . '_' . $depthCounter] * $commissionable / 100, 2, '.', '');
                $Db->query("INSERT INTO wallet_payout (amount, transaction_type, from_id, to_id, transaction_date, descr) 
				VALUES ('" . $commision . "', '5', '" . $member['member_id'] . "', '" . $uplineMember['member_id'] . "', '" . time() . "', 'Store Unilevel Commission From Sale on Level " . $depthCounter . " (Invoice: " . $invoice . ") on " . $member['username'] . " Store' )");

                 // set MEMBERSHIP = RANK
                 setMembership($uplineMember['member_id']);
            }
            //}
        }
        $referrerId = $uplineMember['sponsor_id'];
    }
}

function setMembership($user_id)
{
    $noChange = ['agent', 'manager', 'member'];
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    set_time_limit(60);
    ignore_user_abort(1);
    \tmvc::instance()->controller->load->plugin_model('Ranks_Model', 'ranks');
    $rank_data = \tmvc::instance()->controller->ranks->getRankData($user_id);
    $user = $Db->getRow('members', 'member_id', $user_id);
    if (strtolower($rank_data['current_rank']) !== strtolower($user['membership']) && !in_array(strtolower($user['membership']), $noChange)) {
        $Db->query("UPDATE members SET membership = '" . strtoupper($rank_data['current_rank']) . "' WHERE member_id = " . (int)$user_id);
    }
}

function payUplineBinary($member, $amount, $invoice)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    set_time_limit(60);
    ignore_user_abort(1);
    $binary_mode = isset($_SESSION['settings']['settings_binary_mode']) ? $_SESSION['settings']['settings_binary_mode'] : 'weak_leg';
    $round_type = $_SESSION['settings']['settings_binary_round_type'];
    $amount = $round_type == 'ceil' ? ceil($amount) : floor($amount);
    $parent = $Db->getRow('members', 'member_id', $member['parent_id']);
    $trackingId = $member['member_id'];
    while (true) {
        $leg = $parent['left_leg'] == $trackingId ? 'left' : 'right';

        if ($leg == 'left') {
            addPv('left_volume', $parent['member_id'], $member['member_id'], $amount, $member['username']);    // add bv to this user left
        } else {
            addPv('right_volume', $parent['member_id'], $member['member_id'], $amount, $member['username']);    //add bv to this user right
        }
        if ($binary_mode == 'pair_match') {
            payPairMatch($parent['member_id']);
        }
        if ($parent['member_id'] == 1) {
            break;
        }
        $trackingId = $parent['member_id'];
        $parent = $Db->getRow('members', 'member_id', $parent['parent_id']);
    }
}

function payPairMatch($memberId)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $member = $Db->query("SELECT * FROM members WHERE member_id = " . $memberId);
    $membership = $member[0]['membership'];
    $left_required = $_SESSION['settings']['setting_binary_pair_left_leg_required'];
    $right_required = $_SESSION['settings']['setting_binary_pair_right_leg_required'];
    $match_commission = $_SESSION['settings']['setting_binary_pair_match_commission'];
    $max_pairs_per_day = $_SESSION['settings'][$membership . '_binary_max_pairs_per_day'];
    $matching_percent = $_SESSION['settings']['setting_binary_matching_bonus_percent'];
    $today = date("Y-m-d");
    while (true) {
        $last_entry = $Db->query("SELECT * FROM binary_volume WHERE member_id = " . $memberId . " ORDER BY id DESC LIMIT 1");
        $left_balance = (isset($last_entry[0]['left_balance']) ? $last_entry[0]['left_balance'] : 0);
        $right_balance = (isset($last_entry[0]['right_balance']) ? $last_entry[0]['right_balance'] : 0);
        $call = $Db->query("SELECT pairs_amount FROM binary_daily_pair_match_track WHERE member_id = " . $memberId . " AND day = '" . $today . "'");
        $chk_today_pairs = $call[0]['pairs_amount'];
        if ($left_balance >= $left_required && $right_balance >= $right_required && $chk_today_pairs < $max_pairs_per_day) {
            $left_balance = $left_balance - $left_required;
            $right_balance = $right_balance - $right_required;
            $Db->query("INSERT INTO binary_volume (member_id, left_volume, left_balance, right_volume, right_balance, from_id, description) VALUES('" . $memberId . "', '-" . $left_required . "', '" . $left_balance . "' ,'-" . $right_required . "', '" . $right_balance . "', '0', 'Volume taken from pair match commission payment')");
            $Db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) 
				VALUES ('" . $match_commission . "', 2, '" . $memberId . "', '" . time() . "', 'Binary pair match commission')");

            if ($chk_today_pairs > 0) {
                $Db->query("UPDATE binary_daily_pair_match_track SET pairs_amount = pairs_amount + 1, commissions = commissions + " . $match_commission . " WHERE member_id = " . $memberId . " AND day = '" . $today . "'");
            } else {
                $Db->query("INSERT INTO binary_daily_pair_match_track (member_id, pairs_amount, day, commissions) 
				VALUES ('" . $memberId . "', 1, '" . $today . "', '" . $match_commission . "')");
            }

            $call = $Db->query("SELECT COUNT(*) as total FROM binary_daily_pair_match_report WHERE day = '" . $today . "'");
            $chk_today_pairs_report = $call[0]['total'];
            if ($chk_today_pairs_report > 0) {
                $Db->query("UPDATE binary_daily_pair_match_report SET pairs_paid = pairs_paid + 1, commissions = commissions + " . $match_commission . " WHERE day = '" . $today . "'");
            } else {
                $Db->query("INSERT INTO binary_daily_pair_match_report (pairs_paid, day, commissions) 
				VALUES (1, '" . $today . "', '" . $match_commission . "')");
            }
            $matching_bonus = $match_commission * $matching_percent / 100;
            if ($member[0]['sponsor_id'] > 0 && $matching_bonus > 0) {
                $Db->query("INSERT INTO wallet_payout (amount, transaction_type, to_id, transaction_date, descr) 
				VALUES ('" . $matching_bonus . "', 6, '" . $member['sponsor_id'] . "', '" . time() . "', 'Binary matching bonus commission from " . $member[0]['username'] . "')");
                $Db->query("UPDATE binary_daily_pair_match_track SET matching_bonus = matching_bonus + " . $matching_bonus . " WHERE member_id = " . $memberId . " AND day = '" . $today . "'");
                $Db->query("UPDATE binary_daily_pair_match_report SET matching_bonus = matching_bonus + " . $matching_bonus . " WHERE day = '" . $today . "'");
            }
        } else {
            break;
        }
    }
    return;
}

function addPv($leg, $memberId, $from_id, $PV, $username)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $left = $leg == 'left_volume' ? $PV : 0;
    $right = $leg == 'right_volume' ? $PV : 0;
    $last_entry = $Db->query("SELECT * FROM binary_volume WHERE member_id = " . $memberId . " ORDER BY id DESC LIMIT 1");
    $left_balance = (isset($last_entry[0]['left_balance']) ? $last_entry[0]['left_balance'] : 0) + $left;
    $right_balance = (isset($last_entry[0]['right_balance']) ? $last_entry[0]['right_balance'] : 0) + $right;
    //$left_balance = getMemberVolumeLeft($memberId) + $left;
    //$right_balance = getMemberVolumeRight($memberId) + $right;
    $Db->query("INSERT INTO binary_volume (member_id, left_volume, left_balance, right_volume, right_balance, from_id, description) VALUES('" . $memberId . "', '" . $left . "', '" . $left_balance . "' ,'" . $right . "', '" . $right_balance . "', '" . $from_id . "', 'Volume added from Member (" . $username . ") Shop Purchase')");

}


function getMemberVolumeLeft($memberId)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $data = $Db->query("SELECT SUM(left_volume) AS total FROM binary_volume WHERE member_id = " . $memberId);
    return $data[0]['total'];
}

function getMemberVolumeRight($memberId)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $data = $Db->query("SELECT SUM(right_volume) AS total FROM binary_volume WHERE member_id = " . $memberId);
    return $data[0]['total'];
}

function GetShippingAmount($productId, $region)
{
    $Db = eden('mysql', EW_CONN_HOST, EW_CONN_DB, EW_CONN_USER, EW_CONN_PASS); //instantiate
    $Db->query("SET NAMES 'utf8'"); // formating to utf8
    $row = $Db->getRow('bsc_products', 'id', $productId);
    $shipping = explode("\n", $row['shipping']);
    $region = strtolower($region);
    foreach ($shipping as $row) {
        $row = strtolower($row);
        list($sRegion, $sAmount) = explode(',', str_replace('"', '', $row));
        $shippingFee[$sRegion] = $sAmount;
    }
    if (isset($shippingFee[$region])) {
        return $shippingFee[$region];
    } elseif (isset($shippingFee['other'])) {
        return $shippingFee['other'];
    } else {
        return 0;
    }
}

if (!isset($_SESSION['enroller'])) {
    $_SESSION['enroller'] = isset($_GET['associate']) ? htmlentities($_GET['associate']) : (isset($_COOKIE['enroller']) ? htmlentities($_COOKIE['enroller']) : 'admin');
}

if (!isset($_SESSION['customer_data']) && isset($_SESSION['customer'])) {
    unset($_SESSION['customer']);
}
