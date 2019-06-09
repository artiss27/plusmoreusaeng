
{include file="header.tpl" title=foo}

{if $errors}

<ul>
{foreach $errors as $error}
   <li>{$error@key}: {$error}</li>
{/foreach}
</ul>

{/if}
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
    
    <form action="/signup/step3/" method="post">
    <h2>2. Login Information</h2>
      <ul id="contactform">
      <li><label for="username">Username</label> <span class="fieldbox">
        <input type="text" name="username" id="username" value=""/></span>
        </li>
        <li>
          <label for="password">Password</label><span class="fieldbox">
        <input type="text" name="password" id="password" value=""/></span>
        </li>
        <li>
          <label for="password2">Confirm Password</label> <span class="fieldbox">
        <input type="text" name="password2" id="password2" value=""/>
        </span></li>
    </ul>
    
 <input type="hidden" name="email" value="{$email}"/>
 <input type="hidden" name="firstName" value="{$firstName}"/>
 <input type="hidden" name="lastName" value="{$firstName}"/>
 
    <p>&nbsp;</p>
    <input type="submit" value="Step 3" id="sendbutton" name="sendbutton"/>
</form>

<br /><br />
{include file="footer.tpl"}

