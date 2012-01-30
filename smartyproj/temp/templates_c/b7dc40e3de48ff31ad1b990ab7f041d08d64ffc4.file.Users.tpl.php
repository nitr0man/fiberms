<?php /* Smarty version Smarty-3.1.7, created on 2012-01-30 19:44:50
         compiled from ".\templates\Users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:70764f26cea7b8ed35-00347915%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7dc40e3de48ff31ad1b990ab7f041d08d64ffc4' => 
    array (
      0 => '.\\templates\\Users.tpl',
      1 => 1327945489,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70764f26cea7b8ed35-00347915',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f26cea7be58b',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f26cea7be58b')) {function content_4f26cea7be58b($_smarty_tpl) {?>﻿<?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
<?php echo $_smarty_tpl->getSubTemplate ("Users_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
<br />

</body>
<!--</div>--><?php }} ?>