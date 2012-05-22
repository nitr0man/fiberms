{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
{include file="menu.tpl"}
<body>
<div id="content">
{if $mode == 'change'}
	{include file="FSOT_content_change.tpl"}
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