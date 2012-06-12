{include file="header.tpl"}
{include file="menu.tpl"}
<body>
<div id="content">
{if $mode == 'change'}
	{include file="CableType_content_change.tpl"}
{elseif $mode == 'add'}
	{include file="CableType_content_add.tpl"}
{elseif $mode == 'charac'}
	{include file="CableType_content_charac.tpl"}
{else}
	{include file="CableType_content.tpl"}
{/if}
</div>
{include file="footer.tpl"}
