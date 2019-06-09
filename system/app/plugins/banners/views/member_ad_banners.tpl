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
            {$lang.banners}
         </h2>
         <small>{$lang.banners}</small>
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
            {foreach key=obj item=error from=$message_var} 
            <p class="alert alert-danger">
               {$plugin_lang.$obj} : {$lang.$error}
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
                        <a href="#add_banner">{$plugin_lang.create_new_campaign}</a><br /><br />
                           <table id="banners" class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th>{$plugin_lang.id}</th>
                                    <th>{$plugin_lang.date}</th>
                                    <th>{$plugin_lang.campaign_name}</th>
                                    <th>{$plugin_lang.credits_placed}</th>
                                    <th>{$plugin_lang.credits_used}</th>
                                    <th>{$plugin_lang.ad_credit_bid}</th>
                                    <th>{$plugin_lang.banner_size}</th>
                                    <th>{$plugin_lang.impressions}</th>
                                    <th>{$plugin_lang.clicks}</th>
                                    <th>{$plugin_lang.approved}</th>
                                    <th>{$plugin_lang.status}</th>
                                    <th width="200">{$plugin_lang.actions}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 {if !$banners}
                                 <tr>
                                    <td colspan="12">{$lang.no_result_found}</td>
                                 </tr>
                                 {else}
                                 {foreach key=obj item=banner from=$banners} 
                                 <tr>
                                    <td>{$banner.id}</td>
                                    <td>{$banner.created_at}</td>
                                    <td>{$banner.campaign_title}</td>
                                    <td>{$banner.ad_credit_placed|floatval}</td>
                                    <td>{$banner.ad_credit_used|floatval}</td>
                                    <td>{$banner.ad_credit_bid|floatval}</td>
                                    <td>{$banner.banner_size}</td>
                                    <td>{$banner.total_views}</td>
                                    {assign var=hash value=CoreHelp::encrypt($banner.id)}
                                    <td><a href="/plugins/banners/manager/bannertrack/&hash={$hash}">{$banner.total_clicks}</a></td>
                                    <td>{if $banner.approved == 1} 
                                    		<span class="label label-sm label-success">{$plugin_lang.yes}</span> 
                                    	{else} 
                                       		{if $banner.approved == 1} 
                                            	<span class="label label-sm label-danger">{$plugin_lang.no}</span> 
                                            {else} 
                                       			<span class="label label-sm label-warning">{$plugin_lang.waiting}</span>
                                            {/if}
                                        {/if}
                                    </td>
                                    <td>{if $banner.status == 1}
                                    		<span class="label label-sm label-success">{$plugin_lang.active}</span>
                                        {else}
                                       		<span class="label label-sm label-danger">{$plugin_lang.paused}</span>
                                       {/if}
                                    </td>
                                    <td>{if $banner.status == 1}
                                    		<a href="/plugins/banners/manager/banners/&pause={$hash}" class="btn btn-sm m-r-5">{$plugin_lang.pause}</a>
                                        {else}    
                                       		<a href="/plugins/banners/manager/banners/&activate={$hash}" class="btn btn-sm m-r-5">{$plugin_lang.activate}</a>
                                        {/if}                                              
                                       <a href="/plugins/banners/manager/banners/&edit={$hash}" class="btn btn-sm m-r-5">{$plugin_lang.edit}</a>
                                       <a onclick="return confirm('{$plugin_lang.are_you_sure}');" href="/plugins/banners/manager/banners/&delete={$hash}" class="btn btn-sm m-r-5">{$plugin_lang.delete}</a>
                                    </td>
                                 </tr>
                                 {/foreach}   								
                                 {/if}
                              </tbody>
                           </table>
                           <br /><br />
                           <form id="add_banner" action="" method="post" enctype="multipart/form-data">
                                     <input type="hidden" name="type" value="new" />
										<div class="form-body">
											<div class="note tile-title">
												<h4>{$plugin_lang.create_new_campaign}</h4>
                                                <br />
	                                                <p>{$plugin_lang.ad_credits_balance}: <b>{$data.ad_credit_balance|floatval}</b></p>
											</div><br />
                                           
											<div class="form-group">
												<label>{$plugin_lang.campaign_title}</label>
                                                 <div class="input">																								
													 <input type="text" class="form-control" placeholder="{$plugin_lang.campaign_title}" name="campaign_title" value="{$smarty.session.old.campaign_title}">	
                                                 </div>   											
											</div>
											 
											<div class="form-group">
												<label>{$plugin_lang.ad_credits_for_this_campaign}</label>	
                                                <div class="input">																						
													 <input type="text" class="form-control" placeholder="{$plugin_lang.amount}" name="ad_credits_for_this_campaign" value="{$smarty.session.old.ad_credits_for_this_campaign}">												
                                                 </div>    
											</div>
											
                                            <div class="form-group">
												<label>{$plugin_lang.ad_credit_bid_per_click}, {$plugin_lang.minimum} <b>{$data.min_banner_bid}</b> {$plugin_lang.recommended} <b>{$data.recommended_bid}</b></label>	
                                                <div class="input">																				
													 <input type="text" class="form-control" placeholder="{$plugin_lang.amount}" name="ad_credit_bid" value="{$smarty.session.old.ad_credit_bid}">												
                                                 </div>    
											</div>
											 
                                            <div class="form-group">
												<label>{$plugin_lang.target_url}</label>	
                                                 <div class="input">																								
													 <input type="text" class="form-control" placeholder="{$plugin_lang.url}" name="target_url" value="{$smarty.session.old.target_url}">												
                                                 </div>
											</div>
											 
                                            <div class="form-group">
												<label>{$plugin_lang.select_your_banner_size}</label>	
                                            <div class="form_input"><select class="form-control" name="banner_size">
													{foreach key=obj item=banner from=$data.banner_sizes} 
															<option value="{$banner.width}x{$banner.height}">{$banner.width}x{$banner.height}</option>
													{/foreach}  
															</select>
                                            </div>    
                                            </div>  
                                            <div class="form-group">
												<label>{$plugin_lang.upload_banner_image}</label>	
												(Gif, Png, Jpg)
                                                <div class="form_input">
                                            	<input type="file" name="banner_image" id="banner_image" />
                                            </div>    
                                            </div>                                                         
                                            <i class="fa"></i>	
                                           <div class="form-group">
												<label>{$plugin_lang.countries} {$data.max_banner_countries}</label>	
                                            <div class="form_input">
                                            <select name="countries[]" class="selectpicker" multiple  data-max-options="{$data.max_banner_countries}" data-selected-text-format="count">
                                            <option value=''>{$plugin_lang.select_your_targeting_countries}</option>
                                            <option value='all' selected>{$plugin_lang.all_countries}</option>                                         
													{foreach key=obj item=country from=$data.countries} 
															<option value='{$country.code}'>{$country.name}</option>
													{/foreach}
															</select>
                                            </div>    
                                            </div>
                                            
                                         </div>
										  <i class="fa"></i>	
										<div class="form-actions">
											<button type="submit" class="btn btn-sm btn-primary m-t-n-xs">{$plugin_lang.create}</button>											
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
   $(document).ready( function() {  
   		{if $banners}$('#banners').dataTable();{/if}   
	 	$('.selectpicker').selectpicker();
   });
</script>

{include file='views/members/footer.tpl'}