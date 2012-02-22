<?php /* Smarty version Smarty-3.1.7, created on 2012-02-15 17:04:13
         compiled from ".\templates\FiberSplice.tpl" */ ?>
<?php /*%%SmartyHeaderCode:75944f3bc96d021da8-45458394%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e2a3bf81eedaeddd82d98cb6adb207dc8f4954d7' => 
    array (
      0 => '.\\templates\\FiberSplice.tpl',
      1 => 1329159816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '75944f3bc96d021da8-45458394',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f3bc96d17784',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f3bc96d17784')) {function content_4f3bc96d17784($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<body>
<div id="content">
<?php if ($_smarty_tpl->tpl_vars['mode']->value=='change'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("FiberSplice_content_change.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }elseif($_smarty_tpl->tpl_vars['mode']->value=='add'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("FiberSplice_content_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }elseif($_smarty_tpl->tpl_vars['mode']->value=='charac'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("FiberSplice_content_charac.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
	<?php echo $_smarty_tpl->getSubTemplate ("FiberSplice_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
</div>
</body><?php }} ?>