{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
		  <article>
          
{if $transaction eq 'y'}
<div class="success msg">
				<strong>{$lang.upgrade_transaction_done}:</strong> {$lang.your_transaction_was_succesfully_recorded_on_the_system}
			</div>
				
{/if}

{if $transaction_error eq 'y'}
<div class="error msg">
				<strong>{$lang.upgrade_transaction_error}:</strong> {$lang.your_dont_have_enough_comissions_to_buy_selected_upgrade_amount}
			</div>
				
{/if}

{if $transaction_error_external eq 'y'}
<div class="error msg">
				<strong>{$lang.upgrade_transaction_error}:</strong> {$lang.your_transaction_was_cancelled}
			</div>
				
{/if}
         
			<h2>{$lang.buy_upgrade_with_rd_party_processor}</h2>
			<p>{$lang.you_choose_to_buy} <strong>{$membership}</strong> {$lang.upgrade_for} <strong>{$lang.monetary}{$total}</strong>.<br />
			  <br />
			  {$pay_button}
            </p>
			<p>&nbsp;</p>
          </article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
