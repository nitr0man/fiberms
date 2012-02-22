<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 12:52:11
         compiled from "./templates/NetworkBox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5700865584f2a4d854ebba0-20980673%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f34b3d454d212f6eba4d7eaa99946824fc8cfd46' => 
    array (
      0 => './templates/NetworkBox.tpl',
      1 => 1329727896,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5700865584f2a4d854ebba0-20980673',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a4d8558ca1',
  'variables' => 
  array (
    'mode' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a4d8558ca1')) {function content_4f2a4d8558ca1($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<body>
<div id="content">
<?php if ($_smarty_tpl->tpl_vars['mode']->value=='change'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkBox_content_change.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }elseif($_smarty_tpl->tpl_vars['mode']->value=='add'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkBox_content_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkBox_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>