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
            Mis Referidos Directos
         </h2>
         <small>Invitados por mi directamente</small>
      </div>
   </div>
</div>
<div class="content animate-panel">
   {if !$data}
   No referidos aun
   {else}
   {foreach from=$data name=obj item=name}  
   {if ($smarty.foreach.obj.iteration-1) % 4 == 0}
   <div class="row">
      {/if}
      <div class="col-lg-3">
         <div class="hpanel hgreen contact-panel">
            <div class="panel-body">
	            <span class="label label-success pull-right">Nuevo</span>	
                {assign var=pic value=CoreHelp::getMemberProfilePic($name.ROW_MEMBER_ID, $name.ROW_GENDER)}
               <img alt="logo" class="img-circle m-b" src="{$pic}">
               <h3><a href="">{$name.ROW_FNAME} {$name.ROW_LNAME}</a></h3>
              <!-- <div class="text-muted font-bold m-b-xs"><img src="{$name.ROW_COUNTRY_FLAG}" style="width:16px;height:11px" /> {$name.ROW_COUNTRY_NAME}</div>-->
               <p>Usuario: <strong>{$name.ROW_USERNAME} </strong><br />
                 Membresia: <strong>{$name.ROW_MEMBERSHIP} </strong><br />
                 Fecha de Registro: <strong>{$name.ROW_REG} </strong><br />
                 {if $name.ROW_SKYPE}{$lang.skype}: <strong>{$name.ROW_SKYPE} </strong><br />{/if}
                 Genero: <strong>{$name.ROW_GENDER} </strong><br />
               </p>
            </div>
           <div class="panel-footer contact-footer">
               <div class="row">
                 <div class="col-md-4 border-right">
                      <!-- <div class="contact-stat"><span>Numero de Referidos : </span> <strong>{$name.ROW_REFERRER_YESTERDAY}</strong></div>
                  </div>
                  <div class="col-md-4 border-right">
                     <div class="contact-stat"><span>{$lang.referrals_today}: </span> <strong>{$name.ROW_REFERRER_TODAY}</strong></div>
                  </div>
                  <div class="col-md-4">
                     <div class="contact-stat"><span>{$lang.referrals_total}: </span> <strong>{$name.ROW_REFERRER_TOTAL}</strong></div>-->
                  </div>
               </div>
            </div>
         </div>
      </div>
      {if ($smarty.foreach.obj.iteration) % 4 == 0 or $smarty.foreach.obj.last}
   </div>
   {/if}
   {/foreach}
   {/if}                                                             
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