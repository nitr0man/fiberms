<form name="boxtypeinfo" action="NetworkBoxType.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table id="contable">
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <input type="text" value="{$marking}" name="marking"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <input type="text" value="{$manufacturer}" name="manufacturer"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">Единиц</label></td><td> <input type="text" value="{$units}" name="units"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Ширина (мм)</label></td><td> <input type="text" value="{$width}" name="width"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Высота (мм)</label></td><td> <input type="text" value="{$height}" name="height"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Длина (мм)</label></td><td> <input type="text" value="{$length}" name="length"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Диаметр (мм)</label></td><td> <input type="text" value="{$diameter}" name="diameter"></td>
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
		</tr>
</div>
</form>
