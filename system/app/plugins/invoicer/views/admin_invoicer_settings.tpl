{include file='views/admin/header.tpl'}
{include file='views/admin/menu.tpl'}
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
            Invoice Settings
         </h2>
         <small>Invoice Settings</small>
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
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <form action="" method="post" class="validate-form form bt-space15" enctype="multipart/form-data">
                           {if $settings.invoice_logo}<img width="200" src="/media/images/{$settings.invoice_logo}" /><br /><br />{/if}
                              <div class="columns clear bt-space15">
                                 <div class="col2-3">
                                    <div class="form-field clear"></div>                                    
                                    <div class="form-group">
                                    <label>Upload Invoice Company Logo</label>	
                                    (Gif, Png, Jpg)
                                   	 	<div class="form_input">
                                       		<input type="file" name="invoice_logo" id="invoice_logo" />
                                    	</div>
                                 	</div>
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Email Invoices :</label> 
                                       <select id="email_invoice" class="form-control required" name="email_invoice">
                                       <option value="yes" {if $settings.email_invoice eq 'yes'}selected="selected"{/if}>Yes</option>
                                       <option value="no" {if $settings.email_invoice eq 'no'}selected="selected"{/if}>No</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Language :</label> 
                                       <select id="invoice_language" class="form-control required" name="invoice_language">
                                       <option value="en" {if $settings.invoice_language eq 'en'}selected="selected"{/if}>English</option>
                                       <option value="de" {if $settings.invoice_language eq 'de'}selected="selected"{/if}>German</option>  
                                       <option value="es" {if $settings.invoice_language eq 'es'}selected="selected"{/if}>Spanish</option>  
                                       <option value="fr" {if $settings.invoice_language eq 'fr'}selected="selected"{/if}>French</option>  
                                       <option value="it" {if $settings.invoice_language eq 'it'}selected="selected"{/if}>Italian</option>     
                                       </select>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Main Color :</label>
                                       <input name="invoice_color" type="text" size="5" id="custom" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">VAT% (Included in prices, except on Shopping Cart):</label>
                                       <input name="invoice_vat" type="text" value="{$settings.invoice_vat}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                      <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company Name :</label>
                                       <input name="invoice_company" type="text" value="{$settings.invoice_company}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company Address :</label>
                                       <input name="invoice_company_address" type="text" value="{$settings.invoice_company_address}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company City :</label>
                                       <input name="invoice_company_city" type="text" value="{$settings.invoice_company_city}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company State :</label>
                                       <input name="invoice_company_state" type="text" value="{$settings.invoice_company_state}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Company Country :</label>
                                       <input name="invoice_company_country" type="text" value="{$settings.invoice_company_country}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Footer Title:</label>
                                       <input name="invoice_footer_title" type="text" value="{$settings.invoice_footer_title}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Footer Description:</label>
                                       <textarea name="invoice_footer_description" class="form-control">{$settings.invoice_footer_description|replace:'\r\n':"\n"}</textarea>
                                    </div>
                                    <br />
                                    <div class="clear">
                                       <label for="textfield" class="fl-space size-300">Invoice Footer Company Url:</label>
                                       <input name="invoice_footer_url" type="text" value="{$settings.invoice_footer_url}" size="5" class="form-control" />
                                    </div>
                                    <br />
                                 </div>
                              </div>
                              <div class="form-field clear">
                                 <br />
                                 <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                 <br />
                                 </p> 
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
<script src="/assets/common/scripts/spectrum.js"></script>
<link rel='stylesheet' href="/assets/common/styles/spectrum.css" />
<script>
   $(function () {
   		$("#custom").spectrum({
    		color: "{$settings.invoice_color}",
			preferredFormat: "hex"
		});
   });
</script>
{include file='views/admin/footer.tpl'}