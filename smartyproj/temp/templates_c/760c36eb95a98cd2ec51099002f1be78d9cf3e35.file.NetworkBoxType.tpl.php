<?php /* Smarty version Smarty-3.1.7, created on 2012-02-12 11:49:32
         compiled from ".\templates\NetworkBoxType.tpl" */ ?>
<?php /*%%SmartyHeaderCode:143564f27bf5933dfa3-19603023%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '760c36eb95a98cd2ec51099002f1be78d9cf3e35' => 
    array (
      0 => '.\\templates\\NetworkBoxType.tpl',
      1 => 1329039943,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143564f27bf5933dfa3-19603023',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f27bf59397ed',
  'variables' => 
  array (
    'mode' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f27bf59397ed')) {function content_4f27bf59397ed($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<body>
<div id="content">
<?php if ($_smarty_tpl->tpl_vars['mode']->value=='change'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkBoxType_content_change.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }elseif($_smarty_tpl->tpl_vars['mode']->value=='add'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkBoxType_content_add.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }elseif($_smarty_tpl->tpl_vars['mode']->value=='charac'){?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkBoxType_content_charac.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
	<?php echo $_smarty_tpl->getSubTemplate ("NetworkBoxType_content.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
</div>
</body><?php }} ?>