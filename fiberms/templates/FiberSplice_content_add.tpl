<form name="fibersplice" action="FiberSplice.php" method="post">
<div>
<input type="hidden" value="{$clpid1}" name="clpid1">
<input type="hidden" value="2" name="mode">
<input type="hidden" value="{$NetworkNodeId}" name="NetworkNodeId">
<input type="hidden" value="-1" name="curr_fiber">
	<table id="contable">
		<tr>
		<td>
		</tr>		
		<tr>
		<td><label class="events_anonce">Кабель1:</label></td><td> <input type="text" value="{$cable1}" name="cable"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Волокно1:</label></td><td> <input type="text" value="{$fiber1}" name="fiber"></td>
		</tr>
		<tr>
		<td><label class="events_anonce">CableLinePoint:</label></td><td> <select name="CableLinePoint" onChange="javascript: GetFiber(document.fibersplice.CableLinePoint.value,document.fibersplice.NetworkNodeId.value,document.fibersplice.curr_fiber.value,3);"> {html_options values=$ComboBox_CableLinePoint_values selected=$ComboBox_CableLinePoint_selected output=$ComboBox_CableLinePoint_text}</select></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Волокно2:</label></td>
			<td> {include file="FiberSplice_content_Fibers.tpl"} <!--select name="Fibers"> {html_options values=$ComboBox_Fibers_values selected=$Combobox_Fibers_selected output=$ComboBox_Fibers_text}</select></td-->
		</tr>
		<tr>
		<td><label class="events_anonce">FiberSpliceOrganizer:</label></td><td> <select name="FibersSpliceOrganizer"> {html_options values=$ComboBox_FibersSpliceOrganizer_values selected=$Combobox_FibersSpliceOrganizer_selected output=$ComboBox_FibersSpliceOrganizer_text}</select></td>
		</tr>
		<tr>
		<td><input value="Добавить" type="submit" name="AddButton" /></td>
		</tr>
	</table>
</div>
</form>