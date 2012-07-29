{include file="header.tpl"}
{include file="menu.tpl"}
<body>
<div id="content">
{if $mode == 'add_change'}
	{include file="FSO_content_add_change.tpl"}
{elseif $mode == 'add'}
	{include file="FSO_content_add.tpl"}
{elseif $mode == 'charac'}
	{include file="FSO_content_charac.tpl"}
{else}
	{include file="FSO_content.tpl"}
{/if}
</div>
<!--/body-->
{include file="footer.tpl"}