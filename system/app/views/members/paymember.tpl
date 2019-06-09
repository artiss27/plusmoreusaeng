{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article>
			
             <h3>{$lang.upgrade_your_membership}!</h3>
             
             <p>- {$lang.proceed_to_complete_your_payment}:<br />
               <br />
               You Choose <strong>{$membership|replace:"_":" "}</strong> Membership</p>
               
               <br /><br />
               
               {$payment_button} <br />
               <br />
             	{$paybycheck}
             </p>
</article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
