{include file="header.tpl"}
{if (!isset($smarty.get.print))}
	{include file="menu.tpl"}
{/if}
<body>
<div id="content">
{if $mode == 'add_change'}
	{include file="FiberSplice_content_add_change.tpl"}
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