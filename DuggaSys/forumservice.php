<?php
date_default_timezone_set("Europe/Stockholm");

// Include basic application services!
include_once "../Shared/sessions.php";
include_once "../Shared/basic.php";

// Connect to database and start session
pdoConnect();
session_start();

$log_uuid = getOP('log_uuid');
$log_timestamp = getOP('log_timestamp');

logServiceEvent($log_uuid, EventTypes::ServiceClientStart, "forumservice.php", $log_timestamp);
logServiceEvent($log_uuid, EventTypes::ServiceServerStart, "forumservice.php");

if(isset($_SESSION['uid'])){
	$userid=$_SESSION['uid'];
}else{
	$userid="1";
}

$cid = getOP('cid');

$uid = getOP('uid');

$opt = getOP('opt');
$threadId = getOP('threadId');

$debug="NONE!";

//------------------------------------------------------------------------------------------------
// Services
//------------------------------------------------------------------------------------------------

if(checklogin())
{
	if(strcmp($opt,"GETTHREAD")===0){
		$query = $pdo->prepare("SELECT * FROM thread WHERE threadID=:threadId");
		$query->bindParam(':threadId', $threadId);

		if(!$query->execute()){
			$error=$query->errorInfo();
			exit($debug);

		}else{
			$comments = $query->fetch(PDO::FETCH_ASSOC);
		}
	}

}

//------------------------------------------------------------------------------------------------
// Retrieve Information
//------------------------------------------------------------------------------------------------

if(checklogin() && (hasAccess($userid, $cid, 'w') || isSuperUser($userid))){


}

$array = array(
	'comments' => $comments
	);
/*$t = json_encode($array);
if (!$t){
	echo "Failed: ". $t;
} else {
	echo "success: ". $t;
}*/
echo json_encode($array);

logServiceEvent($log_uuid, EventTypes::ServiceServerEnd, "forumservice.php");

?>
