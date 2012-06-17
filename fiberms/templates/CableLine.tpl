{include file="header.tpl"}
{include file="menu.tpl"}
<body>
<div id="content">
{if $mode == 'add_change'}
	{include file="CableLine_content_add_change.tpl"}
{elseif $mode == 'add'}
	{include file="CableLine_content_add.tpl"}
{elseif $mode == 'charac'}
	{include file="CableLine_content_charac.tpl"}
{else}
	{include file="CableLine_content.tpl"}
{/if}
</div>
{include file="footer.tpl"}
