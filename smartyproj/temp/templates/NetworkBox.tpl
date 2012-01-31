{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
{include file="menu.tpl"}
<body onload="javascript: GetBoxInfo(0,1);">
<div id="content">
{include file="NetworkBox_content.tpl"}

