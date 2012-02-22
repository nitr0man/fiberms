<form name="cablelineinfo" action="FSOT.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>
		<tr>
		<td> <input type="hidden" value="{$id}" name="id"></td>
		<br />
		</tr>		
		<tr>
		<td><label class="events_anonce">marking</label></td><td> <input type="text" value="{$marking}" name="marking"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">manufacturer</label></td><td> <input type="text" value="{$manufacturer}" name="manufacturer"></td>
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">note</label></td><td> <textarea name="note">{$note}</textarea></td>
		</tr>
		<tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr>
	</table>
</div>
</form>