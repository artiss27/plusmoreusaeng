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
            Pending Guests / <font color="green">Invitados Pendientes
         </font></h2>
      
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
               <strong>{$lang.settings_edited}/<font color="green">Configuracion Editada</font></strong> {$lang.settings_edited_succesfully_to_database}/<font size="2" color="green">configuración editada con éxito a la base de datos</font>
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
                           <table id="pending_referrers" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                   <th>Date Invited / <font color="green">Fecha de Invitación</th>
                                    <!--<th>User / <font color="green">Usuario (No. de ID)</font></th>-->
                                    <th>Name / <font color="green">Nombre</font></th>
                                    <!--<th>E-mail</th>
                                    <th>Skype</th>-->
                                    <th>Results / <font color="green">Resultados</font></th>
                                 </tr>
                              </thead>
                              <tbody>
                              {if !$data}
                              <tr>
                                    <td colspan="6">{$lang.no_result_found}/<font color="green">No Resultados Encontrados</font></td>
                                 </tr>
                              {else}
                                 {foreach key=obj item=name from=$data}   
                                 <tr>
                                  <td>&nbsp;{$name.reg_date|date_format}</td>
                                   <!-- <td>&nbsp;{$name.username} (#{$name.member_id})</td>-->
                                    <td>&nbsp;{$name.first_name} {$name.last_name}</td>
                                   <!--<td>&nbsp;{$name.email}</td>
                                    <td>&nbsp;{$name.skype}</td>-->
                                    <td>&nbsp;Pending / <font color="green">Pendientes</font></td>
                                 </tr>
                                 {/foreach}
                              {/if}   
                              </tbody>
                           </table>
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
     $(document).ready( function() {  
    	{if $data}$('#pending_referrers').dataTable();{/if}    
   });
   
   
</script>
{include file='footer.tpl'}
