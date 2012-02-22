<?php /* Smarty version Smarty-3.1.7, created on 2012-02-02 10:46:29
         compiled from "./templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18435341594f2a4d65b14e30-25889603%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0360d049dff10f364dfc53ba2cc3958abf6ee6d' => 
    array (
      0 => './templates/index.tpl',
      1 => 1328172198,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18435341594f2a4d65b14e30-25889603',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'warning' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2a4d65b6d32',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2a4d65b6d32')) {function content_4f2a4d65b6d32($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
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