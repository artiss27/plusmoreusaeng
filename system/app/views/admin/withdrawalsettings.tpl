{include file='header.tpl'}
{include file='menu.tpl'}
<div id="wrapper">
<div class="content animate-panel">
   <div class="row">
      <div class="normalheader transition animated fadeIn">
         <div class="hpanel">
            <div class="panel-body">
               <a class="small-header-action" href="">
                  <div class="clip-header">
                     <i class="fa fa-arrow-up"></i>
                  </div>
               </a>
               <div id="hbreadcrumb" class="pull-right m-t-lg">
                  <ol class="hbreadcrumb breadcrumb">
                  </ol>
               </div>
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
               <div class="alert alert-success">
                  <p><strong>{$error@key}</strong> {$error}</p>
               </div>
               {/foreach} <br />
               <h2 class="font-light m-b-xs">
                  Withdrawal Settings
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
                    
                     
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <form action="#" method="post" class="validate-form form bt-space15">
                                 <div class="columns clear bt-space15">
                                    <div class="col2-3">
                                       <br>
                                       <div class="clear">
                                          <label for="textfield2" class="fl-space size-300">Min Amount for Withdrawal :</label>
                                          $
                                          <input name="commission_cashout_sum" type="text" value="{$settings.commission_cashout_sum}" class="form-control" size="5" />
                                       </div>
                                       <br />
                                       <div class="clear">
                                          <label for="textfield2" class="fl-space size-300">Withdrawal Admin Fee Percent:</label>
                                          %                                
                                          <input name="commission_cashout_fee" type="text" value="{$settings.commission_cashout_fee}" size="5" class="form-control" />
                                       </div>
                                       <br /><br />
                                       <p>Open Withdrawals on this days
                                       <br><br>
                                       <div class="form-group"> 
                                        <label class="col-sm-2 control-label">Monday</label>
                                        <input class="form-control" type="checkbox" name="withdrawal_open_mon" {if $settings.withdrawal_open_mon eq "1"}checked="checked"{/if} />
                                       </div>
                                       
                                       <div class="form-group"> 
                                        <label class="col-sm-2 control-label">Tuesday</label>
                                        <input class="form-control" type="checkbox" name="withdrawal_open_tue" {if $settings.withdrawal_open_tue eq "1"}checked="checked"{/if} />
                                       </div>
                                       
                                       <div class="form-group"> 
                                        <label class="col-sm-2 control-label">Wednesday</label>
                                        <input class="form-control" type="checkbox" name="withdrawal_open_wed" {if $settings.withdrawal_open_wed eq "1"}checked="checked"{/if} />
                                       </div>
                                       
                                       <div class="form-group"> 
                                        <label class="col-sm-2 control-label">Thursday</label>
                                        <input class="form-control" type="checkbox" name="withdrawal_open_thu" {if $settings.withdrawal_open_thu eq "1"}checked="checked"{/if} />
                                       </div>
                                       
                                       <div class="form-group"> 
                                        <label class="col-sm-2 control-label">Friday</label>
                                        <input class="form-control" type="checkbox" name="withdrawal_open_fri" {if $settings.withdrawal_open_fri eq "1"}checked="checked"{/if} />
                                       </div>
                                      
                                       <div class="form-group"> 
                                        <label class="col-sm-2 control-label">Saturday</label>
                                        <input class="form-control" type="checkbox" name="withdrawal_open_sat" {if $settings.withdrawal_open_sat eq "1"}checked="checked"{/if} />
                                       </div>
                                       
                                       <div class="form-group"> 
                                        <label class="col-sm-2 control-label">Sunday</label>
                                        <input class="form-control" type="checkbox" name="withdrawal_open_sun" {if $settings.withdrawal_open_sun eq "1"}checked="checked"{/if} />
                                       </div>
                                       <br />
                                    </div>
                                 </div>
                                 <div class="form-field clear">
                                    <input type="hidden" class="button red fr" name="bnsubmit" value="Save" />
                                    <button type="button" class="btn btn-primary" onclick='this.form.submit();'>Save changes</button> 
                                 </div>
                                 <!-- /.form-field -->																								
                              </form>
                               
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
   </div>
</div>
{include file='footer_scripts.tpl'}
<script type="text/javascript">
   function AjaxFunction()
   {
   var httpxml;
   try
     {
     // Firefox, Opera 8.0+, Safari
     httpxml=new XMLHttpRequest();
     }
   catch (e)
     {
     // Internet Explorer
   try
    		{
   httpxml=new ActiveXObject("Msxml2.XMLHTTP");
   		}
   catch (e)
   	{
   try
   		{
   	httpxml=new ActiveXObject("Microsoft.XMLHTTP");
   		 }
   		catch (e)
   	{
   alert("Your browser does not support AJAX!");
   return false;
     		}
   		}
   }
   function stateck() 
      {
      if(httpxml.readyState==4)
      {
   		//alert(''+httpxml.responseText+'');
		swal("Response", ''+httpxml.responseText+'', "success");
        }
      }
   //email =  prompt ("Enter the email to send the test", "");
   swal({   
   title: "",
   text: "Enter the email to send the test:",   
   type: "input",   
   showCancelButton: true,   
   closeOnConfirm: false,   
   animation: "slide-from-top",   
   inputPlaceholder: "Email Address" }, 
   function(inputValue){   
   if (inputValue === false) return false;      
   if (inputValue === "") {     
   	swal.showInputError("You need to write the email!");     
	return false   
	}  
	var url="/admin/testmail/";
   	url=url+"&email="+inputValue;
  	httpxml.onreadystatechange=stateck;
   	httpxml.open("GET",url,true);
   	httpxml.send(null);
	
	 });
   
     }
</script>
{include file='footer.tpl'}