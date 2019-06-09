<?php

class Photo_Controller extends iMVC_Controller
{
    public function anyUpload()
    {
        if (!CoreHelp::memberIsLoggedIn()) {
            CoreHelp::redirect('/members/login/');
        }
        $memberId = CoreHelp::getMemberId();					
        $profile = $this->member->getProfile($memberId);
		$encoded_data = $_POST['handler'];
		$binary_data = base64_decode( $encoded_data );
		$result = file_put_contents( "storage/".$memberId.".jpg", $binary_data );		
		$path[0] = "storage/".$memberId.".jpg";
		$info = getimagesize($path[0]);
		if($info[2] != IMAGETYPE_JPEG){
			CoreHelp::setSession('error', 'Invalid image uploaded from webcam');
			CoreHelp::redirect('/members/profile');
		}
		$fileNameNew = $memberId . ".jpg";
		$path[1] = 'media/avatars/normal/'. $fileNameNew;
		$path[2] = 'media/avatars/thumb/'. $fileNameNew;
		CoreHelp::createThumb($path[0], $path[1], "jpg", 250, 250, 250);
		CoreHelp::createThumb($path[1], $path[2], "jpg", 50, 50, 50);
		unlink($path[0]);
		CoreHelp::redirect('/members/profile');
    }  

}
