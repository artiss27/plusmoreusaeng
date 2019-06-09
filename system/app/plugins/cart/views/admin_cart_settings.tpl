{include file='views/admin/header.tpl'}
{include file='views/admin/menu.tpl'}
<style>
#imgContainer {
  width: 100%;
  /*text-align: center;*/
  position: relative;
}
#imgArea {
  display: inline-block;
  margin: 0 auto;
  width: 120px;
  height: 40px;
  position: relative;
  background-color: #eee;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 13px;
}
#imgArea img {
  outline: medium none;
  vertical-align: middle;
  width: 100%;
}
#imgChange {
  background: url("/assets/members/images/overlay.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
  bottom: 0;
  color: #FFFFFF; 
  height: 30px;
  left: 0;
  line-height: 32px;
  position: absolute;
  text-align: center;
  width: 100%;
  overflow: hidden;
  z-index:10000;
  display:none;
}

#imgChange input[type="file"] {
  bottom: 0;
  cursor: pointer;
  height: 100%;
  left: 0;
  margin: 0;
  opacity: 0;
  padding: 0;
  position: absolute;
  width: 100%;
  z-index: 0;
}

/* Progressbar */
.progressBar {
  background: none repeat scroll 0 0 #E0E0E0;
  left: 0;
  padding: 3px 0;
  position: absolute;
  top: 50%;
  width: 100%;
  display: none;
}
.progressBar .bar {
  background-color: #FF6C67;
  width: 0%;
  height: 14px;
}
.progressBar .percent {
  display: inline-block;
  left: 0;
  position: absolute;
  text-align: center;
  top: 2px;
  width: 100%;
}
</style>
<!-- Main Wrapper -->
<div id="wrapper">
<div class="normalheader transition animated fadeIn">
   <div class="hpanel">
      <div class="panel-body">
         <a class="small-header-action" href="">
            <div class="clip-header">
               <i class="fa fa-arrow-up"></i>
            </div>
         </a>
         <h2 class="font-light m-b-xs">
            Store Settings
         </h2>
         <small>Setup your Store</small>
      </div>
   </div>
