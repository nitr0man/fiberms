<form name="boxtypeinfo" action="NetworkBoxType.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table id="contable">
		<tr>
		<td><label>Ящиков: </label></td><td><label>{$count}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <label>{$marking}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <label>{$manufacturer}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Единиц</label></td><td> <label>{$units}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Ширина (мм)</label></td><td> <label>{$width}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Высота (мм)</label></td><td> <label>{$height}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Длина (мм)</label></td><td> <label>{$length}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Диаметр (мм)</label></td><td> <label>{$diameter}</label></td>
		</tr>
		</tr>
	</table>
	<td>{$ChangeDelete}</td>
</div>
</form>