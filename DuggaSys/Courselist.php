<html>
<html>
	<head>
			<link type="text/css" href="../CodeViewer/css/codeviewer.css" rel="stylesheet" />	
			<script type="text/javascript" src="../CodeViewer/js/jquery-1.5.1.min.js"></script>
			<script type="text/javascript" src="duggasys.js"></script>

			<script>
			</script>
			<body>
					<?php
						include_once("../Shared/coursesyspw.php");
						include_once("../Shared/database.php");
						include_once("basic.php");

						session_start();
						dbConnect();

						courselist();
					?>			

			</body>
</html>