<form name="fsot" action="FSOT.php" method="post">
<div>
<input type="hidden" value="2" name="mode" />
	<table id="contable">
		<tr>
		<td><label class="events_anonce">marking</label></td><td> <input type="text" value="{$marking}" name="marking"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">manufacturer</label></td><td> <input type="text" value="{$manufacturer}" name="manufacturer"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">note</label></td><td> <textarea name="note">{$note}</textarea></td>
		</tr>
		<tr>
			<td>
			<input value="Добавить" type="submit" name="AddButton" /><br />
			</td>
			<br />
		</tr>
</div>
</form>