<?php

class iMVC_Library_Lock {

    protected $key   = null;  //user given value
    protected $file  = null;  //resource to lock
    protected $own   = FALSE; //have we locked resource

    function __construct( $key ) 
    {
		$files = glob("storage/locks/*");
  		$time  = time();
  		foreach ($files as $file) {
    		if (is_file($file)){
      			if ($time - filemtime($file) >= 60*5)  {
        			unlink($file);
				}
			}
		}
        $this->key = $key;
        //create a new resource or get exisitng with same key
        $this->file = fopen("storage/locks/$key.lockfile", 'w+');
    }


    function __destruct() 
    {
        if( $this->own == TRUE )
            $this->unlock( );
    }


    function lock( ) 
    {
		usleep(rand(100000,1000000));
        if( !flock($this->file, LOCK_EX)) 
        { //failed
            $key = $this->key;
            return FALSE;
        }
        ftruncate($this->file, 0); // truncate file
        //write something to just help debugging
        fwrite( $this->file, "Locked\n");
        fflush( $this->file );

        $this->own = TRUE;
        return $this->own;
    }


    function unlock( ) 
    {
        $key = $this->key;
        if( $this->own == TRUE ) 
        {
            if( !flock($this->file, LOCK_UN) )
            { //failed
                return FALSE;
            }
            ftruncate($this->file, 0); // truncate file
            //write something to just help debugging
            fwrite( $this->file, "Unlocked\n");
            fflush( $this->file );
        }
        $this->own = FALSE;
        return $this->own;
    }
}
