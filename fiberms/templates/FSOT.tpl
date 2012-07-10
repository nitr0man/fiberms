{include file="header.tpl"}
{include file="menu.tpl"}
<body>
<div id="content">
{if $mode == 'add_change'}
	{include file="FSOT_content_add_change.tpl"}
{elseif $mode == 'add'}
	{include file="FSOT_content_add.tpl"}
{elseif $mode == 'charac'}
	{include file="FSOT_content_charac.tpl"}
{else}
	{include file="FSOT_content.tpl"}
{/if}
</div>
<!--/body-->
{include file="footer.tpl"}