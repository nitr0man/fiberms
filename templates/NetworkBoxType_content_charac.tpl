<form name="boxtypeinfo" action="NetworkBoxType.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table id="contable">
		<tr>
		<td><label class="events_anonce">Ящиков: </label></td><td><label class="events_anonce">{$count}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <label class="events_anonce">{$marking}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <label class="events_anonce">{$manufacturer}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Единиц</label></td><td> <label class="events_anonce">{$units}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Ширина (мм)</label></td><td> <label class="events_anonce">{$width}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Высота (мм)</label></td><td> <label class="events_anonce">{$height}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Длина (мм)</label></td><td> <label class="events_anonce">{$length}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Диаметр (мм)</label></td><td> <label class="events_anonce">{$diameter}</label></td>
		</tr>
	</table>
	<td>{$ChangeDelete}</td>
</form>
</div>