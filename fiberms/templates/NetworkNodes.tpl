{config_load file="test.conf" section="setup"}
{include file="header.tpl"}
{include file="menu.tpl"}
<div id="content">
{if $mode == 'change'}
	{include file="NetworkNodes_content_change.tpl"}
{elseif $mode == 'add'}
	{include file="NetworkNodes_content_add.tpl"}
{elseif $mode == 'charac'}
	{include file="NetworkNodes_content_charac.tpl"}
{else}
	{include file="NetworkNodes_content.tpl"}
{/if}
</div>
{include file="footer.tpl"}