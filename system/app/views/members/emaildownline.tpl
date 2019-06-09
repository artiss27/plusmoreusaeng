{include file="header.tpl"}

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article>
			<h2>{$data.TITLE}</h2>
            
            {$data.THANKS}
            
            {$data.CONTENT} 
             
             <h2>{$lang.content}</h2>
             
            <form action='#' method='POST' name='form1'>
    <table cellpadding="2" cellspacing="0" border="0" align="center" width='100%' id="table1" class="gtable">
        <tr>
            <td>
                <b>{$lang.email_subject} : </b>
            </td>
            <td>
                {$data.EMAIL_SUBJECT}
            </td>
        </tr>
<tr>
            <td>&nbsp;
                
            </td>
            <td>&nbsp;
                
            </td>
        </tr>
        
        <tr>
            <td valign='top'>
                <b>{$lang.email_body} :</b>
            </td>
            <td>
                {$data.EMAIL_MESSAGE}
            </td>
        </tr>
<tr>
            <td>&nbsp;
                
            </td>
            <td>&nbsp;
                
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td align="left">{$data.CHOOSE} 
                
            </td>
        </tr>
        <tr>
            <td align="center" colspan='2'>
                <br />
                <input type='submit' value=" Send " onClick="return confirm ('Send Emails?');">
          </td>
        </tr>
        <tr>
            <td align="left" colspan='2'><hr>
                <b>{$lang.replacements}</b>:
            </td>
        </tr>
  <tr>
            <td align="left" colspan='2'><hr>
               &nbsp;
            </td>
        </tr>
        </tr>
            <td align="left" colspan='2'>
                {$data.CHANGE_TEMPLATE}
            </td>
        </tr>
    </table>
    <input type='hidden' name='order' value='update'>
</form></article>
		</section>
		{include file="side.tpl"}
	</section>
</section>
{include file="footer.tpl"}
