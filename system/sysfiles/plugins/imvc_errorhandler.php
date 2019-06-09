<?php


function iMVC_ErrorHandler($errno, $errstr, $errfile, $errline) {
  // do nothing if error reporting is turned off
  
  if (error_reporting() === 0)
  {
    return;
  }
  // be sure received error is supposed to be reported
  if (error_reporting() & $errno)
  {   
		throw new iMVC_ExceptionHandler($errstr, $errno, $errno, $errfile, $errline);
  }
}

?>