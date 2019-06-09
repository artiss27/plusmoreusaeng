
{include file="header.tpl" title=foo}

 <p><BR>
    <BR><BR>
    <img src="/assets/frontpage/images//logo_lifetime_cycler.png" width="400" height="200" /></p><BR>

    <BR>    {if $errors}
    <ul>
{foreach $errors as $error}
   <li>{$error@key}: {$error}</li>
{/foreach}
</ul>

<br /><br />
{/if}
    
    <form action="/signup/postjoin/" method="post">
    <h2>3. Choose Membership</h2>
      <ul id="contactform">
      <li>
        <label for="username">Membership: &nbsp;&nbsp;&nbsp;
        <select name="membership" id="select">
        {foreach key=obj item=name from=$memberships}
          <option value="{$name}">
{capture assign=comm}{$name}_signup_fee{/capture}        
		{$name} ($<b>{$sett.$comm|string_format:"%.2f"}</b>)          
          </option>
          
          {/foreach}
        </select>
        </label> </li>
    </ul>
    
 <input type="hidden" name="email" value="{$email}"/>
 <input type="hidden" name="firstName" value="{$firstName}"/>
 <input type="hidden" name="lastName" value="{$firstName}"/>
 
 <input type="hidden" name="username" value="{$username}"/>
 <input type="hidden" name="password" value="{$password}"/>
 <input type="hidden" name="password2" value="{$password2}"/>
 <br />

 
		    <input type="checkbox" name="agree" value="1"> 
		  I Agree with the <a class="link_left" href="/tos.php" target="_blank">TOS</a><br />
		  <br />

    
         <small> ${$signupfee} Processing fee</small>
          
     
    <p>&nbsp;</p>
    <input type="submit" value="Register and Pay" id="sendbutton" name="sendbutton"/>
</form>

<br /><br />
{include file="footer.tpl"}

