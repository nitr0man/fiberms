<form name="boxtypeinfo" action="CableType.php" method="post">
<div>
	<table id="contable">
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <label class="events_anonce">{$marking}</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <label class="events_anonce">{$manufacturer}</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">К-во туб</label></td><td> <label class="events_anonce">{$tubeQuantity}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">К-во волокон в тубе</label></td><td> <label class="events_anonce">{$fiberPerTube}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Допустимая нагрузка</label></td><td> <label class="events_anonce">{$tensileStrength}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Диаметр</label></td><td> <label class="events_anonce">{$diameter}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Примечание</label></td><td> <label class="events_anonce">{$comment}</label></td>
		</tr>
	</table>
	<td>{$ChangeDelete}</td>
</div>
</form>