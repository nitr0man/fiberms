{include file="header.tpl"}
{include file="menu.tpl"}
<body>
<div id="content">
{if $mode == 'change'}
	{include file="CableLinePoint_content_change.tpl"}
{elseif $mode == 'add'}
	{include file="CableLinePoint_content_add.tpl"}
{else}
	{include file="CableLinePoint_content.tpl"}
{/if}
</div>
{include file="footer.tpl"}
