<form name="boxtypeinfo" action="NetworkBoxType.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table id="contable">
		<tr>
		<td><label class="events_anonce">ID</label></td><td> <input type="hidden" value="{$id}" name="id"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <input type="text" value="{$marking}" name="marking"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <input type="text" value="{$manufacturer}" name="manufacturer"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">Units</label></td><td> <input type="text" value="{$units}" name="units"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Width</label></td><td> <input type="text" value="{$width}" name="width"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Height</label></td><td> <input type="text" value="{$height}" name="height"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Length</label></td><td> <input type="text" value="{$length}" name="length"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Diameter</label></td><td> <input type="text" value="{$diameter}" name="diameter"></td>
		</tr><td><input type="hidden" name="whichadded" id="whichadded" value="networkboxtype" /></td><td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</div>
</form>