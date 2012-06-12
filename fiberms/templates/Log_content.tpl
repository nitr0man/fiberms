<form name="LoggingIs" onsubmit="return false">
	{html_table table_attr='id="contable"' loop=$data cols="ID,table,record,time,action,description,admin" caption="Журнал"}
	<p style="margin: 20px;">{$pages}</p>
</form>