<?php /* Smarty version Smarty-3.1.7, created on 2012-02-04 12:10:09
         compiled from ".\templates\CableType.tpl" */ ?>
<?php /*%%SmartyHeaderCode:58104f2d03e83ffa95-10428138%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a9b67ecb4068f6f48626780b876b94b5151563a7' => 
    array (
      0 => '.\\templates\\CableType.tpl',
      1 => 1328350208,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '58104f2d03e83ffa95-10428138',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2d03e85082c',
  'variables' => 
  array (
    'mode' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2d03e85082c')) {function content_4f2d03e85082c($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<body>
<div id="content">
<?php if ($_smarty_tpl->tpl_vars['mode']->value=='change'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("CableType_content_change.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }elseif($_smarty_tpl->tpl_vars['mode']->value=='add'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("CableType_content_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
	<?php echo $_smarty_tpl->getSubTemplate ("CableType_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
</div>
</body><?php }} ?>