<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://bottr.me
 * @since      1.0.0
 *
 * @package    Wp_Bottr_Connect
 * @subpackage Wp_Bottr_Connect/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="bottr-outer-wrap wrap col-xs-12">
    <div class="bottr-wrap col-xs-12">
        <?php
    	    $bottr_options = get_option( 'bottr_options' );
    	    $exists = true;
    	    if( !is_array($bottr_options) ) {
    	    	$exists = false;
    	        $bottr_options = array(
    	            'username' => ''
    	        );
    	    }
    	?>

        <!-- LeftColumn -->
        <div class="col-md-6 vertical-middle">
            <div class="bottr-hero-unit">
                <p class="bottr-logo">
                    <img src="https://d279m54f1qquet.cloudfront.net/common/img/common/bottr_logo.png" width="120" />
                </p>
                <p class="bottr-title">
                    Chatbot by Bottr is a lightweight and powerful plugin that allows you to add a live chat widget a.k.a. your personal chatbot to your website or blog.
                </p>
            </div>
        </div>
        <!-- /LeftColumn -->
        <!-- RightColumn -->
        <div class="col-md-6 vertical-middle bottr-col-right">
            <p class="bottr-list-title">
                To activate your widget follow these steps:
            </p>
            <ul class="bottr-list">
                <li>
                    <span>
                        <a class="bottr-signup" href="https://bottr.me?auth=true&utm_medium=WordPress_Plugin" target="_blank">Signup</a> on bottr and create your bot
                    </span>
                </li>
                <li>
                    <span>
                        Come back and add your bot url here
                        <form method="post" action="options.php"> 
                            <?php @settings_fields('wp_bottr_connect-group'); ?>
                            <?php // @do_settings_fields('wp_bottr_connect-group'); ?>


                            <div class="bottr-input-group no-pad">
                                <span class="col-xs-2 no-pad text-right col-1">bottr.me/</span>
                                <span class="col-xs-5 no-pad col-2">
                                    <input placeholder="botname" required type="text" name="bottr_options[username]" minlength="4" id="wp_bottr_connect_tapname" class="form-control" value="<?php echo $bottr_options['username']; ?>" />
                                </span>
                                <span class="col-xs-3 no-pad col-3">
                                    <?php @submit_button('Save changes', 'btn-submit-bottr', 'submit', false); ?>
                                </span>
                            </div>

                            <!-- <div class="input-group bottr-input-group">
                                <span class="input-group-addon" id="username-group">https://bottr.me/</span>
                                <input aria-describedby="username-group" placeholder="botname" required type="text" name="bottr_options[username]" minlength="4" id="wp_bottr_connect_tapname" class="form-control" value="<?php echo $bottr_options['username']; ?>" />
                                <span class="input-group-btn">
                                    <?php // @submit_button('Save changes', 'btn btn-bottr', 'submit', false); ?>
                                </span>
                            </div>  -->
                        </form>
                        <div class="clearfix"></div>
                    </span>
                </li>
            </ul>
            <?php if( $exists == true ) { ?>
                <div class="col-xs-12 no-pad">
                    <p class="bottr-list-meta">
                        Now, your widget is activated and it will reflect on your site like this...
                    </p>
                    <div class="bottr-profileCard">
                        <div class="dp">
                            <img src="<?php echo $bottr_options['profilePicture']; ?>" class="bottr-profileCard-img">
                            <span class="tail">
                                <img src="https://d279m54f1qquet.cloudfront.net/common/img/inner/chat/body/tail.png" />
                            </span>
                        </div>
                        <h4 class="bottr-connected">
                            Connected as <span><?php echo $bottr_options['name']; ?><span>
                        </h4>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- /RightColumn -->
    </div> 
</div>

