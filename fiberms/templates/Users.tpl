{include file="header.tpl"}
{include file="menu.tpl"}
<!--<div id="boxinv">-->
<body onload="javascript: GetUserInfo(0,1);">
<!--<div id="backscript">&nbsp;</div>-->
<script type="text/javascript">

function ClearInput()
{
document.users.id.value = '';
document.users.login.value = '';
document.users.password.value = '';
}
</script>
<div id="content">
{include file="Users_content.tpl"}
</div>
<br />
{include file="footer.tpl"}
