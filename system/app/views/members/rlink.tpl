{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article>
				<h1>{$lang.account}</h1>
                
				<h2>{$lang.referral_link}</h2>
<form>
				  <fieldset>
				<legend> {$lang.link} </legend>
					 <p><b>{$rlink}</b> <br /><br /><a href="{$rlink}" target="_blank">{$lang.test_link}</a><br />
					   <br />
					   <br />
					   * {$lang.browser_cookie_never_expires}
                     </p> 
					</fieldset>
</form>					

				
			</article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
