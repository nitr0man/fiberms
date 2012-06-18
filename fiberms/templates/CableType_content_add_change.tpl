<form name="boxtypeinfo" action="CableType.php" method="post">
<div>
<input type="hidden" value="{$mod}" name="mode" />
<input type="hidden" value="{$back}" name="back" />
	<table id="contable">
		<tr>
		<td><input type="hidden" value="{$id}" name="id"></td>
		</tr>		
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <input type="text" value="{$marking}" name="marking"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <input type="text" value="{$manufacturer}" name="manufacturer"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		</tr>
		<tr>
		<td><label class="events_anonce">К-во туб</label></td><td> <input type="text" value="{$tubeQuantity}" name="tubeQuantity"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">К-во волокон в тубе</label></td><td> <input type="text" value="{$fiberPerTube}" name="fiberPerTube"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Допустимая нагрузка</label></td><td> <input type="text" value="{$tensileStrength}" name="tensileStrength"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Диаметр</label></td><td> <input type="text" value="{$diameter}" name="diameter"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Примечание</label></td><td> <textarea name="comment">{$comment}</textarea></td>
		</tr>
		<tr>
		<th colspan="2"><input value="OK" type="submit" name="OkButton" /></th>
		</tr>
	</table>
</div>
</form>