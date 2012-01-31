{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
{$warning}
<form action="index.php" method="post">
<div>
 <input type="hidden" name="login" value="login" />
 Логин: <input type="text" name="user" value="" /><br />
 Пароль: <input type="password" name="password" value="" class="text req" /><br />
 <label><input type="checkbox" name="remember" checked="true"> Запомнить</label>
 <p><input type="submit" name="logined" value="Логин" /></p>
</div>
</form>