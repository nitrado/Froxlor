$header
	<form method="get" action="$filename">
		<input type="hidden" name="s" value="$s" />
		<input type="hidden" name="page" value="$page" />
		<table cellpadding="5" cellspacing="4" border="0" align="center" class="maintable_40">
			<tr>
				<td class="maintitle" colspan="2"><b><img src="images/Classic/title.gif" alt="" />&nbsp;{$lng['admin']['configfiles']['serverconfiguration']}</b> [<a href="{$linker->getLink(array('section' => 'configfiles', 'page' => 'overview'))}">{$lng['admin']['configfiles']['overview']}</a>]</td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['admin']['configfiles']['distribution']}:</b></td>
				<td class="main_field_display" nowrap="nowrap"><if $distribution != ''><input type="hidden" name="distribution" value="$distribution"/><a href="{$linker->getLink(array('section' => 'configfiles', 'page' => $page))}">{$configfiles[$distribution]['label']}</a><else><select id="config_distribution" name="distribution"><option value="choose">{$lng['admin']['configfiles']['choosedistribution']}</option>{$distributions_select}</select></if></td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['admin']['configfiles']['service']}:</b></td>
				<td class="main_field_display" nowrap="nowrap"><if $service != ''><input type="hidden" name="service" value="$service"/><a href="{$linker->getLink(array('section' => 'configfiles', 'page' => $page, 'distribution' => $distribution))}">{$configfiles[$distribution]['services'][$service]['label']}</a><else><select id="config_service" name="service"><option value="choose">{$lng['admin']['configfiles']['chooseservice']}</option>{$services_select}</select></if></td>
			</tr>
			<tr>
				<td class="main_field_name"><b>{$lng['admin']['configfiles']['daemon']}:</b></td>
				<td class="main_field_display" nowrap="nowrap"><select id="config_daemon" name="daemon"><option value="choose">{$lng['admin']['configfiles']['choosedaemon']}</option>{$daemons_select}</select></td>
			</tr>
			<tr>
				<td class="main_field_confirm" colspan="2"><input class="bottom" type="submit" value="{$lng['panel']['next']}" /></td>
			</tr>
		</table>
	</form>
	<br />
	<br />
$footer