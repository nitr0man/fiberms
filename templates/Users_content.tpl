<form name="usersvalue" onsubmit="return false">
<div id="ololo">
	<table id="contable">
		<tr>
		<td><label class="events_anonce">Пользователь:</label></td><td id="newboxform">
		<select name="Users" onChange="javascript: GetUserInfo(document.usersvalue.Users.value,1);">
		{html_options values=$combobox_users_values selected=$combobox_users_selected output=$combobox_users_text}
		</select>
		
		</td>
		<tr>
		<td><!--<label class="events_anonce">deprecated</label>--></td><td><input type="hidden" name="whichadded" value="networkbox" size="30" /></td>
		</tr>
		<tr>
		<td colspan=2><label class="events_anonce"><input type="radio" name="group1" id="rb1" checked="checked" style="width: auto;" onClick="javascript: GetUserInfo(0,1); document.users.addchangebutton.value = 'Изменить';"> Изменить</label><br>
		<label class="events_anonce"><input type="radio" name="group1" id="rb2" style="width: auto;" onClick="javascript: ClearInput(); document.users.addchangebutton.value = 'Добавить';"> Добавить нового пользователя</label></td>
		</tr>
	</table>
</div>
</form>

<form name="users" onSubmit="return false">
<center>
<!--	<div id="addnewboxtype">-->
		<table id="contable">
		<tr>
		<td><label class="events_anonce">ID:</label></td><td> <input type="text" value="{$id}" name="id" readonly></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Логин:</label></td><td> <input type="text" value="{$login}" name="login"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">Пароль:</label></td><td> <input type="password" value="{$password}" name="password"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">Права:</label></td><td>
			<select name="group">
			{html_options values=$combobox_usergroup_values selected=$combobox_usergroup_selected output=$combobox_usergroup_text}			
			</select>
		</td>		
		</tr>
		<tr>
			<th colspan="2"><input value="Изменить" type="submit" name="addchangebutton" onclick="javascript: AddNewOrChangeUser(2,document.getElementById('rb1').checked,document.users.id.value,document.users.login.value,document.users.password.value,document.users.group.value)" /></th>
		</tr>
		
		</table>
</center>
<!--	</div>-->
</form>