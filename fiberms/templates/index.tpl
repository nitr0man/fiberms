{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
{$warning}
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