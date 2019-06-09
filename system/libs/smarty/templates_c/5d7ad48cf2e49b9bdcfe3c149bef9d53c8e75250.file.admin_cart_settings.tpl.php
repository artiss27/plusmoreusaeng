<?php /* Smarty version Smarty-3.0.8, created on 2019-06-07 10:35:31
         compiled from "system/app/plugins/cart/views/admin_cart_settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8094405765cfaa0639a1143-38160889%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d7ad48cf2e49b9bdcfe3c149bef9d53c8e75250' => 
    array (
      0 => 'system/app/plugins/cart/views/admin_cart_settings.tpl',
      1 => 1510244613,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8094405765cfaa0639a1143-38160889',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/hermes/walnaweb10a/b1543/pow.plusmoreusaengcom/htdocs/system/libs/smarty/plugins/modifier.replace.php';
?>﻿<?php $_template = new Smarty_Internal_Template('views/admin/header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template('views/admin/menu.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
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
            <?php if ($_SESSION['message']){?>
            <p class="alert alert-success">
               <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('message'), null, null);?>
               <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

            </p>
            <br />
            <?php }?> 
            <?php if ($_SESSION['error']){?>
            <?php $_smarty_tpl->tpl_vars['message_var'] = new Smarty_variable(CoreHelp::flash('error'), null, null);?>             
            <?php if (is_array($_smarty_tpl->getVariable('message_var')->value)){?>
            <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('message_var')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
            <p class="alert alert-danger">
               <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

            </p>
            <br />
            <?php }} ?> 
            <?php }else{ ?>
            <p class="alert alert-danger">
               <?php echo $_smarty_tpl->getVariable('message_var')->value;?>

            </p>
            <br />
            <?php }?>
            <?php }?> 
            <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
            <p class="alert alert-danger">
               <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

            </p>
            <br />
            <?php }} ?>  
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
                                        <div id="imgArea"><img widht="120" height="40" src="<?php echo $_smarty_tpl->getVariable('logo')->value;?>
">
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
                                       <option value="unilevel" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_affiliate_type']=='unilevel'){?>selected="selected"<?php }?>>Unilevel</option>
                                       <?php if ($_smarty_tpl->getVariable('settings')->value['affiliate_type']=='forced'){?><option value="forced" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_affiliate_type']=='forced'){?>selected="selected"<?php }?>>Forced Matrix</option><?php }?>
                                       <?php if ($_smarty_tpl->getVariable('settings')->value['affiliate_type']=='binary'){?><option value="binary" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_affiliate_type']=='binary'){?>selected="selected"<?php }?>>Binary</option><?php }?>
                                       <?php if (substr_count($_smarty_tpl->getVariable('settings')->value['affiliate_type'],"hybrid")){?> <option value="<?php echo $_smarty_tpl->getVariable('settings')->value['affiliate_type'];?>
" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_affiliate_type']==$_smarty_tpl->getVariable('settings')->value['affiliate_type']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('settings')->value['affiliate_type'];?>
</option><?php }?>
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
                                       <option value="inside" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_type']=='inside'){?>selected="selected"<?php }?>>Backoffice Store Only</option>
                                       <option value="replicated" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_type']=='replicated'){?>selected="selected"<?php }?>>Replicated Store Only</option>
                                       <option value="both" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_type']=='both'){?>selected="selected"<?php }?>>Both</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">If using Replicated Stores, force customers to become affiliates or process purchases with Paypal within Replicated Store:</label> 
                                       <select id="replicated_cart_type" class="form-control required" name="replicated_cart_type">
                                       <option value="force_associate" <?php if ($_smarty_tpl->getVariable('settings')->value['replicated_cart_type']=='force_associate'){?>selected="selected"<?php }?>>Force to become affiliates</option>
                                       <option value="process_as_customers_with_paypal" <?php if ($_smarty_tpl->getVariable('settings')->value['replicated_cart_type']=='process_as_customers_with_paypal'){?>selected="selected"<?php }?>>Process purchases as customers with Paypal</option>     
                                       </select>
                                    </div>
                                    <br />                                    
                                     <div class="clear">
                                       <label class="fl-space size-300">Paypal Email: (Only needed if using Replicated Stores)</label>
                                       <input name="settings_cart_paypal_email" type="text" value="<?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_paypal_email']){?><?php echo $_smarty_tpl->getVariable('settings')->value['settings_cart_paypal_email'];?>
<?php }else{ ?>name@domain.com<?php }?>" size="5" class="form-control" />
                                    </div>
                                    <br /> 
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">If using Replicated Stores with Paypal, use Sanbox mode ?:</label> 
                                       <select id="settings_cart_paypal_sandbox" class="form-control required" name="settings_cart_paypal_sandbox">
                                       <option value="yes" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_paypal_sandbox']=='yes'){?>selected="selected"<?php }?>>Yes</option>
                                       <option value="no" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_paypal_sandbox']=='no'){?>selected="selected"<?php }?>>No</option>     
                                       </select>
                                    </div>
                                    <br />                                                                      
                                    <div class="clear">
                                       <label class="fl-space size-300">PayPal Currency Code:</label>
                                       <select name="settings_cart_currency_code" class="form-control required">
                                          <option value="" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']==''){?>selected="selected"<?php }?>>Select Currency</option>
                                          <option value="AUD" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="AUD"){?>selected="selected"<?php }?>>Australian Dollar</option>
                                          <option value="BRL" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="BRL"){?>selected="selected"<?php }?>>Brazilian Real </option>
                                          <option value="CAD" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="CAD"){?>selected="selected"<?php }?>>Canadian Dollar</option>
                                          <option value="CZK" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="CZK"){?>selected="selected"<?php }?>>Czech Koruna</option>
                                          <option value="DKK" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="DKK"){?>selected="selected"<?php }?>>Danish Krone</option>
                                          <option value="EUR" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="EUR"){?>selected="selected"<?php }?>>Euro</option>
                                          <option value="HKD" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="HKD"){?>selected="selected"<?php }?>>Hong Kong Dollar</option>
                                          <option value="HUF" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="HUF"){?>selected="selected"<?php }?>>Hungarian Forint </option>
                                          <option value="ILS" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="ILS"){?>selected="selected"<?php }?>>Israeli New Sheqel</option>
                                          <option value="JPY" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="JPY"){?>selected="selected"<?php }?>>Japanese Yen</option>
                                          <option value="MYR" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="MYR"){?>selected="selected"<?php }?>>Malaysian Ringgit</option>
                                          <option value="MXN" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="MXN"){?>selected="selected"<?php }?>>Mexican Peso</option>
                                          <option value="NOK" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="NOK"){?>selected="selected"<?php }?>>Norwegian Krone</option>
                                          <option value="NZD" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="NZD"){?>selected="selected"<?php }?>>New Zealand Dollar</option>
                                          <option value="PHP" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="PHP"){?>selected="selected"<?php }?>>Philippine Peso</option>
                                          <option value="PLN" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="PLN"){?>selected="selected"<?php }?>>Polish Zloty</option>
                                          <option value="GBP" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="GBP"){?>selected="selected"<?php }?>>Pound Sterling</option>
                                          <option value="SGD" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="SGD"){?>selected="selected"<?php }?>>Singapore Dollar</option>
                                          <option value="SEK" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="SEK"){?>selected="selected"<?php }?>>Swedish Krona</option>
                                          <option value="CHF" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="CHF"){?>selected="selected"<?php }?>>Swiss Franc</option>
                                          <option value="TWD" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="TWD"){?>selected="selected"<?php }?>>Taiwan New Dollar</option>
                                          <option value="THB" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="THB"){?>selected="selected"<?php }?>>Thai Baht</option>
                                          <option value="TRY" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="TRY"){?>selected="selected"<?php }?>>Turkish Lira</option>
                                          <option value="USD" <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']=="USD"||!$_smarty_tpl->getVariable('settings')->value['settings_cart_currency_code']){?>selected="selected"<?php }?>>U.S. Dollar</option>
                                       </select>
                                    </div>
                                    <br />   
                                    <div class="clear">
                                       <label class="fl-space size-300">Currency Symbol:</label>
                                       <input name="settings_cart_currency_symbol" type="text" value="<?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_currency_symbol']){?><?php echo $_smarty_tpl->getVariable('settings')->value['settings_cart_currency_symbol'];?>
<?php }else{ ?>$<?php }?>" size="5" class="form-control" />
                                    </div>
                                    <br />                                
                                        <div class="clear">
                                           <label class="fl-space size-300">Direct Seller Commission: (Put 0 if using Unilevel or Hybrid with Unilevel)</label> %
                                           <input name="settings_cart_direct_commission" type="text" value="<?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_direct_commission']){?><?php echo $_smarty_tpl->getVariable('settings')->value['settings_cart_direct_commission'];?>
<?php }else{ ?>0<?php }?>" size="5" class="form-control" />
                                        </div>
                                        <br />
                                      
                                    <div class="clear">
                                       <label class="fl-space size-300">Tax</label> %
                                          <input name="settings_cart_tax_percent" type="text" value="<?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_tax_percent']){?><?php echo $_smarty_tpl->getVariable('settings')->value['settings_cart_tax_percent'];?>
<?php }else{ ?>0<?php }?>" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div id="more">
                                        <?php if ($_smarty_tpl->getVariable('settings')->value['settings_cart_affiliate_type']=='unilevel'||$_smarty_tpl->getVariable('settings')->value['settings_cart_affiliate_type']=='forced'||substr_count($_smarty_tpl->getVariable('settings')->value['settings_cart_affiliate_type'],"hybrid")){?>
                                          <br />
                                        <strong>Level Commissions: </strong> (Put 0 on the unpaid levels)<br />
                                        <br />
                                        <div class="row">
                                        <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('memberships')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                              <div class="col-md-3">
                                                  <h2><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['name']->value,"_"," ");?>
</h2>
                                                  <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int)ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? 3+1 - (1) : 1-(3)+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0){
for ($_smarty_tpl->tpl_vars['foo']->value = 1, $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++){
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration == 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration == $_smarty_tpl->tpl_vars['foo']->total;?>
                                                  <div class="clear">
                                                     <label class="fl-space size-300">Level <?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
 Commission: (Percentage)</label> %
                                                     <?php ob_start(); ?>settings_cart_level_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
<?php  $_smarty_tpl->assign('level', ob_get_contents()); Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>
                                                     <input name="settings_cart_level_<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
" type="text" value="<?php if ($_smarty_tpl->getVariable('settings')->value[$_smarty_tpl->getVariable('level')->value]){?><?php echo $_smarty_tpl->getVariable('settings')->value[$_smarty_tpl->getVariable('level')->value];?>
<?php }else{ ?>0<?php }?>" size="5" class="form-control" />
                                                  </div>
                                                  <br />
                                                  <?php }} ?>  
                                              </div>
                                        <?php }} ?>
                                        </div>
                                        <br />
                                        <strong>Membership Earning Levels: </strong><br />(How many levels get paid an specific member based on his membership)<br />
                                        <br />
                                        <?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['obj'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('memberships')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
 $_smarty_tpl->tpl_vars['obj']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
                                        <div class="form-field clear">
                                           <label for="textfieldx" class="fl-space size-300"><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['name']->value,"_"," ");?>
 :</label>
                                           <?php ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
_cart_levels<?php  $_smarty_tpl->assign('comm', ob_get_contents()); Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>
                                           <input name="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
_cart_levels" type="text" value="<?php echo $_smarty_tpl->getVariable('settings')->value[$_smarty_tpl->getVariable('comm')->value];?>
" size="5" class="form-control" />
                                        </div>
                                        <?php }} ?>
                                        <?php }?>
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
<?php $_template = new Smarty_Internal_Template('views/admin/footer_scripts.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?> 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>

<script src="/assets/members/js/jquery.form.js"></script>
<script>

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
   
</script>

<?php $_template = new Smarty_Internal_Template('views/admin/footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>