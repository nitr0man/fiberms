<form name="boxtypeinfo" action="CableType.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
		<td><label class="events_anonce">ID</label></td><td> <input type="hidden" value="{$id}" name="id"></td>
		<br />
		</tr>		
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <input type="text" value="{$marking}" name="marking"></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <input type="text" value="{$manufacturer}" name="manufacturer"></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">tubeQuantity</label></td><td> <input type="text" value="{$tubeQuantity}" name="tubeQuantity"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">fiberPerTube</label></td><td> <input type="text" value="{$fiberPerTube}" name="fiberPerTube"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">tensileStrength</label></td><td> <input type="text" value="{$tensileStrength}" name="tensileStrength"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">diameter</label></td><td> <input type="text" value="{$diameter}" name="diameter"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">comment</label></td><td> <textarea name="comment">{$comment}</textarea></td>
		</tr>
		<tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</div>
</form>