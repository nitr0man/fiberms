<form name="boxtypeinfo" action="NetworkBoxType.php" method="post">
<div>
<input type="hidden" value="{$mod}" name="mode" />
<input type="hidden" value="{$back}" name="back" />
<input type="hidden" name="whichadded" id="whichadded" value="networkboxtype" />
<input type="hidden" value="{$id}" name="id">
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
		<tr><th colspan="2"><input value="OK" type="submit" name="OkButton" /></th></tr>
		</tr>
	</table>
</div>
</form>