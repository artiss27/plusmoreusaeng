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
            {$lang.announcements}</h2><font size="3" color="green">Anuncios</font>
    
       
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
            <p class="alert alert-danger">
               {assign var=message_var value=CoreHelp::flash('error')}
               {$message_var}
            </p>
            <br />
            {/if} 
            <div class="main pagesize">
               <!-- *** mainpage layout *** -->
               <div class="main-wrap">
                  <div class="content-box">
                     <div class="box-body">
                        <div class="box-wrap clear">
                           <table id="announcements" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                 	<th>#</th>
                                    <th>{$lang.date}/<font  color="green">Fecha</font></th>
                                    <th>{$lang.title}/<font  color="green">Titulo</font></th>
                                    <th>{$lang.description}/<font  color="green">Descripcion</font></th>
                                 </tr>
                              </thead>
                              <tbody>
                              {if !$list}
                              <tr>
                                    <td colspan="2">{$lang.no_result_found}</td>
                                 </tr>
                              {else}
                                 {foreach key=obj item=name from=$list}                
                                 <tr>
                                 	<td>{$name.id}</td>
                                    <td>{$name.date}</td>
                                    <td><a href="/members/announcement/&id={$name.id}" >{$name.title}</a></td>
                                    <td><a href="/members/announcement/&id={$name.id}" >{assign var=message_var value=CoreHelp::shortDescription($name.body, 100)}{$message_var}</a></td>
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
    	{if $list}$('#announcements').dataTable({
			"order": [[ 0, "desc" ]]
			});{/if}    
   });
   
</script>
{include file='footer.tpl'}