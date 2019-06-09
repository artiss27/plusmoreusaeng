<?php

namespace webcam;

$hooks = \voku\helper\Hooks::getInstance();
$hooks->add_action('show_webcam_form', '\webcam\setActionShowWebcamForm');

function setActionShowWebcamForm()
{

echo '
<style>
	#webcam {
		width: 100%;
		text-align: center;		
		position: relative;
	}
	#my_camera {
		width: 250px; 
		height: 250px;
		margin: auto;
	}
</style>
		<div style="text-align:center;margin-top:5px;cursor: pointer;" id="usewebcam">Or use Webcam</div>
		<script src="/assets/common/vendor/jquery/dist/jquery.min.js"></script>
		<script src="/system/app/plugins/webcam/jquery/webcam.min.js"></script>
		<div id="webcam" style="display:none;">
			<div id="my_camera"></div>
			<div id="my_result" style="display:none;"></div>
			<a id="take_picture" href="javascript:void(take_snapshot())" class="btn btn-primary btn-sm">Take Snapshot</a>
			<a style="display:none;" id="upload_picture" href="javascript:void(upload_snapshot())" class="btn btn-primary btn-sm">Use this one!</a></td>
    		<a style="display:none;" id="new_snapshot" href="#" class="btn btn-primary btn-sm">New Snapshot</a></td>
			<a style="display:none;" id="close_webcam" href="#" class="btn btn-primary btn-sm">Close Webcam</a></td>
			<form id="upload" method="post" action="/plugins/webcam/photo/upload">
				<input id="handler" type="hidden" name="handler" value=""/>
			</form>
    <script language="JavaScript">
		Webcam.set({
			width: 250,
			height: 250,
			dest_width: 250,
			dest_height: 250,
			image_format: \'jpeg\',
			jpeg_quality: 90,
			force_flash: true,
			flip_horiz: true,
			fps: 45
    	});
		
			var hasFlash = false;
			try {
			  var fo = new ActiveXObject(\'ShockwaveFlash.ShockwaveFlash\');
			  if(fo) hasFlash = true;
			}catch(e){
			  if(navigator.mimeTypes ["application/x-shockwave-flash"] != undefined) hasFlash = true;
			}
		  if(hasFlash) {
			Webcam.attach( \'#my_camera\' );
		  }
		  else {
			$("#usewebcam").hide();
		  }		 	
		     

        function take_snapshot() {
            Webcam.snap( function(data_uri) {
				var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, \'\');
				$("#my_camera").hide();
				$("#my_result").html(\'<img src="\'+data_uri+\'"/>\');
				$("#handler").val(raw_image_data);
				$("#my_result").show();
				$("#take_picture").hide();
				$("#upload_picture").show();
				$("#new_snapshot").show();
            } );
        }
		
		function upload_snapshot() {
			$("#upload").submit();	
		}
		
		$("#usewebcam").click(function(){
			$("#usewebcam").hide();
			$("#imgContainer").hide();
			$("#webcam").show();
			$("#close_webcam").show();			
		})
		
		$("#close_webcam").click(function(){
			$("#usewebcam").show();
			$("#imgContainer").show();
			$("#webcam").hide();
			$("#close_webcam").hide();				
		})
		
		$("#new_snapshot").click(function(){
			$("#my_result").hide();
			$("#my_camera").show();			
			$("#take_picture").show();
			$("#upload_picture").hide();
			$("#new_snapshot").hide();
		})
    </script>    
	';
	
}

?>