<tr class="" onmouseover="this.className='RowOverSelected';" onmouseout="this.className='';">
	<td class="field_name_border_left">{$row['name']}</td>
	<td class="field_name">{$row['logicalorder']}</td>
	<td class="field_name">{$row['ticketcount']}&nbsp;({$row['ticketcountnotclosed']}&nbsp;{$lng['ticket']['open']}&nbsp;|&nbsp;{$closedtickets_count}&nbsp;{$lng['ticket']['closed']})</td>
	<td class="field_name">
		<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'categories', 'action' => 'editcategory', 'id' => $row['id']))}">{$lng['panel']['edit']}</a>
	</td>
	<td class="field_name">
		<a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'categories', 'action' => 'deletecategory', 'id' => $row['id']))}">{$lng['panel']['delete']}</a>
	</td>
</tr>
