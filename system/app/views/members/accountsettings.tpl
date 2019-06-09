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
               Communication Settings / <font color="green">Ajustes de Comunicacion</font>
            </h2>
            <small>Adjust the setting to receive emails / <font color="green">Ajuste los permisos para recibir comunicacion por email</font></small>
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
               {if $settings_edited eq 'y'}
               <p class="alert alert-success">
                  <strong>{$lang.settings_edited}</strong> {$lang.settings_edited_succesfully_to_database}/Los ajustes fueron modificados
               </p>
               <br />
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
                              <form role="form" id="form" method="post">
                                 <div class="form-group"> 
                                    <label class="col-sm-2 control-label"><br>Email from PlusMoreUsa <br><font color="green">Emails de PlusMoreUsa</label>
                                    <input class="form-control" type="checkbox" name="email_from_company" id="checkbox3" {if $settings.email_from_company eq "1"}checked="checked"{/if} />
                                 </div>
                                 <div class="form-group"> 
                                    <label class="col-sm-2 control-label">Sponsor's Emails <br><font color="green">Email del Patrocinador</font></label>
                                    <input class="form-control" type="checkbox" name="email_from_upline" id="checkbox4" {if $settings.email_from_upline eq "1"}checked="checked"{/if} />
                                 </div>
                             <div class="form-group"> 
                                    <label class="col-sm-2 control-label">{$lang.log_ip_access} / <font color="green">IP Accedidos</label>
                                    <input class="form-control" type="checkbox" name="log_ip" id="checkbox4" {if $settings.log_ip eq "1"}checked="checked"{/if} />
                                 </div>
                                 <div class="form-group"> 
                                    <label class="col-sm-2 control-label">{$lang.notify_account_changes} / <font color="green">Cambios en la Cuenta</label>
                                    <input class="form-control" type="checkbox" name="notify_changes" id="checkbox4" {if $settings.notify_changes eq "1"}checked="checked"{/if} />
                                 </div>
                                 <div class="form-group"> 
                                    <label class="col-sm-2 control-label">{$lang.display_name_on_website} / Mostrar Tu Nombre</label>
                                    <input class="form-control" type="checkbox" name="display_name" id="checkbox4" {if $settings.display_name eq "1"}checked="checked"{/if} />
                                 </div>
                                 <div class="form-group"> 
                                    <label class="col-sm-2 control-label">{$lang.display_email_on_website} / Mostrar Email en el Sitio</label>
                                    <input class="form-control" type="checkbox" name="display_email" id="checkbox4" {if $settings.display_email eq "1"}checked="checked"{/if} />
                                 </div> 
                                 <div class="form-group"> 
                                    <button name="save" type="submit" class="btn btn-sm btn-primary m-t-n-xs" value="submit">Save / Guardar</button>
                                 </div>
                                 &nbsp;
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
   $(function () {
   
   });
</script>
{include file='footer.tpl'}
