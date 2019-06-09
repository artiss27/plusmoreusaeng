{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
		  <article>
          
{if $transaction eq 'y'}
<div class="success msg">
				<strong>{$lang.pif_transaction_done}:</strong> {$lang.your_transaction_was_succesfully_recorded_on_the_system}
			</div>
				
{/if}

{if $transaction_error eq 'y'}
<div class="error msg">
				<strong>{$lang.pif_transaction_error}:</strong> {$lang.your_dont_have_enough_comissions_to_buy_selected_pif_amount}
			</div>
				
{/if}

{if $transaction_error_external eq 'y'}
<div class="error msg">
				<strong>{$lang.pif_transaction_error}:</strong> {$lang.your_transaction_was_cancelled}
			</div>
				
{/if}
         
			<h2>{$lang.pif_system}</h2>
			<p><br />
		    {$lang.pif_available} : <strong>{$pif_available}</strong></p>
			<p>{$lang.pif_placed} : <strong>{$pif_placed}</strong></p>
			<p><a href="/members/mypendings">{$lang.view_my_pending_members}</a></p>
			<p><br />
			  <br />
		    {$lang.commisions_on_your_account_right_now}: <strong>{$lang.monetary}{$total_cash}</strong></p>
			<p>- {$lang.buy_pif_using_my_commisions} : (<strong>{$lang.monetary}{$pif_price}</strong>) {$lang.each}.<br />
		
		    
			<form id="form1" name="form1" method="post" action="">
            
            {$lang.how_many_pif} : 
		      <label for="textfield"></label>
		      <input name="ump" type="text" id="textfield" size="4" maxlength="2" />
			  <input type="submit" name="buyump" id="button" value=" {$lang.buy} " />
			</form> 
			</p>
			<br />
		    <br />
		    - {$lang.buy_pif_using_payment_processor} : (<strong>{$lang.monetary}{$pif_price}</strong>) each.
		    <br />
		    <br />
<form id="form1" name="form1" method="post" action="/members/buyump/">
            
          {$lang.how_many_pif} : 
	      <label for="textfield"></label>
		      <input name="ump" type="text" id="textfield" size="4" maxlength="2" />
			  <input type="submit" name="buyumpx" id="button" value=" {$lang.buy} " />
			</form> 
<br />
<br />
</p>
            * {$lang.pif_pay_it_forward}
          </article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
