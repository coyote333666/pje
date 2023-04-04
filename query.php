<?php
	
	$queryCount = "SELECT count(1) as \"Count\" FROM (" . $query . ") s1";	

	$recCount = fncQueryPg($queryCount);

	$pageCount = ceil($recCount[0]["Count"]["VALUE"]/$linesPerPage);

	$query .= PHP_EOL . "LIMIT " . $linesPerPage . " OFFSET " . (($currentPage-1) * $linesPerPage);

	# display query 
	# echo('<pre>' . $query . '</pre>');
	
	$recordset = fncQueryPg($query);
		
	if (sizeof($recordset) == 0)
	{
		echo("<br>");
		echo("No results!");
		exit();
	}

?>