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
            Publicidades Para Tus Redes Sociales
         </h2>
         <h5>Utiliza estos anuncios o imágenes en tu red sociales e incrementa tus referidos.</small><br><br><br><h5>Instrucciones</h5><small>• Haga clic derecho en la imagen con el mouse para abrir el menú.<br>• Copia o guarda la imagen en tu computadora como una foto. <br>• Entra a tu cuenta de red social favorita.<br>• Descarga la imagen en tu cuenta de Facebook / Instagram como si fuera una foto normal.<br>• Agregue tu URL de referir junto con tu nombre o ID de su miembro.<br> • Comparte y ganas ayudando a tus referidos a conseguir mas.
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
                           <table id="banners" class="table table-striped table-bordered table-hover">
                           <tbody>
                           {if $banners}
                              {foreach key=obj item=name from=$banners}
                              <tr>
                                 <td>
                                    <img src="/media/images/{$name.banner_name}" /><br />
                                    {$lang.size}: {$name.banner_size} <br />
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <textarea class="form-control" name="textarea" id="textarea" cols="85" rows="2"> {$site_url}?u={$username} </textarea>
                                 </td>
                              </tr>
                              <tr>
                                 <td>&nbsp;</td>
                              </tr>
                              {/foreach}    
                            {else}
                            	<tr><td>{$lang.no_result_found}</td></tr>
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
   $(function () {
    	$('#banners').dataTable();    
   });
   
</script>
{include file='footer.tpl'}