{include file="header.tpl"}

<section id="content">
<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article>
  {if $money_request eq 'y'}
<div class="success msg">
				<strong>{$lang.done}:</strong> {$lang.withdrawal_was_succesfully_requested}
				</div>
				
{/if}  
{foreach $errors as $error}

<div class="error msg">
<strong>{$error@key}</strong> {$error}
</div>
  
{/foreach} 
<form id="myForm" class="form-horizontal" method="post">
        
        <fieldset>
			<legend>{$lang.money_withdrawal}
						</legend>
					  <div class="form-group">
						  <dt>
						    <label for="name"> {$lang.account_balance}:</label></dt>
						  <dd><b>{$lang.monetary}{$balance}</b></dd>
 							<dt>
 							  <label for="name">{$lang.selected_processor}:</label></dt>
						  <dd>{$processor}
								<small>{$lang.can_change_this_on_your_profile}</small>
						  </dd>
                           <dt>
                             <label for="name">{$lang.request_money_fee}:</label></dt>
						  <dd>{$lang.monetary}{$requestfee}</dd>
                           <dt>
                             <label for="name">{$lang.minium_money_request}:</label></dt>
						  <dd>{$lang.monetary}{$minrequest}</dd>
                           <dt>
                             <label for="name">{$lang.withdraw_this_amount}:</label></dt>
						  <dd>
							  {$lang.monetary} <input type="text" name="cash" value=""  size="15" />
								
						  </dd>
					  </div>
                      <div class="buttons">
						<button name="request" type="submit" class="button" value="submit">{$lang.request}</button>
			</div>
		  </fieldset>
        
            
</form>
				
		</article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
