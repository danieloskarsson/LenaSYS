<?php 

		//---------------------------------------------------------------------------------------------------------------
		// editorService - Saves and Reads content for Code Editor
		//---------------------------------------------------------------------------------------------------------------
	
		// Check if example exists and then do operation
	
		date_default_timezone_set("Europe/Stockholm");
	
		// Include basic application services!
		include_once("../../coursesyspw.php");
		include_once("../Shared/sessions.php");
	
		// Connect to database and start session
		pdoConnect();
		session_start();
	
		$courseid=$_POST['courseid'];
		//$vers=$_POST['vers'];
		$opt=$_POST['opt'];		
		//$appuser="NOT YET IMPL";
		$exampleno=0;
		$success = true;

		if(isset($_POST['sectid'])) $sectid=htmlEntities($_POST['sectid']);
		if(isset($_POST['sectpos'])) $sectpos=htmlEntities($_POST['sectpos']);
		if(isset($_POST['sectname'])) $sectname=htmlEntities($_POST['sectname']);
		if(isset($_POST['pos'])) $pos=htmlEntities($_POST['pos']);
		if(isset($_POST['newname'])) $newname=htmlEntities($_POST['newname']);
		if(isset($_POST['kind'])) $kind=htmlEntities($_POST['kind']);
		
		$debug="NONE!";
		if(checklogin()){
			$ha = hasAccess($_SESSION['uid'], $courseid, 'w');
			if($ha){
				if (strcmp("sectionNew",$opt) === 0) {
					//$newsectpos = getqueryvalue("SELECT MAX(pos)+1 FROM listentries WHERE cid='$courseID';");
					$result = $pdo->query("INSERT INTO listentries (cid, entryname, link, kind, pos, creator, visible) VALUES(1, 'Ny sektion', NULL, 0, 6, 1, 1);");
					if(!$result->execute()) {
						echo "Error updating entries";
					}
				} else if (strcmp("sectionDel",$opt) === 0) {
					$query = $pdo->prepare("DELETE FROM listentries WHERE lid=:lid");
					$query->bindParam(':lid', $sectid);
					if(!$query->execute()) {
						echo "Error updating entries";
					}
				} else if(strcmp("updateEntries", $opt) === 0) {
					$sectionArray = $_POST['Entry'];

					$counter = 0;
					foreach ($sectionArray as $entryID) {
						$query = $pdo->prepare("UPDATE listentries SET pos=:pos WHERE lid =:lid");
						$query->bindParam(':pos', $counter);
						$query->bindParam(':lid', $entryID);
						if(!$query->execute()) {
							echo "Error updating entries";
						} else {
							$counter = $counter + 1;
						}
					}
				}
			}
		}

		//------------------------------------------------------------------------------------------------
		// Retrieve Information			
		//------------------------------------------------------------------------------------------------
		$ha = (checklogin() && hasAccess($_SESSION['uid'], $courseid, 'w'));
		$entries=array();
		$query = $pdo->prepare("SELECT lid,entryname,pos,kind,link,visible FROM listentries WHERE listentries.cid=:cid ORDER BY pos");
		$query->bindParam(':cid', $courseid);
		$result=$query->execute();
		if (!$result) err("SQL Query Error: ".$pdo->errorInfo(),"Field Querying Error!");
		foreach($query->fetchAll() as $row) {
			array_push(
				$entries,
				array(
					'entryname' => $row['entryname'],
					'lid' => $row['lid'],
					'pos' => $row['pos'],
					'kind' => $row['kind'],
					'link'=>$row['link'],
					'visible'=>$row['visible']
				)
			);
		}

		$array = array(
			'entries' => $entries,
			"debug" => $debug,
			'writeaccess' => $ha,
			'coursename' => getCourseName($courseid),
			'success' => $success
		);

		echo json_encode($array);
?>
