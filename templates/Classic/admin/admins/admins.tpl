$header
	<form action="{$linker->getLink(array('section' => 'admins'))}" method="post">
                <input type="hidden" name="s" value="$s"/>
                <input type="hidden" name="page" value="$page"/>
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left" colspan="3"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['admin']['admins']}</b>&nbsp;({$admincount})</td>
				<td class="maintitle_search_right" colspan="<if ($settings['ticket']['enabled'] == 1 || $settings['autoresponder']['autoresponder_active'] == 1) >7<else>6</if>">{$searchcode}</td>
			</tr>
			<tr>
				<td class="field_display_border_left">{$lng['login']['username']}<br />{$arrowcode['loginname']}</td>
				<td class="field_display">{$lng['customer']['name']}<br />{$arrowcode['name']}</td>
				<td class="field_display">{$lng['admin']['customers']}<br />{$lng['admin']['domains']}</td>
				<td class="field_display">{$lng['customer']['diskspace']}<br />{$lng['customer']['traffic']}</td>
				<td class="field_display">{$lng['customer']['mysqls']}<br />{$lng['customer']['ftps']}</td>
				<if ($settings['ticket']['enabled'] == 1 || $settings['autoresponder']['autoresponder_active'] == 1) >
					<if ($settings['ticket']['enabled'] == 1 && $settings['autoresponder']['autoresponder_active'] == 0) >
						<td class="field_display">{$lng['customer']['tickets']}</td>
					</if>
					<if ($settings['ticket']['enabled'] == 0 && $settings['autoresponder']['autoresponder_active'] == 1) >
						<td class="field_display">{$lng['customer']['autoresponder']}</td>
					</if>
					<if ($settings['ticket']['enabled'] == 1 && $settings['autoresponder']['autoresponder_active'] == 1) >
						<td class="field_display">{$lng['customer']['tickets']}<br />{$lng['customer']['autoresponder']}</td>
					</if>
				</if>
				<td class="field_display">{$lng['customer']['emails']}<br />{$lng['customer']['subdomains']}</td>
				<td class="field_display">{$lng['customer']['accounts']}<br />{$lng['customer']['forwarders']}</td>
				<td class="field_display">{$lng['admin']['deactivated']}<br />{$arrowcode['deactivated']}</td>
				<td class="field_display_search">{$sortcode}</td>
			</tr>
			$admins
			<if $pagingcode != ''>
			<tr>
				<td class="field_display_border_left" colspan="10" style=" text-align: center; ">{$pagingcode}</td>
			</tr>
			</if>
			<tr>
				<td class="field_display_border_left" colspan="<if ($settings['ticket']['enabled'] == 1 || $settings['autoresponder']['autoresponder_active'] == 1) >10<else>9</if>"><a href="{$linker->getLink(array('section' => 'admins', 'page' => $page, 'action' => 'add'))}">{$lng['admin']['admin_add']}</a></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer