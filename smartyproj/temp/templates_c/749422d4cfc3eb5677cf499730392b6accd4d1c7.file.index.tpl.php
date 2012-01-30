<?php /* Smarty version Smarty-3.1.7, created on 2012-01-30 18:53:43
         compiled from ".\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:77774f26b896c0a7b7-62880949%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '749422d4cfc3eb5677cf499730392b6accd4d1c7' => 
    array (
      0 => '.\\templates\\index.tpl',
      1 => 1327942422,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '77774f26b896c0a7b7-62880949',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f26b896d8021',
  'variables' => 
  array (
    'warning' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f26b896d8021')) {function content_4f26b896d8021($_smarty_tpl) {?>﻿<?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<?php echo $_smarty_tpl->tpl_vars['warning']->value;?>

<form action="index.php" method="post">
<div>
 <input type="hidden" name="login" value="login" />
 Логин: <input type="text" name="user" value="" /><br />
 Пароль: <input type="password" name="password" value="" class="text req" /><br />
 <label><input type="checkbox" name="remember"> Запомнить</label>
 <p><input type="submit" name="logined" value="Логин" /></p>
</div>
</form><?php }} ?>