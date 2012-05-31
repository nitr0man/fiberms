<form name="boxtypevalue" onsubmit="return false">
<div>
	{if ($smarty.get.sort == 1)}
		{$sort = 0}
	{else}
		{$sort = 1}
	{/if}
	{html_table table_attr='id="contable"' loop=$data cols="ID,BoxType,<a href=\"NetworkBox.php?sort=$sort\">InvNum</a>,Change,Delete" caption="Список ящиков"}
</div>
</form>
