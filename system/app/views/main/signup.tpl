
{include file="header.tpl" title=foo}

{if $errors}



{/if}
 <p><BR>
    <BR><BR>
    <img src="/assets/frontpage/images//logo_lifetime_cycler.png" width="400" height="200" /></p><BR>

    <BR>
    {if $errors}
    <ul>
{foreach $errors as $error}
   <li>{$error@key}: {$error}</li>
{/foreach}
</ul>

<br /><br />
{/if}

<form action="/signup/step2/" method="post">
    <h2>1. Contact Information</h2>
    
<ul id="contactform">
      <li>
        <label for="enroller">Enroller Username: &nbsp;&nbsp;&nbsp;<strong>{$enroller} &nbsp;&nbsp;&nbsp;</strong></label> 
        (<small><span><a href="#">Change if not correct</a></span></small>)
      </li>
      
        <li>
            <label for="email">Your Email</label>
            <span class="fieldbox"><input type="text" name="email" id="email" value=""/></span>
        </li>
        <li><label for="firstname">First Name</label><span class="fieldbox">
        <input type="text" name="firstName" id="firstname" value=""/></span>
        </li>
        <li><label for="lastname">Last  Name</label> <span class="fieldbox">
        <input type="text" name="lastName" id="lastname" value=""/>
        </span></li>
    </ul>
 
    <p>&nbsp;</p>
    <input type="submit" value="Step 2" id="sendbutton" name="sendbutton"/>
</form>

<br /><br />
{include file="footer.tpl"}

