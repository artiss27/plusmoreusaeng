<?php
/**
 * 
 * SendMoneyClient
 * 
 * A class which facilitates the interaction with Payza's 
 * SendMoney API. SendMoneyClient class allows user to create 
 * the data to be sent to the API in the correct format and 
 * retrieve the response. 
 * 
 * 
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY
 * OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT
 * LIMITED TO THE IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * @author Payza
 * @copyright 2010
 */

class SendMoneyClient
{
    /**
     * The API's response variables
     */
    private $responseArray;

    /**
     * The server address of the SendMoney API
     */
    private $server = 'api.payza.com';

    /**
     * The exact URL of the SendMoney API
     */
    private $url = '/svc/api.svc/sendmoney';

    /**
     * Your Payza user name which is your email address
     */
    private $myUserName = '';

    /**
     * Your API password that is generated from your Payza account
     */
    private $apiPassword = '';

    /**
     * The data that will be sent to the SendMoney API
     */
    public $dataToSend = '';


    /**
     * SendMoneyClient::__construct()
     * 
     * Constructs a SendMoneyClient object
     * 
     * @param string $userName Your Payza user name.
     * @param string $password Your API password.
     */
    public function __construct($userName, $password)
    {
        $this->myUserName = $userName;
        $this->apiPassword = $password;
        $this->dataToSend = '';
    }


    /**
     * SendMoneyClient::setServer()
     * 
     * Sets the $server variable
     * 
     * @param string $newServer New web address of the server.
     */
    public function setServer($newServer = '')
    {
        $this->server = $newServer;
    }


    /**
     * SendMoneyClient::getServer()
     * 
     * Returns the server variable
     * 
     * @return string A variable containing the server's web address.
     */
    public function getServer()
    {
        return $this->server;
    }


    /**
     * SendMoneyClient::setUrl()
     * 
     * Sets the $url variable
     * 
     * @param string $newUrl New url address.
     */
    public function setUrl($newUrl = '')
    {
        $this->url = $newUrl;
    }


    /**
     * SendMoneyClient::getUrl()
     * 
     * Returns the url variable
     * 
     * @return string A variable containing a URL address.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * SendMoneyClient::buildPostVariables()
     * 
     * Builds an URL encoded post string which contains the variables to be 
     * sent to the API in the correct format. 
     * 
     * @param int $amountPaid Payment amount.
     * @param string $currency 3 letter ISO-4217 currency code.
     * @param string $receiverEmail	Recipient's email address.
     * @param string $senderEmail Your secondary email (optional).
     * @param int $purchaseType A valid purchase type code.
     * @param string $note Note that you would like to send to the recipient.
     * @param int $testMode Test mode status.
     * 
     * @return string The URL encoded post string
     */
    public function buildPostVariables($amountPaid = 0.00, $currency = 'USD', $receiverEmail ='', $senderEmail = '', $purchaseType = 0, $note = '', $testMode = '1')
    {
        $this->dataToSend = sprintf("USER=%s&PASSWORD=%s&AMOUNT=%s&CURRENCY=%s&RECEIVEREMAIL=%s&SENDEREMAIL=%s&PURCHASETYPE=%s&NOTE=%s&TESTMODE=%s",
            urlencode($this->myUserName), urlencode($this->apiPassword), urlencode((string)$amountPaid), urlencode($currency), urlencode($receiverEmail), urlencode($senderEmail), 
			urlencode((string)$purchaseType), urlencode((string)$note), urlencode((string )$testMode));
        return $this->dataToSend;
    }


    /**
     * SendMoneyClient::send()
     * 
     * Sends the URL encoded post string to the SendMoney API 
     * using cURL and retrieves the response.
     * 
     * @return string The response from the SendMoney API.
     */
    public function send()
    {
        $response = '';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://' . $this->getServer() . $this->getUrl());
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->dataToSend);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


    /**
     * SendMoneyClient::parseResponse()
     * 
     * Parses the encoded response from the SendMoney API
     * into an associative array.
     * 
     * @param string $input The string to be parsed by the function.
     */
    public function parseResponse($input)
    {
        parse_str($input, $this->responseArray);
    }


    /**
     * SendMoneyClient::getResponse()
     * 
     * Returns the responseArray 
     * 
     * @return string An array containing the response variables.
     */
    public function getResponse()
    {
        return $this->responseArray;
    }


    /**
     * SendMoneyClient::__destruct()
     * 
     * Destructor of the SendMoneyClient object
     */
    public function __destruct()
    {
        unset($this->responseArray);
    }
}
?>