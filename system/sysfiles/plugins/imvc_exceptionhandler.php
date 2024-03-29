<?php


class iMVC_ExceptionHandler extends ErrorException {
  
  
  public static function printException(Exception $e)
  {
    switch ($e->getCode()) {
        case E_ERROR:
				  $code_name = 'E_ERROR';
        break;
        case E_WARNING:
				  $code_name = 'E_WARNING';
        break;
        case E_PARSE:
				  $code_name = 'E_PARSE';
        break;
        case E_NOTICE:
				  $code_name = 'E_NOTICE';
        break;
        case E_CORE_ERROR:
				  $code_name = 'E_CORE_ERROR';
        break;
        case E_CORE_WARNING:
				  $code_name = 'E_CORE_WARNING';
        break;
        case E_COMPILE_ERROR:
				  $code_name = 'E_COMPILE_ERROR';
        break;
        case E_COMPILE_WARNING:
				  $code_name = 'E_COMPILE_WARNING';
        break;
        case E_USER_ERROR:
				  $code_name = 'E_USER_ERROR';
        break;
        case E_USER_WARNING:
				  $code_name = 'E_USER_WARNING';
        break;
        case E_USER_NOTICE:
				  $code_name = 'E_USER_NOTICE';
        break;
        case E_STRICT:
				  $code_name = 'E_STRICT';
        break;
        case E_RECOVERABLE_ERROR:
				  $code_name = 'E_RECOVERABLE_ERROR';
        break;
				default:
				  $code_name = $e->getCode();
			  break;
	  }
	  
	  ?>
    <span style="text-align: left; background-color: #fcc; border: 1px solid #600; color: #600; display: block; margin: 1em 0; padding: .33em 6px">
      <b>Error:</b> <?=$code_name?><br />
      <b>Message:</b> <?=$e->getMessage()?><br />
      <b>File:</b> <?=$e->getFile()?><br />
      <b>Line:</b> <?=$e->getLine()?>
    </span>
	  <?php
  }
  
	/**
	 * handleException
	 *
	 * @access	public
	 */    
  public static function handleException(Exception $e)
  {
		if (error_reporting() === 0)
		{
			return;
		}
		else {
       		return self::printException($e);
		}
  }
}

?>