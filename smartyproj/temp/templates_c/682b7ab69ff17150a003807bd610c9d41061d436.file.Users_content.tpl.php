<?php /* Smarty version Smarty-3.1.7, created on 2012-01-30 19:49:06
         compiled from ".\templates\Users_content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:279174f26cea7bfcf73-45901140%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '682b7ab69ff17150a003807bd610c9d41061d436' => 
    array (
      0 => '.\\templates\\Users_content.tpl',
      1 => 1327945724,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '279174f26cea7bfcf73-45901140',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f26cea7d27ce',
  'variables' => 
  array (
    'combobox_users_values' => 0,
    'combobox_users_selected' => 0,
    'combobox_users_text' => 0,
    'id' => 0,
    'login' => 0,
    'password' => 0,
    'combobox_usergroup_values' => 0,
    'combobox_usergroup_selected' => 0,
    'combobox_usergroup_text' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f26cea7d27ce')) {function content_4f26cea7d27ce($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'S:\\home\\localhost\\www\\kkc\\fiberms\\smartyproj\\libs\\plugins\\function.html_options.php';
?>﻿<form name="usersvalue" onsubmit="return false">
<div id="ololo">
	<table>
		<tr>
		<td><label class="events_anonce">Пользователь:</label></td><td id="newboxform">
		<select name="Users" onChange="javascript: GetTypeBoxInfo(document.usersvalue.Users.value,1);">
		<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_users_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_users_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_users_text']->value),$_smarty_tpl);?>

		</select>
		
		</td>

<br />		
		<tr>
		<td><!--<label class="events_anonce">deprecated</label>--></td><td><input type="hidden" name="whichadded" value="networkbox" size="30" /></td>
		</tr>
		<tr>
		<td><label class="events_anonce"><input type="radio" name="group1" id="rb1" checked="checked" onClick="javascript: GetUserInfo(0,1); document.users.addchangebutton.value = 'Изменить';"> Изменить</label><br />   
		<label class="events_anonce"><input type="radio" name="group1" id="rb2" onClick="javascript: ClearInput(); document.users.addchangebutton.value = 'Добавить';"> Добавить нового пользователя</label></td>
		</tr>
	</table>
</div>
</form>

<form name="users" onSubmit="return false">
<!--	<div id="addnewboxtype">-->
		<table>
		<tr>
		<td><label class="events_anonce">ID:</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="id"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Логин:</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['login']->value;?>
" name="login"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Пароль:</label></td><td> <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['password']->value;?>
" name="password"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Права:</label></td><td>
			<select name="group">
			<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['combobox_usergroup_values']->value,'selected'=>$_smarty_tpl->tpl_vars['combobox_usergroup_selected']->value,'output'=>$_smarty_tpl->tpl_vars['combobox_usergroup_text']->value),$_smarty_tpl);?>
			
			</select>
		</td>		
		</tr>
		<tr>
			<td><input value="Изменить" type="submit" name="addchangebutton" onclick="javascript: AddNewOrChangeUser(2,document.getElementById('rb1').checked,document.users.id.value,document.users.login.value,document.users.password.value,document.users.group.value)" /></td>
		</tr>
		
		</table>
<!--	</div>-->
</form><?php }} ?>