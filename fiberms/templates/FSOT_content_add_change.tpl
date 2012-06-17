<form name="fsot" action="FSOT.php" method="post">
<div>
<input type="hidden" value="{$mod}" name="mode" />
	<table id="contable">
		<tr>
		<td> <input type="hidden" value="{$id}" name="id"></td>
		</tr>		
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <input type="text" value="{$marking}" name="marking"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <input type="text" value="{$manufacturer}" name="manufacturer"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Примечание</label></td><td> <textarea name="note">{$note}</textarea></td>
		</tr>
		<tr>
		<td><input value="OK" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</div>
</form>