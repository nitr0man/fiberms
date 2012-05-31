{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
{include file="menu.tpl"}
<body>
<div id="content">
<form>
	<table id="contable">
		<tr>
			<td>
				{$message}
			</td>
		</tr>	
	</table>
</form>
</div>
{include file="footer.tpl"}