<?

class Hash{
    var $scramble1;     
    var $scramble2;     

    var $errors;        
    var $adj;          
    var $mod;           
    function Hash(){
        $this->errors = array();

        $this->scramble1 = '! #$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_`abcdefghijklmnopqrstuvwxyz{|}~';
        $this->scramble2 = 'f^jAE]okIOzU[2&q1{3`h5w_794p@6s8?BgP>dFV=m D<TcS%Ze|r:lGK/uCy.Jx)HiQ!#$~(;Lt-R}Ma,NvW+Ynb*0X';

        if (strlen($this->scramble1) <> strlen($this->scramble2)) {
            trigger_error('** SCRAMBLE1 is not same length as SCRAMBLE2 **', E_USER_ERROR);
        }
        $this->adj = 1.75;  
        $this->mod = 3;
    }
    function decrypt ($key, $source){
        $this->errors = array();
        $fudgefactor = $this->_convertKey($key);
        if ($this->errors) return;
        if (empty($source)) {
            $this->errors[] = 'No value has been supplied for decryption';
            return;
        } 
        $target = null;
        $factor2 = 0;
        for ($i = 0; $i < strlen($source); $i++) {
            if (function_exists('mb_substr')) {
                $char2 = mb_substr($source, $i, 1);
            } else {
                $char2 = substr($source, $i, 1);
            }
            $num2 = strpos($this->scramble2, $char2);
            if ($num2 === false) {
                $this->errors[] = "Source string contains an invalid character ($char2)";
                return;
            }
            $adj     = $this->_applyFudgeFactor($fudgefactor);

            $factor1 = $factor2 + $adj;                 // accumulate in $factor1
            $num1    = $num2 - round($factor1);         // generate offset for $scramble1
            $num1    = $this->_checkRange($num1);       // check range
            $factor2 = $factor1 + $num2;                // accumulate in $factor2
            if (function_exists('mb_substr')) {
                $char1 = mb_substr($this->scramble1, $num1, 1);
            } else {
                $char1 = substr($this->scramble1, $num1, 1);
            } 
            $target .= $char1;
            //echo "char1=$char1, num1=$num1, adj= $adj, factor1= $factor1, num2=$num2, char2=$char2, factor2= $factor2<br />\n";
        }
        return rtrim($target);
    }
    function encrypt ($key, $source, $sourcelen = 0){
        $this->errors = array();
        $fudgefactor = $this->_convertKey($key);
        if ($this->errors) return;

        if (empty($source)) {
            $this->errors[] = 'No value has been supplied for encryption';
            return;
        }
        $source = str_pad($source, $sourcelen);
        $target = null;
        $factor2 = 0;
        for ($i = 0; $i < strlen($source); $i++) {
            if (function_exists('mb_substr')) {
                $char1 = mb_substr($source, $i, 1);
            } else {
                $char1 = substr($source, $i, 1);
            }
            $num1 = strpos($this->scramble1, $char1);
            if ($num1 === false) {
                $this->errors[] = "Source string contains an invalid character ($char1)";
                return;
            }
            $adj     = $this->_applyFudgeFactor($fudgefactor);
            $factor1 = $factor2 + $adj;             // accumulate in $factor1
            $num2    = round($factor1) + $num1;     // generate offset for $scramble2
            $num2    = $this->_checkRange($num2);   // check range
            $factor2 = $factor1 + $num2;            // accumulate in $factor2
            if (function_exists('mb_substr')) {
                $char2 = mb_substr($this->scramble2, $num2, 1);
            } else {
                $char2 = substr($this->scramble2, $num2, 1);
            } 
            $target .= $char2;
            //echo "char1=$char1, num1=$num1, adj= $adj, factor1= $factor1, num2=$num2, char2=$char2, factor2= $factor2<br />\n";
        }
        return $target;
    } 
    function getAdjustment (){
        return $this->adj;
    }
	function getModulus (){
        return $this->mod;
    } 
	function setAdjustment ($adj){
        $this->adj = (float)$adj;
    } 
	function setModulus ($mod){
        $this->mod = (int)abs($mod);    // must be a positive whole number

    }
	function _applyFudgeFactor (&$fudgefactor){
        $fudge = array_shift($fudgefactor);     // extract 1st number from array
        $fudge = $fudge + $this->adj;           // add in adjustment value
        $fudgefactor[] = $fudge;                // put it back at end of array
        if (!empty($this->mod)) {               // if modifier has been supplied
            if ($fudge % $this->mod == 0) {     // if it is divisible by modifier
                $fudge = $fudge * -1;           // make it negative
            }
        } 

        return $fudge;

    }
	function _checkRange ($num) {
        $num = round($num);         
        $limit = strlen($this->scramble1);
        while ($num >= $limit) {
            $num = $num - $limit;   
        } 
        while ($num < 0) {
            $num = $num + $limit;   
        } 
        return $num;
    } 
	function _convertKey ($key){
        if (empty($key)) {
            $this->errors[] = 'No value has been supplied for the encryption key';
            return;
        }
        $array[] = strlen($key);   
        $tot = 0;
        for ($i = 0; $i < strlen($key); $i++) {
            if (function_exists('mb_substr')) {
                $char = mb_substr($key, $i, 1);
            } else {
                $char = substr($key, $i, 1);
            }
            $num = strpos($this->scramble1, $char);
            if ($num === false) {
                $this->errors[] = "Key contains an invalid character ($char)";
                return;
            }
            $array[] = $num;        // store in output array
            $tot = $tot + $num;     // accumulate total for later
        }

        $array[] = $tot;            // insert total as last entry in array
        return $array;
    }
}
?>