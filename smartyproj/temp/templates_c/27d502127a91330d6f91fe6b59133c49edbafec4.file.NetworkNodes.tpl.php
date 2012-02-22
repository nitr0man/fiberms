<?php /* Smarty version Smarty-3.1.7, created on 2012-02-20 12:03:20
         compiled from "./templates/NetworkNodes.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9496591934f2a4db408de74-95938065%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27d502127a91330d6f91fe6b59133c49edbafec4' => 
    array (
      0 => './templates/NetworkNodes.tpl',
      1 => 1329724998,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9496591934f2a4db408de74-95938065',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a4db40eb04',
  'variables' => 
  array (
    'mode' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a4db40eb04')) {function content_4f2a4db40eb04($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div id="content">
<?php if ($_smarty_tpl->tpl_vars['mode']->value=='change'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkNodes_content_change.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }elseif($_smarty_tpl->tpl_vars['mode']->value=='add'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkNodes_content_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkNodes_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>