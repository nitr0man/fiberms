<?php /* Smarty version Smarty-3.1.7, created on 2012-01-31 15:02:42
         compiled from ".\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:260924f27bfa2452e82-45307778%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '749422d4cfc3eb5677cf499730392b6accd4d1c7' => 
    array (
      0 => '.\\templates\\index.tpl',
      1 => 1328014953,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '260924f27bfa2452e82-45307778',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f27bfa24a4b2',
  'variables' => 
  array (
    'warning' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f27bfa24a4b2')) {function content_4f27bfa24a4b2($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>

<?php echo $_smarty_tpl->tpl_vars['warning']->value;?>

<form action="index.php" method="post">
<div style="text-align:center;">


<table align='center' width='400'  cellspacing='0' cellpadding='0' border='0' style='padding-top:20%;'><TR><TD bgcolor='#88AAAA'>
<table width='100%' cellspacing='1' cellpadding='0' border='0'><TR><TD bgcolor='#eeeee3'>
<table width='100%' cellspacing='0' cellpadding='0' border='0'>
<tr><td colspan=2>&nbsp;</td></tr>
<input type="hidden" name="login" value="login" />
<tr><td align=right>&nbsp;Логин: &nbsp;</TD><TD><input type="text" name="user" value="" /><br /></TD></TR>
<TR><TD align=right>&nbsp;Пароль: &nbsp;</TD><TD><input type="password" name="password" value="" class="text req" /><br /></TD></TR>
<tr><td></td></td><td align=center><label>&nbsp;&nbsp;<input type="checkbox" name="remember" checked="true"> Запомнить</label><br /></td></tr>
<tr><th colspan='2'><input type='submit' name='logined' value=' Войти '></th></TR>
<tr><td colspan=2>&nbsp;</td></tr>
</table>
</td></tr></table>
</td></tr></table>


 <!--input type="hidden" name="login" value="login" />
 Логин: <input type="text" name="user" value="" /><br />
 Пароль: <input type="password" name="password" value="" class="text req" /><br />
 <label><input type="checkbox" name="remember" checked="true"> Запомнить</label>
 <p><input type="submit" name="logined" value="Логин" /></p -->
</div>
</form>
<?php }} ?>