{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
{include file="menu.tpl"}
<body> <!--onload="javascript: GetNodeInfo(0,1);"-->
<div id="content">
{if $mode == 'change'}
	{include file="NetworkNodes_content_change.tpl"}
{elseif $mode == 'add'}
	{include file="NetworkNodes_content_add.tpl"}
{else}
	{include file="NetworkNodes_content.tpl"}
{/if}
</div>
</body>
