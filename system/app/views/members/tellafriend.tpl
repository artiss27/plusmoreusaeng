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
            {$lang.tell_a_friend}
         </h2>
         <small>{$lang.tell_a_friend}</small>
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
                           <form action='#' method='POST' name='form1'>
                              <table id="tell_friend" class="table table-striped table-bordered table-hover" style="width:50%">
                                 <tbody>
                                    <tr>
                                       <td align="center"><strong>{$lang.friend_name}</strong></td>
                                       <td align="center"><strong>{$lang.friend_email}</strong></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input name="name1" class="form-control" type="text" size="30" />
                                       </td>
                                       <td><input name="email1" class="form-control" type="text" size="30" /></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input name="name2" type="text" class="form-control" size="30" />
                                       </td>
                                       <td><input name="email2" class="form-control" type="text" size="30" /></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input name="name3" type="text" class="form-control" size="30" />
                                       </td>
                                       <td><input name="email3" class="form-control" type="text" size="30" /></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input name="name4" type="text" class="form-control" size="30" />
                                       </td>
                                       <td><input name="email4" class="form-control" type="text" size="30" /></td>
                                    </tr>
                                    <tr>
                                       <td>
                                          <input name="name5" type="text" class="form-control" size="30" />
                                       </td>
                                       <td><input name="email5" class="form-control" type="text" size="30" /></td>
                                    </tr>
                                 </tbody>
                              </table>
                              <br />
                              <label>{$lang.email_subject}: </label>
                                <input name="subject" type="text" class="form-control form-half" size="50" value="{$email.subject}" />
                              <br />
                              <br />
                               <textarea name="email_body" class="form-control form-half" cols="65" rows="15">{$email.message}</textarea>
                              <br /><input name='submit' type='submit' value=" Send " class="btn btn-sm btn-primary m-t-n-xs"  onClick="return confirm ('{$lang.send_emails}');">
                           </form><br /><br />
                           <strong>{$lang.replacements}:</strong><br />
                           <br />
                           {$email.tag_descr}
                           <br />
                           <br />
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
   $(function () {
    
    
   });
   
</script>
{include file='footer.tpl'}