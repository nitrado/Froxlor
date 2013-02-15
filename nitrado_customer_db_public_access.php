<?php
if ($_SERVER["REMOTE_ADDR"] != '217.8.59.23') {
    die("This site can only be viewed from the nitrado.net office!");
}
?>
<h1>Allow external DB access</h1>
<?php
require_once("FroxlorLogin.php");
require_once("lib/userdata.inc.php");
require_once("DB.mysqli.class.php");
$db  = new DB($sql_root[0]['host'],'root',$sql_root[0]['password'],'mysql');
function getPublicUsers() {
    global $db;
    $usersPublic = array();
    foreach ($db->query("select distinct user from mysql.user where user like 'ni%' and host = '%' order by user;") as $user) {
        $usersPublic[] = $user['user'];
    }
    return $usersPublic;
}
function getAllUsers() {
    global $db;
    $users = $db->query("select distinct user from mysql.user where user like 'ni%' order by user;");
    $allUsers = array();
    foreach ($users as $user) {
        $allUsers[] = $user['user'];
    }
    return $allUsers;
}

function allowExternalAccess($user) {
    global $db;
    $user = $db->escape($user);
    $pw = $db->query("SELECT password FROM user WHERE user = '".$user."' and host = 'localhost';");
    if (empty($pw) || !isset($pw[0]['password'])) {
	return false;
    }
    $pw = $db->escape($pw[0]['password']);
    $res = $db->query("CREATE USER '".$user."'@'%' IDENTIFIED BY PASSWORD  '".$pw."';");
    if (!$res) {
	echo "CREATE USER FAILED<br />";
	return false;
    }
    $res = $db->query("GRANT USAGE ON * . * TO  '".$user."'@'%' IDENTIFIED BY PASSWORD  '".$pw."' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 25 ;");
    if (!$res) {
	echo "GRANT USAGE FAILED<br />";
	return false;
    }
    $res = $db->query("GRANT ALL PRIVILEGES ON  `".$user."` . * TO  '".$user."'@'%';");
    if (!$res) {
	echo "GRANT ALL PRIVILEGES FAILED<br />";
	return false;
    }
    return true;
}

function revokePublicAccess($user) {
    global $db;
    $user = $db->escape($user);
    $res = $db->query("DROP USER '".$user."'@'%';");
    if (!$res) {
	echo "DROP USER FAILED<br />";
	return false;
    }
    return true;
}

$allUsers = getAllUsers();
if (!empty($_POST)) {
    $usersPublic = getPublicUsers();
    foreach ($_POST['allow'] as $user) {
	if (!in_array($user, $allUsers)) {
//	    echo "User '$user' not found<br />";
	    continue;
	}
	if (in_array($user, $usersPublic)) {
//	    echo "User '$user' has already public access<br />";
	    continue;
	}
	echo "allowing external access for $user<br />\n";
	allowExternalAccess($user);
    }
    foreach ($usersPublic as $user) {
	if (in_array($user, $_POST['allow'])) {
	    continue;
	}
	revokePublicAccess($user);
	echo "Removing public access for '$user'<br />";
    }
}

$usersPublic = getPublicUsers();
?>

<form method="POST">
<input type="submit" />
<table>
<?php
foreach ($allUsers as $user) {
    ?>
    <tr>
	<td><?=$user?></td>
	<td><input type="checkbox" value="<?=$user?>" id="<?=$user?>" name="allow[<?=$user?>]" <?=in_array($user, $usersPublic) ? 'checked="checked"' : ''?>/> <label for="<?=$user?>">Change</label></td>
    </tr>
    <?php
}
?>
</table>
<input type="submit" />
</form>
