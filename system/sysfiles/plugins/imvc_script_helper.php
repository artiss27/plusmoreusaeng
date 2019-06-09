<?php

Class iMVC_Script_Helper
{

  static function debug($var,$name=null,$return=false,$esc=true,$hide=false)
  {
    ob_start();
    if(!$hide)
    {
      echo '<pre style="background-color: #000; border: 1px solid #3f3; clear: both; color: #3f3; line-height: 1.2em; margin: 2em 0; text-align: left;">';
      if(isset($name))
        echo '<strong style="background-color: #3f3; color: #000; display: block; padding: .33em 12px;">'.$name.'</strong>';
      echo '<span style="display: block; max-height: 430px; overflow: auto; padding: 0 6px 1.2em 6px;">';
    }
    else
      echo '<!--';
    echo $esc ? htmlentities(print_r($var,true)) : print_r($var,true);
    if(!$hide)
      echo '</span></pre>';
    else
      echo '-->';
    if(!$return)
      ob_end_flush();
    else
    {
      $contents = ob_get_contents();
      ob_end_clean();
      return $contents;
    }
  }
  

  static function redirect($uri)
  {
    // sanity check
    if(empty($uri))
      return false;
      
    header("Location: $uri");
    exit;
  }
  
}
  
  
?>
