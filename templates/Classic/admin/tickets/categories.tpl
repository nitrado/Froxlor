$header
	<form action="{$linker->getLink(array('section' => 'tickets'))}" method="post">
		<input type="hidden" name="s" value="$s"/>
		<input type="hidden" name="page" value="$page"/>
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['menue']['ticket']['categories']}</b></td>
				<td class="maintitle_search_right" colspan="4">{$searchcode}</td>
			</tr>
			<if 15 < $categories_count >
			<tr>
				<td class="field_display_border_left" colspan="4"><a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'categories', 'action' => 'addcategory'))}">{$lng['ticket']['ticket_newcateory']}</a></td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left">{$lng['ticket']['category']}&nbsp;&nbsp;{$arrowcode['name']}</td>
				<td class="field_display">{$lng['ticket']['logicalorder']}&nbsp;&nbsp;{$arrowcode['logicalorder']}</td>
				<td class="field_display">{$lng['ticket']['ticketcount']}&nbsp;&nbsp;<if $categories_count < 0 >{$arrowcode['ticketcount']}</if></td>
				<td class="field_display_search" colspan="2">{$sortcode}</td>
			</tr>
			$ticketcategories
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="5" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left" colspan="5"><a href="{$linker->getLink(array('section' => 'tickets', 'page' => 'categories', 'action' => 'addcategory'))}">{$lng['ticket']['ticket_newcateory']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer
