{include file="header.tpl"}
{include file="menu.tpl"}
<body>
<div id="content">
{if $mode == 'change'}
	{include file="FiberSplice_content_change.tpl"}
{elseif $mode == 'add'}
	{include file="FiberSplice_content_add.tpl"}
{elseif $mode == 'charac'}
	{include file="FiberSplice_content_charac.tpl"}
{else}
	{include file="FiberSplice_content.tpl"}
{/if}
</div>
<!-- </body> -->
{include file="footer.tpl"}