<?php

	

	if(($_POST["whereClause"] !== '') AND isset($_POST["whereClause"]))
	{
		$query .=	"WHERE column_1::varchar LIKE '%" . $_POST["whereClause"] . "%' 
		OR column_2::varchar LIKE '%" . $_POST["whereClause"] . "%' 
		OR column_3 LIKE '%" . $_POST["whereClause"] . "%' 
		";
	}	

	if(isset($_POST["order"]))
	{
		$query .=	"ORDER BY " . $_POST["order"] ;
		$order = $_POST["order"];
	}	
	else
	{
		$query .= "ORDER BY 1";
		$order = "1 ASC";
	}

	if(isset($_POST["linesPerPage"]))
  	{	
  	  $linesPerPage 			= $_POST["linesPerPage"];			
  	} 
  	else 
  	{
  	  $linesPerPage					= 5;
  	}

	if(isset($_POST["currentPage"]))
  	{	
  	  $currentPage 				= $_POST["currentPage"];		
  	} 
  	else 
  	{
  	  $currentPage					= 1;
  	}

	$queryCount = "SELECT count(1) as \"Count\" FROM (" . $query . ") s1";	

	$recCount = fncQueryPg($queryCount);

	$pageCount = ceil($recCount[0]["Count"]["VALUE"]/$linesPerPage);

	$query .= PHP_EOL . "LIMIT " . $linesPerPage . " OFFSET " . (($currentPage-1) * $linesPerPage);

	# display query 
	# echo('<pre>' . $query . '</pre>');
	# exit();
	
	$recordset = fncQueryPg($query);
		
	if (sizeof($recordset) == 0)
	{
		echo("<br>");
		echo("No results!");
		exit();
	}

	echo(fncDisplayTableEditor($order, $recordset));	
	
	if(((($currentPage-1)*$linesPerPage)+$linesPerPage) > $recCount[0]["Count"]["VALUE"])
	{
		$lineCount = $recCount[0]["Count"]["VALUE"]-(($currentPage-1)*$linesPerPage);
	}
	else
	{
		$lineCount = $linesPerPage;
	}
	echo("Results : from " . ((($currentPage-1)*$linesPerPage)+1) . " to " . ((($currentPage-1)*$linesPerPage)+$lineCount) . ", of " . $recCount[0]["Count"]["VALUE"] . " (" . fncGetLoadTime() . ")</p>");
	echo paginateEditor($pageCount, $currentPage);
	echo('<br>');

?>