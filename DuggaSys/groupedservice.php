<?php
date_default_timezone_set("Europe/Stockholm");

// Include basic application services!
include_once "../Shared/sessions.php";
include_once "../Shared/basic.php";

// Connect to database and start session
pdoConnect();
session_start();

if(isset($_SESSION['uid'])){
	$userid=$_SESSION['uid'];
	$loginname=$_SESSION['loginname'];
	$lastname=$_SESSION['lastname'];
	$firstname=$_SESSION['firstname'];
}else{
	$userid=1;
	$loginname="UNK";		
	$lastname="UNK";
	$firstname="UNK";
} 	

// Options from AJAX 
$opt = getOP('opt');
$cid = getOP('cid'); // Course id
$vers = getOP('vers'); // Course version
$listentry = getOP('moment');
$qvariant=getOP("qvariant");

$data = []; // Array that contains all data generated by the queries in this file. To be written to JSON. 

$debug="NONE!"; // How is this used? Is it neccessary?

// Don't retreive all results if request was for a single dugga or a grade update
// if(strcmp($opt,"GET")==0){
 	// if(checklogin() && (hasAccess($_SESSION['uid'], $cid, 'w') || isSuperUser($_SESSION['uid']))) {

		// First query: get the headings for the table, which is the listentry names. 
		$query = $pdo->prepare("SELECT listentries.*,quizFile,COUNT(variant.vid) as qvariant FROM listentries LEFT JOIN quiz ON  listentries.link=quiz.id LEFT JOIN variant ON quiz.id=variant.quizID WHERE listentries.cid=:cid and listentries.vers=:vers and (listentries.kind=4) AND (listentries.grouptype=1 OR listentries.grouptype=3) GROUP BY lid ORDER BY pos;");

		$cid = 2;
		$vers = 97732;

		$query->bindParam(':cid', $cid);
		$query->bindParam(':vers', $vers);

		if(!$query->execute()) {
			$error=$query->errorInfo();
			$debug="Error retreiving moments and duggas. (row ".__LINE__.") ".$query->rowCount()." row(s) were found. Error code: ".$error[2];
		}

		$currentMoment=null; // This is a mystery

		$headings = []; // Create a array that holds the headings. 

		// Save the headings for the table 
		foreach($query->fetchAll(PDO::FETCH_ASSOC) as $row){
			array_push(
				$headings,
				array(
					'entryname' => $row['entryname'],
					'lid' => (int)$row['lid'],
					'kind' => (int)$row['kind'],
					'moment' => (int)$row['moment'],
					'visible'=> (int)$row['visible']
				)
			);
		}

		// Put it in the data array
		$data['headings'] =$headings;

		// Second query: select all users that are in a group, belonging to the cid and the course vers. This makes up the first and second column of the data table. This data is processed in a later step, because the connection to each moment is needed to display the data. 
		$query = $pdo->prepare("SELECT GROUP_CONCAT(DISTINCT u.username SEPARATOR '\n') AS students, ug.name AS groupname, ug.ugid FROM user AS u, usergroup AS ug, user_usergroup AS uug, listentries AS le, usergroup_listentries AS ugl WHERE u.uid = uug.uid AND uug.ugid = ug.ugid AND ug.ugid = ugl.ugid AND ugl.lid = le.lid AND le.cid = :cid AND le.kind = 4 AND le.vers = :vers GROUP BY ug.name");

		$query->bindParam(':cid', $cid);
		$query->bindParam(':vers', $vers);
		
		if(!$query->execute()) {
			$error=$query->errorInfo();
			$debug="Error retreiving moments and duggas. (row ".__LINE__.") ".$query->rowCount()." row(s) were found. Error code: ".$error[2];
		}

		// Get the first two columns, which is the students and their groups. Save this information, and set the group assignments after the next query. 
		$studentAndGroupRows = $query->fetchAll(PDO::FETCH_ASSOC); // 2 rows initially. (count = 2)

		// Third query, get what listentry each group is associated with. 
		$query = $pdo->prepare("SELECT listentries.lid, usergroup_listentries.ugid FROM listentries LEFT OUTER JOIN usergroup_listentries on listentries.lid = usergroup_listentries.lid WHERE listentries.cid = :cid AND listentries.vers = :vers AND listentries.kind = 4 AND (listentries.grouptype=1 OR listentries.grouptype=3)");

		$query->bindParam(':cid', $cid);
		$query->bindParam(':vers', $vers);

		if(!$query->execute()) {
			$error=$query->errorInfo();
			$debug="Error retreiving moments and duggas. (row ".__LINE__.") ".$query->rowCount()." row(s) were found. Error code: ".$error[2];
		}

		// Assigned courses
		$assignedCourses = $query->fetchAll(PDO::FETCH_ASSOC);

		// Create array to hold the table contents. 
		$tableContent = [];

		/*
			$studentAndGroupsRows
			+----------+------------+------+
			| students | groupname  | ugid |
			+----------+------------+------+
			| c13timan | testsquad1 | 1    |
			| a13eydth |            |      |
			+----------+------------+------+
			| stei     | testsquad2 | 2    |
			+----------+------------+------+

			$assignedCourses
			+------+------+
			| lid  | ugid |
			+------+------+
			| 2001 | 1    |
			+------+------+
			| 2013 | 1    |
			+------+------+
			| 2013 | 2    |
			+------+------+
	
			$result
			+----------+------------+------+--------+--------+
			| students | groupname  | ugid |        |        |
			+----------+------------+------+--------+--------+
			| c13timan | testsquad1 | 1    | [2001] | [2013] |
			| a13eydth |            |      | true   | true   |
			+----------+------------+------+--------+--------+
			| stei     | testsquad2 | 2    | [2001] | [2013] |
			|          |            |      | false  | true   |
			+----------+------------+------+--------+--------+

			Hur kan man göra detta... Om man kunde ta fram endast de unika lidsen, och sätta dem först, sedan sätta in respektive true och false. Det borde fungera. 
		*/

		// Maybe it is better if the database does this with a DISTINCT query. I dunno. 
		$uniqueLids = [];
		foreach($assignedCourses as $subArray) {
			foreach($subArray as $key => $val) {
				if($key == 'lid') {
					$uniqueLids[] = $val;
				}
			}
		}
		$uniqueLids = array_unique($uniqueLids); // 

		$keyTemplate = array_fill_keys($uniqueLids, 0);

		/*
			$uniqueLids blir såhär: 
			$uniqueLids = [
				0 => 2001,
				1 => 2013,
				...
			];

			Det här är önskvärt som slutresultat, per grupprad. Hur göra det.
			$arr = [
				'2001' => true,
				'2013' => false,
				...
			];	
		*/

		$rowNumber = 1;
		// For each group entry row, create the columns, linking each group to the associated listentry. 
		foreach($studentAndGroupRows as $dbRow) { // Loop through the number of rows. 

			// Create array for the row. 
			$row = [];
			
			// array_push($row, $dbRow['ugid']);
			$row['ugid'] = $dbRow['ugid'];
			// array_push($row, $cid);
			$row['cid'] = $cid;	
			// array_push($row, $dbRow['students']);
			$row['students'] = $dbRow['students'];
			// array_push($row, $dbRow['groupname']);
			$row['groupname'] = $dbRow['groupname'];

			// Iterate through the listentries, and add the list entry id where there is a match for the group. This should later be presented as some kind of boolean instead, to be able to use buttons. 
			$assignedLids = $keyTemplate;
			foreach ($assignedCourses as $dbCol) { // Iterate the assigned courses (what lids match which ugid). 
				foreach($assignedLids as $key => $val) {
					if($row['ugid'] == $dbCol['ugid']) {
						$assignedLids[$dbCol['lid']] = 1;
					}
				}
			}
			$row['assignedlids'] = $assignedLids;
			array_push($tableContent, $row);

			$rowNumber++;
		}
		$data['tableContent'] = $tableContent;
 	// }
// }

if(isset($_SERVER["REQUEST_TIME_FLOAT"])){
		$serviceTime = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];	
		$benchmark =  array('totalServiceTime' => $serviceTime);
}else{
		$benchmark="-1";
}

// This is possibly needed later, for debugging and benchmarking and such.
$array = array(
	/* 
	'data' => $data,
	'debug' => $debug,
	'moment' => $listentry,
	'benchmark' => $benchmark */
);

// Print only the $data contents array as JSON for now. 
echo json_encode($data);
// logServiceEvent($log_uuid, EventTypes::ServiceServerEnd, "resultedservice.php",$userid,$info);
?>
