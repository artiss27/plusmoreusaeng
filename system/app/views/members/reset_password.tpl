{include file='header.tpl'}
{include file='menu.tpl'}
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
         {include file='breadcrumb.tpl'}            
         <h2 class="font-light m-b-xs">
            {$lang.account}
         </h2>
         <small>{$lang.edit_your_account_profile}</small>
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
            {if $smarty.session.errors}
            {assign var=errors value=CoreHelp::flash('errors')}
            {foreach $errors as $error}
            <p class="alert alert-danger">
               {$error}
            </p>
            <br />            
            {/foreach} 
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
                           <form role="form" id="form" method="post">
                              <fieldset>
                                 <legend>{$lang.reset_password}</legend>
                                 <div class="form-group">                                      
                                    <label for="name">{$lang.password}</label>
                                    <input type="password" name="password" value="" class="form-control form-half" />
                                 </div>
                                 <div class="form-group">  
                                    <label for="name">{$lang.confirm_password} :</label>
                                    <input type="password" name="password2" value=""  class="form-control form-half" />
                                 </div><p>&nbsp;</p>
                                 <div class="form-group">  
                                    <label for="name">{$lang.current_password} :</label>
                                    <input type="password" name="current_password"  class="form-control form-half" />
                                 </div>
                                 <div class="form-group">  
                                    <label for="name">Security Token :</label> 
                                    <input type="text" name="token" value="" class="form-control form-half" /> <div id="modal"><a id="get_token" class="btn btn-sm m-r-5">Request Security Token to Email</a></div>
                                    
                                 </div>
                              </fieldset>
                              <div class="buttons">
                                    <button name="save" type="submit" class="btn btn-sm btn-primary m-t-n-xs" value="submit">{$lang.save}</button>
                              </div> 
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
<!-- Right sidebar -->
{include file='right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script>
{literal}
   $(function () {
    	jQuery('#get_token').click(function(event){
			id = 1;
			jQuery('#modal').html('processing...');
			jQuery.post("/members/sendtoken", {id: id}, function(result) { 
				jQuery('#modal').html('');
         		if (result == "done") 
         		{
					alert('Token sent to {/literal}{$profile.email}{literal}');
					return false;
				}
				else 
         		{
					alert(result);
					return false;
				}
			});
    
  	 	});
   
   });
{/literal}   
   
</script>
{include file='footer.tpl'}