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
               <h2 class="font-light m-b-xs">
                  Add Transaction
               </h2>
               <div class="main pagesize">
                  <!-- *** mainpage layout *** -->
                  <div class="main-wrap">
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
                     {/foreach}    
                     <div class="content-box">
                        <div class="box-body">
                           <div class="box-wrap clear">
                              <div class="columns clear bt-space15">
                                 <div class="col2-3">
                                 </div>
                              </div>
                              <!-- /.form-field -->	
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
{include file='footer.tpl'}
