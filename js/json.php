<?php 

echo"jkjkjk";
if($_GET['searchword'])
{
$q=$_GET['searchword'];
$items = array();
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'agemodern2');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
echo"ffff";
 // Includes database connection settings.
$sql_res=mysql_query("select user_id,email,first_name,last_name from users where email like '%$q%' or first_name like '%$q%' or last_name like '%$q%'  LIMIT 5");
while($row=mysql_fetch_array($sql_res))
{
$uid = $row['user_id'];
$username=$row['email'];
$email=$row['first_name'];
$media=$row['last_name'];

$b_username='<b>'.$q.'</b>';
$b_email='<b>'.$q.'</b>';
$b_country='<b>'.$q.'</b>';
$final_username = str_ireplace($q, $b_username, $username);
$final_email = str_ireplace($q, $b_email, $email);

$items[] = array('uid' => $uid, 'username' => $final_username, 'email' => $final_email);
}
header('Content-Type:text/json');
echo json_encode($items);
}
else{
	echo json_encode('No search string found');
}
?>
