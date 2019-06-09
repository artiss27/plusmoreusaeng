{include file='views/members/header.tpl'}
{include file='views/members/menu.tpl'}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/css/bootstrap-select.min.css">
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
         {include file='views/members/breadcrumb.tpl'}            
         <h2 class="font-light m-b-xs">
            {$plugin_lang.textads}
         </h2>
         <small>{$plugin_lang.textads}</small>
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
                           <form id="add_textad" action="" method="post" enctype="multipart/form-data">
                                     <input type="hidden" name="type" value="new" />
										<div class="form-body">
											<div class="note tile-title">
												<h4>{$plugin_lang.edit_campaign_id}: {$textad.id}</h4>
                                                <br />
	                                                <p>{$plugin_lang.ad_credits_balance}: <b>{$data.ad_credit_balance|floatval}</b></p>
											</div><br />
                                           
											<div class="form-group">
												<label>{$plugin_lang.campaign_title}</label>
                                                 <div class="input">																								
													 <input type="text" class="form-control" placeholder="{$plugin_lang.campaign_title}" name="campaign_title" value="{$textad.campaign_title}">	
                                                 </div>   											
											</div>
											 
											<div class="form-group">
												<label>{$plugin_lang.increase} {$plugin_lang.ad_credits_for_this_campaign}</label>	
                                                <div class="input">																						
													 <input type="text" class="form-control" placeholder="{$plugin_lang.amount}" name="ad_credits_for_this_campaign" value="0">												
                                                 </div>    
											</div>
											
                                            <div class="form-group">
												<label>{$plugin_lang.ad_credit_bid_per_click}, {$plugin_lang.minimum} <b>{$data.min_bid}</b> {$plugin_lang.recommended} <b>{$data.recommended_bid}</b></label>	
                                                <div class="input">																				
													 <input type="text" class="form-control" placeholder="{$plugin_lang.amount}" name="ad_credit_bid" value="{$textad.ad_credit_bid}">												
                                                 </div>    
											</div>
											 
                                            <div class="form-group">
												<label>{$plugin_lang.target_url}</label>	
                                                 <div class="input">																								
													 <input type="text" class="form-control" placeholder="{$plugin_lang.url}" name="target_url" value="{$textad.target_url}">												
                                                 </div>
											</div>		 
                                              
                                            <div class="form-group">
												<label>{$plugin_lang.headline}</label>	
                                                 <div class="input">																								
													 <input type="text" class="form-control" placeholder="{$plugin_lang.headline}" name="headline" value="{$textad.headline}" maxlength="25">												
                                                 </div>
											</div>  
                                            <div class="form-group">
												<label>{$plugin_lang.description1}</label>	
                                                 <div class="input">																								
													 <input type="text" class="form-control" placeholder="{$plugin_lang.description1}" name="description1" value="{$textad.description1}" maxlength="35">												
                                                 </div>
											</div>  
                                            <div class="form-group">
												<label>{$plugin_lang.description2}</label>	
                                                 <div class="input">																								
													 <input type="text" class="form-control" placeholder="{$plugin_lang.description2}" name="description2" value="{$textad.description2}" maxlength="35">												
                                                 </div>
											</div>                                                              
                                            <i class="fa"></i>	
                                           <div class="form-group">
												<label>{$plugin_lang.countries}</label>	
                                            <div class="form_input">
                                            <select name="countries[]" class="selectpicker" multiple  data-max-options="{$data.countries_max}" data-selected-text-format="count">
                                            <option value=''>{$plugin_lang.select_your_targeting_countries}</option>
                                            <option value='all' {if 'all'|in_array:$data.selected_countries}selected{/if}>{$plugin_lang.all_countries}</option>                                         
													{foreach key=obj item=country from=$data.countries} 
															<option value='{$country.code}' {if $country.code|in_array:$data.selected_countries}selected{/if}>{$country.name}</option>
													{/foreach}
															</select>
                                            </div>    
                                            </div>
                                            
                                         </div>
										  <i class="fa"></i>	
										<div class="form-actions">
											<button type="submit" class="btn btn-sm btn-primary m-t-n-xs">{$plugin_lang.edit}</button>											
										</div>
									</form><br /><br />                           
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
{include file='views/members/right_sidebar.tpl'}   
<!-- Vendor scrits -->
{include file='views/members/vendor_scripts.tpl'} 
<!-- App scripts -->
<script src="/assets/common/scripts/homer.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js"></script>
<script>
   $(function () {
   		$('.selectpicker').selectpicker();
   });
</script>
{include file='views/members/footer.tpl'}