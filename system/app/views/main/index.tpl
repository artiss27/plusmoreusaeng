
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

    <BR><BR>
</div></div>

under construction
{include file="footer.tpl"}