</div>
<div class="row">
   <div class="normalheader transition animated fadeIn">
      <div class="hpanel">
         <div class="panel-body">
            <a class="small-header-action" href="">
               <div class="clip-header">
                  <i class="fa fa-arrow-up"></i>
               </div>
            </a>
            {if $smarty.session.message}
            <p class="alert alert-success">
               {assign var=message_var value=CoreHelp::flash('message')}
               {$message_var}
            </p>
            <br />
            {/if} 
            {if $smarty.session.error}
            {assign var=message_var value=CoreHelp::flash('error')}             
            {if $message_var|is_array}
            {foreach $message_var as $error}
            <p class="alert alert-danger">
               {$error}
            </p>
            <br />
            {/foreach} 
            {else}
            <p class="alert alert-danger">
               {$message_var}
            </p>
            <br />
            {/if}
            {/if} 
            {foreach $errors as $error}
            <p class="alert alert-danger">
               {$error}
            </p>
            <br />
            {/foreach}  
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                          
                              <div class="columns clear bt-space5">
                                 <div class="col2-3">
                                    <div class="clear"></div>
                                    
                                    <div id="imgContainer">
                                    <p>Replicated Store Logo (Transparent PNG 120x40)</p>
                                      <form enctype="multipart/form-data" action="/plugins/cart/cartadmin/uploadpic" method="post" name="image_upload_form" id="image_upload_form">                                        
                                        <div id="imgArea"><img widht="120" height="40" src="{$logo}">
                                          <div class="progressBar">
                                            <div class="bar"></div>
                                            <div class="percent">0%</div>
                                          </div>
                                          <div id="imgChange"><span>Change Logo</span>
                                            <input type="file" accept="image/png" name="image_upload_file" id="image_upload_file">
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                     <form action="#" method="post" class="validate-form form bt-space5">
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Store affiliate type:</label> 
                                       <select id="settings_cart_affiliate_type" class="form-control required" name="settings_cart_affiliate_type" onchange="processType()">
                                       <option value="unilevel" {if $settings.settings_cart_affiliate_type eq 'unilevel'}selected="selected"{/if}>Unilevel</option>
                                       {if $settings.affiliate_type eq 'forced'}<option value="forced" {if $settings.settings_cart_affiliate_type eq 'forced'}selected="selected"{/if}>Forced Matrix</option>{/if}
                                       {if $settings.affiliate_type eq 'binary'}<option value="binary" {if $settings.settings_cart_affiliate_type eq 'binary'}selected="selected"{/if}>Binary</option>{/if}
                                       {if substr_count($settings.affiliate_type, "hybrid")} <option value="{$settings.affiliate_type}" {if $settings.settings_cart_affiliate_type eq $settings.affiliate_type}selected="selected"{/if}>{$settings.affiliate_type}</option>{/if}
                                       </select>
                                    </div>
                                    <script>
                    function processType(){
                      a = $('#settings_cart_affiliate_type').val();
                      if(a == 'binary') {
                        $('#more').hide();  
                      }
                      else {
                        $('#more').show();    
                      }
                    }
                  </script>
                                    <br />                                    
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Store type:</label> 
                                       <select id="settings_cart_type" class="form-control required" name="settings_cart_type">
                                       <option value="inside" {if $settings.settings_cart_type eq 'inside'}selected="selected"{/if}>Backoffice Store Only</option>
                                       <option value="replicated" {if $settings.settings_cart_type eq 'replicated'}selected="selected"{/if}>Replicated Store Only</option>
                                       <option value="both" {if $settings.settings_cart_type eq 'both'}selected="selected"{/if}>Both</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">If using Replicated Stores, force customers to become affiliates or process purchases with Paypal within Replicated Store:</label> 
                                       <select id="replicated_cart_type" class="form-control required" name="replicated_cart_type">
                                       <option value="force_associate" {if $settings.replicated_cart_type eq 'force_associate'}selected="selected"{/if}>Force to become affiliates</option>
                                       <option value="process_as_customers_with_paypal" {if $settings.replicated_cart_type eq 'process_as_customers_with_paypal'}selected="selected"{/if}>Process purchases as customers with Paypal</option>     
                                       </select>
                                    </div>
                                    <br />                                    
                                     <div class="clear">
                                       <label class="fl-space size-300">Paypal Email: (Only needed if using Replicated Stores)</label>
                                       <input name="settings_cart_paypal_email" type="text" value="{if $settings.settings_cart_paypal_email}{$settings.settings_cart_paypal_email}{else}name@domain.com{/if}" size="5" class="form-control" />
                                    </div>
                                    <br /> 
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">If using Replicated Stores with Paypal, use Sanbox mode ?:</label> 
                                       <select id="settings_cart_paypal_sandbox" class="form-control required" name="settings_cart_paypal_sandbox">
                                       <option value="yes" {if $settings.settings_cart_paypal_sandbox eq 'yes'}selected="selected"{/if}>Yes</option>
                                       <option value="no" {if $settings.settings_cart_paypal_sandbox eq 'no'}selected="selected"{/if}>No</option>     
                                       </select>
                                    </div>
                                    <br />                                                                      
                                    <div class="clear">
                                       <label class="fl-space size-300">PayPal Currency Code:</label>
                                       <select name="settings_cart_currency_code" class="form-control required">
                                          <option value="" {if $settings.settings_cart_currency_code == ""}selected="selected"{/if}>Select Currency</option>
                                          <option value="AUD" {if $settings.settings_cart_currency_code == "AUD"}selected="selected"{/if}>Australian Dollar</option>
                                          <option value="BRL" {if $settings.settings_cart_currency_code == "BRL"}selected="selected"{/if}>Brazilian Real </option>
                                          <option value="CAD" {if $settings.settings_cart_currency_code == "CAD"}selected="selected"{/if}>Canadian Dollar</option>
                                          <option value="CZK" {if $settings.settings_cart_currency_code == "CZK"}selected="selected"{/if}>Czech Koruna</option>
                                          <option value="DKK" {if $settings.settings_cart_currency_code == "DKK"}selected="selected"{/if}>Danish Krone</option>
                                          <option value="EUR" {if $settings.settings_cart_currency_code == "EUR"}selected="selected"{/if}>Euro</option>
                                          <option value="HKD" {if $settings.settings_cart_currency_code == "HKD"}selected="selected"{/if}>Hong Kong Dollar</option>
                                          <option value="HUF" {if $settings.settings_cart_currency_code == "HUF"}selected="selected"{/if}>Hungarian Forint </option>
                                          <option value="ILS" {if $settings.settings_cart_currency_code == "ILS"}selected="selected"{/if}>Israeli New Sheqel</option>
                                          <option value="JPY" {if $settings.settings_cart_currency_code == "JPY"}selected="selected"{/if}>Japanese Yen</option>
                                          <option value="MYR" {if $settings.settings_cart_currency_code == "MYR"}selected="selected"{/if}>Malaysian Ringgit</option>
                                          <option value="MXN" {if $settings.settings_cart_currency_code == "MXN"}selected="selected"{/if}>Mexican Peso</option>
                                          <option value="NOK" {if $settings.settings_cart_currency_code == "NOK"}selected="selected"{/if}>Norwegian Krone</option>
                                          <option value="NZD" {if $settings.settings_cart_currency_code == "NZD"}selected="selected"{/if}>New Zealand Dollar</option>
                                          <option value="PHP" {if $settings.settings_cart_currency_code == "PHP"}selected="selected"{/if}>Philippine Peso</option>
                                          <option value="PLN" {if $settings.settings_cart_currency_code == "PLN"}selected="selected"{/if}>Polish Zloty</option>
                                          <option value="GBP" {if $settings.settings_cart_currency_code == "GBP"}selected="selected"{/if}>Pound Sterling</option>
                                          <option value="SGD" {if $settings.settings_cart_currency_code == "SGD"}selected="selected"{/if}>Singapore Dollar</option>
                                          <option value="SEK" {if $settings.settings_cart_currency_code == "SEK"}selected="selected"{/if}>Swedish Krona</option>
                                          <option value="CHF" {if $settings.settings_cart_currency_code == "CHF"}selected="selected"{/if}>Swiss Franc</option>
                                          <option value="TWD" {if $settings.settings_cart_currency_code == "TWD"}selected="selected"{/if}>Taiwan New Dollar</option>
                                          <option value="THB" {if $settings.settings_cart_currency_code == "THB"}selected="selected"{/if}>Thai Baht</option>
                                          <option value="TRY" {if $settings.settings_cart_currency_code == "TRY"}selected="selected"{/if}>Turkish Lira</option>
                                          <option value="USD" {if $settings.settings_cart_currency_code == "USD" || !$settings.settings_cart_currency_code}selected="selected"{/if}>U.S. Dollar</option>
                                       </select>
                                    </div>
                                    <br />   
                                    <div class="clear">
                                       <label class="fl-space size-300">Currency Symbol:</label>
                                       <input name="settings_cart_currency_symbol" type="text" value="{if $settings.settings_cart_currency_symbol}{$settings.settings_cart_currency_symbol}{else}${/if}" size="5" class="form-control" />
                                    </div>
                                    <br />                                
                                        <div class="clear">
                                           <label class="fl-space size-300">Direct Seller Commission: (Put 0 if using Unilevel or Hybrid with Unilevel)</label> %
                                           <input name="settings_cart_direct_commission" type="text" value="{if $settings.settings_cart_direct_commission}{$settings.settings_cart_direct_commission}{else}0{/if}" size="5" class="form-control" />
                                        </div>
                                        <br />
                                      
                                    <div class="clear">
                                       <label class="fl-space size-300">Tax</label> %
                                          <input name="settings_cart_tax_percent" type="text" value="{if $settings.settings_cart_tax_percent}{$settings.settings_cart_tax_percent}{else}0{/if}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div id="more">
                                        {if $settings.settings_cart_affiliate_type eq 'unilevel' || $settings.settings_cart_affiliate_type eq 'forced' || substr_count($settings.settings_cart_affiliate_type, "hybrid")}
                                          <br />
                                        <strong>Level Commissions: </strong> (Put 0 on the unpaid levels)<br />
                                        <br />
                                        <div class="row">
                                        {foreach key=obj item=name from=$memberships}
                                              <div class="col-md-3">
                                                  <h2>{$name|replace:"_":" "}</h2>
                                                  {for $foo=1 to 3}
                                                  <div class="clear">
                                                     <label class="fl-space size-300">Level {$foo} Commission: (Percentage)</label> %
                                                     {capture assign=level}settings_cart_level_{$name}_{$foo}{/capture}
                                                     <input name="settings_cart_level_{$name}_{$foo}" type="text" value="{if $settings.$level}{$settings.$level}{else}0{/if}" size="5" class="form-control" />
                                                  </div>
                                                  <br />
                                                  {/for}  
                                              </div>
                                        {/foreach}
                                        </div>
                                        <br />
                                        <strong>Membership Earning Levels: </strong><br />(How many levels get paid an specific member based on his membership)<br />
                                        <br />
                                        {foreach key=obj item=name from=$memberships}
                                        <div class="form-field clear">
                                           <label for="textfieldx" class="fl-space size-300">{$name|replace:"_":" "} :</label>
                                           {capture assign=comm}{$name}_cart_levels{/capture}
                                           <input name="{$name}_cart_levels" type="text" value="{$settings.$comm}" size="5" class="form-control" />
                                        </div>
                                        {/foreach}
                                        {/if}
                                    </div>
                                 
                                 </div>
                              </div>
                              <div class="clear">
                                 <br><br>
                                 <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                 <p class="clean-padding">
                              </div>
                              <!-- /.form-field -->                                               
                           </form>
                        </div>
                     </div>
                     <!-- end of box-wrap -->
                  </div>
                  <!-- end of box-body -->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END -->       
<!-- Vendor scrits -->
{include file='views/admin/footer_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>

<script src="/assets/members/js/jquery.form.js"></script>
<script>
{literal}
   $(function () {
     
     $("#imgContainer").hover(function(){
      $('#imgChange').show();
    },function(){
      $('#imgChange').hide();
    });

      $(document).on('change', '#image_upload_file', function () {
    var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');
    
    $('#image_upload_form').ajaxForm({
      beforeSend: function() {
        progressBar.fadeIn();
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
      },
      uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
      },
      success: function(html, statusText, xhr, $form) {   
        obj = $.parseJSON(html);  
        if(obj.status){   
          var percentVal = '100%';
          bar.width(percentVal)
          percent.html(percentVal);
          $("#imgArea>img").prop('src',obj.image);  
            
        }else{
          alert(obj.error);
        }
      },
      complete: function(xhr) {
        progressBar.fadeOut();      
      } 
    }).submit();    
    
    });
   });
{/literal}   
</script>

{include file='views/admin/footer.tpl'}