{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article>
			
{if $smarty.request.msg eq '1'}
<div class="success msg">
				<strong>{$lang.denied}:</strong> {$lang.you_cant_edit_a_banner_that_dont_belong_to_you_request_saved}
			</div>
	
{elseif $smarty.request.msg eq '2'}  

<div class="success msg">
				{$lang.your_changes_have_been_sent_for_admin_approval}
			</div>    			
            
{elseif $smarty.request.msg eq '3'} 
<div class="success msg">
				{$lang.your_banner_has_been_updated}
			</div>   
            
{/if}            
            
            
            <h2>{$lang.banner_system}</h2>
            <br />

{include file='banners_header.tpl'}	            
            
            {$content}
				
		</article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
