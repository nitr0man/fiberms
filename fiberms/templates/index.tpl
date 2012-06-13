{include file="header.tpl"}
{include file="menu.tpl"}
<body>
<div id="content">
<form name="index">
<div>
<input type="hidden" value="1" name="mode" />
	<table id="contable">
		<tr>
		<td><label class="events_anonce">Версия:</label></td><td> <label>{$version}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Пользователей:</label></td><td> <label>{$users_all} (из них {$users_admin} админов)</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Сварки:</label></td><td> <label>{$FiberSplice_FiberSpliceCount} в {$FiberSplice_NetworkNodesCount} узлах</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Кабельных линий:</label></td><td> <label>{$CableLinePointCount}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Установлено ящиков:</label></td><td> <label>{$NetworkNodesCount} из {$NetworkBoxesCount}</label></td>
		</tr>
	</table>
</div>
</form>
</div>
{include file="footer.tpl"}