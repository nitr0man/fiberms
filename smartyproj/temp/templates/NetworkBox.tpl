{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
{include file="menu.tpl"}
<body>
<div id="content">
{if $mode == 'change'}
	{include file="NetworkBox_content_change.tpl"}
{elseif $mode == 'add'}
	{include file="NetworkBox_content_add.tpl"}
{elseif $mode == 'charac'}
	{include file="NetworkBox_content_charac.tpl"}
{else}
	{include file="NetworkBox_content.tpl"}
{/if}
</div>
</body>