
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

<p><br />
  <br />
{/if}

</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Congratulations! Your account is now activated!</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br />
  <br />
  {include file="footer.tpl"}
  
</p>
