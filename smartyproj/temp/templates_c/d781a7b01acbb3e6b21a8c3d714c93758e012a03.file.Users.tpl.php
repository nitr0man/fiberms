<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 18:35:41
         compiled from "./templates/Users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12337272414f2f7b44757517-33984117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd781a7b01acbb3e6b21a8c3d714c93758e012a03' => 
    array (
      0 => './templates/Users.tpl',
      1 => 1329727918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12337272414f2f7b44757517-33984117',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2f7b447f778',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2f7b447f778')) {function content_4f2f7b447f778($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
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
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>