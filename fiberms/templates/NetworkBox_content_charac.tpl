<form name="boxinfo" action="NetworkBox.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table id="contable">		
		<tr>
			<td>
			<label class="events_anonce">Type: </label></td><td><label>{$boxtype}</label>
			</td>
		</tr>
		<tr>
			<td>
			<label class="events_anonce">InvNum: </label></td><td> <label>{$invNum}</label>
			</td>
		</tr>
		<tr>
		<td>
			<label>Node name: </label>
		</td>
		<td>
			<label>{$nodename}</label>
		</td>
		</tr>
	</table>
	<td>{$ChangeDelete}</td>
</div>
</form>