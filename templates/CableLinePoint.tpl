{include file="header.tpl"}
{include file="menu.tpl"}
<div id="content">
{if $mode == 'add_change'}
	{include file="CableLinePoint_content_add_change.tpl"}
{elseif $mode == 'add'}
	{include file="CableLinePoint_content_add.tpl"}
{else}
	{include file="CableLinePoint_content.tpl"}
{/if}
</div>
{include file="footer.tpl"}
