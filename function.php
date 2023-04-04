<?php
	/**
	 * pje - PHP jquery UI editor
	 *
	 * @see https://github.com/coyote333666/pje The pje GitHub project
	 *
	 * @author    Vincent Fortier <coyote333666@gmail.com>
	 * @copyright 2023 Vincent Fortier
	 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
	 * @note      This program is distributed in the hope that it will be useful - WITHOUT
	 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
	 * FITNESS FOR A PARTICULAR PURPOSE.
	 */

	function sortHeader($getParam, $pOrder, $label, $paramName)
	{
		$order			= "";
		$header			= "";

		if(isset($_GET[$paramName]))	
		{	
			$order	= $_GET[$paramName];				
			if($order == $pOrder . ' DESC')
			{
				$getParam[$paramName] = $pOrder . ' ASC';		
				$header .= "<th><a href='?" .  http_build_query($getParam) . "'>" . $label . "&darr;</a></th>";
			}
			elseif($order == $pOrder . ' ASC')
			{
				$getParam[$paramName] = $pOrder . ' DESC';
				$header .= "<th><a href='?" .  http_build_query($getParam) . "'>" . $label . "&uarr;</a></th>";
			}
			else
			{
				$getParam[$paramName] = $pOrder . ' ASC';
				$header .= "<th><a href='?" .  http_build_query($getParam) . "'>" . $label . "</a></th>";
			}
		}
		else
		{
			$getParam[$paramName] = $pOrder . ' ASC';
			$header .= "<th><a href='?" .  http_build_query($getParam) . "'>" . $label . "</a></th>";
		}

		return ($header);

	}

	function fncQueryPg
	(
		$pQuery		= "SELECT 1"
		, $pServer		= PG_SERVER
		, $pUsername	= PG_USERNAME
		, $pPassword	= PG_PASSWORD
		, $pDatabase	= PG_DATABASE
		, $pPort		= PG_PORT		
	)
	{

		$ressource	= array();
		$row		= array();
		$recordset	= array();
		
		$connection = pg_connect("host=" . $pServer . " port=" . $pPort . " dbname=" . $pDatabase . " user=" . $pUsername . " password=" . $pPassword);

		if( $connection === false ) 
		{
    	die( print_r( pg_last_error(), true));
		}
 		$ressource = pg_query($connection, $pQuery);
		$num_rows = pg_num_rows($ressource);

		if(!is_bool($ressource))
		{
			$y = 0;	
			while($row = pg_fetch_array($ressource, null, PGSQL_ASSOC))
			{			
				for($x=0; $x<pg_num_fields($ressource); $x++)
				{
					$fieldName	= pg_field_name($ressource, $x);

					if($y == 0)
					{
						$fieldType	= pg_field_type($ressource, $x);
						$fieldSize	= pg_field_size($ressource, $x);
					
						$recordset[$y][$fieldName]['FIELD_NAME']	= $fieldName;
						$recordset[$y][$fieldName]['FIELD_TYPE']	= $fieldType;
						$recordset[$y][$fieldName]['FIELD_SIZE']	= $fieldSize;
					}
					
					$recordset[$y][$fieldName]['VALUE'] = $row[$fieldName];
				}
				
				$y ++;
			}
	
			pg_free_result($ressource);
		}
		pg_close($connection);
		
		unset($row);
		unset($ressource);
		
		return($recordset);
	}

	// Returns the execution time of a page
	function fncLoadTime($pFormat = "ms", $pPrecision = 2, $pMicrotime = LOAD_START)
	{
		// Running time in seconds
		$loadTime = microtime(true) - $pMicrotime;
		
		switch($pFormat)
		{
			case "ms"	: $iMultiplicator = 1000;	break;
			case "s"	: $iMultiplicator = 1;		break;
		}
		
		// Convert the time to the appropriate format
		$loadTime *= $iMultiplicator;
		
		// Round off time to a specified number of decimal places
		$loadTime = round($loadTime * pow(10, $pPrecision)) / pow(10, $pPrecision);
		
		// Returns the formatted value
		return($loadTime);
	}

	function fncGetLoadTime($pMicrotime = LOAD_START)
	{
		$pLoadTime = fncLoadTime('s', 2, $pMicrotime);
	
		if(floatval($pLoadTime) > 1)
		{
			return($pLoadTime . " seconds");
		}
		
		else
		{
			return($pLoadTime . " seconds");
		}
	}

	/**
	* Show pagination where this function is called
	* @param string $url 			The URL or name of the page calling the function, ex: 'index.php' or 'http://example.com/'
	* @param string $link 			The name of the parameter for the page displayed in the URL, ex: '?page=' or '?&p='
	* @param int $total 			The total number of pages
	* @param int $current 			The number of the current page
	* @param int $adj (optional) 	The number of pages displayed on each side of the current page (default: 3)
	* @return 						The character string used to display the pagination
	*/

	function paginate($urlGET, $link, $total, $current, $adj=3) {
		// Initialization of variables
		if(isset($urlGET["currentPage"]))			{	unset($urlGET["currentPage"]);			} 
		$url = '?' . http_build_query($urlGET);
		$prev = $current - 1; // previous page number
		$next = $current + 1; // next page number
		$penultimate = $total - 1; // penultimate page number
		$pagination = ''; // return variable of the function: empty as long as there are not at least 2 pages

		if ($total > 1) {
			// Filling of the character string to return
			$pagination .= "<div class=\"pagination\">\n";

			/* =================================
			 *  Display of the [previous] button
			 * ================================= */
			if ($current == 2) {
				// the current page is 2, the button therefore returns to page 1
				$pagination .= "<a href=\"{$url}{$link}1\">&larr;</a>";
			} elseif ($current > 2) {
				// the current page is greater than 2, the button returns to the page whose number is immediately lower
				$pagination .= "<a href=\"{$url}{$link}{$prev}\">&larr;</a>";
			} else {
				// in all the others, if the page is 1: deactivation of the [previous] button
				$pagination .= '<span class="inactive">&larr;</span>';
			}

			/**
			 * Beginning of page display, the example takes up the case of 3 adjacent page numbers (by default) on each side of the current number
			 * - CASE 1: there are at most 12 pages, insufficient to make a truncation
			 * - CASE 2: there are at least 13 pages, we perform the truncation to display 11 page numbers in total
			 */

			/* ===============================================
			 *  CASE 1: at most 12 pages -> no truncation
			 * =============================================== */
			if ($total < 7 + ($adj * 2)) {
				// Addition of page 1: we treat it outside the loop to have only index.php instead of index.php? P = 1 and thus avoid duplicate content
				$pagination .= ($current == 1) ? '<span class="active">1</span>' : "<a href=\"{$url}{$link}1\">1</a>"; // Opérateur ternaire : (condition) ? 'valeur si vrai' : 'valeur si fausse'

				// For the remaining pages we use iterates
				for ($i=2; $i<=$total; $i++) {
					if ($i == $current) {
						// The number of the current page is highlighted (cf. CSS)
						$pagination .= "<span class=\"active\">{$i}</span>";
					} else {
						// The others are displayed normally
						$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
					}
				}
			}
			/* =========================================
			 *  CASE 2: at least 13 pages -> truncation
			 * ========================================= */
			else {
				/**
				 * Truncation 1: we are in the part close to the first pages, so we truncate the end of the pagination.
				 * the display will be nine page numbers on the left ... two on the right
				 * 1 2 3 4 5 6 7 8 9 … 16 17
				 */
				if ($current < 2 + ($adj * 2)) {
					// Display of page number 1
					$pagination .= ($current == 1) ? "<span class=\"active\">1</span>" : "<a href=\"{$url}{$link}1\">1</a>";

					// then the next eight
					for ($i = 2; $i < 4 + ($adj * 2); $i++) {
						if ($i == $current) {
							$pagination .= "<span class=\"active\">{$i}</span>";
						} else {
							$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
						}
					}

					// ... to mark the truncation
					$pagination .= '&hellip;';

					// and finally the last two numbers
					$pagination .= "<a href=\"{$url}{$link}{$penultimate}\">{$penultimate}</a>";
					$pagination .= "<a href=\"{$url}{$link}{$total}\">{$total}</a>";
				}
				/**
				 * Truncation 2: we are in the central part of our pagination, so we truncate the beginning and the end of the pagination.
				 * the display will be two page numbers on the left ... seven in the center ... two on the right
				 * 1 2 … 5 6 7 8 9 10 11 … 16 17
				 */
				elseif ( (($adj * 2) + 1 < $current) && ($current < $total - ($adj * 2)) ) {
					// Display of numbers 1 and 2
					$pagination .= "<a href=\"{$url}{$link}1\">1</a>";
					$pagination .= "<a href=\"{$url}{$link}2\">2</a>";
					$pagination .= '&hellip;';

					// the middle pages: the three preceding the current page, the current page, then the three following it
					for ($i = $current - $adj; $i <= $current + $adj; $i++) {
						if ($i == $current) {
							$pagination .= "<span class=\"active\">{$i}</span>";
						} else {
							$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
						}
					}

					$pagination .= '&hellip;';

					// and the last two numbers
					$pagination .= "<a href=\"{$url}{$link}{$penultimate}\">{$penultimate}</a>";
					$pagination .= "<a href=\"{$url}{$link}{$total}\">{$total}</a>";
				}
				/**
				 * Truncation 3: we are on the right-hand side, so we truncate the start of the pagination.
				 * the display will be two page numbers on the left ... nine on the right
				 * 1 2 … 9 10 11 12 13 14 15 16 17
				 */
				else {
					// Display of numbers 1 and 2
					$pagination .= "<a href=\"{$url}{$link}1\">1</a>";
					$pagination .= "<a href=\"{$url}{$link}2\">2</a>";
					$pagination .= '&hellip;';

					// then the last nine issues
					for ($i = $total - (2 + ($adj * 2)); $i <= $total; $i++) {
						if ($i == $current) {
							$pagination .= "<span class=\"active\">{$i}</span>";
						} else {
							$pagination .= "<a href=\"{$url}{$link}{$i}\">{$i}</a>";
						}
					}
				}
			}

			/* ===============================
			 * Display of the [next] button
			 * =============================== */
			if ($current == $total)
				$pagination .= "<span class=\"inactive\">&rarr;</span>\n";
			else
				$pagination .= "<a href=\"{$url}{$link}{$next}\">&rarr;</a>\n";

			// Closing the display <div>
			$pagination .= "</div>\n";
		}

		return ($pagination);
	}
		
	function fncDisplayTableEditor($getParam, $pResult = array(), $pFileIndex = "", $pLinesPerPage)
	{			
		$table = "<table class='table table-striped table-bordered' id='exptable' border='1px' cellpadding='0px' cellspacing='0px'>";

		if(sizeof($pResult) > 0)
		{
			$colSpan = sizeof($pResult[0]);
		}
		else
		{
			$colSpan = 1;
		}
			
		if(sizeof($pResult))
		{
			
			$table .= "<tr>";

			$y=1;
			foreach($pResult[0] as $key => $value)
			{
				$table .= sortHeader($getParam, $y, $key, "order");
				$y++;
			}

			$table .= "<th>Edit</th><th>Delete</th>";
			
			$table .= "</tr>";
			
			for($y=0; $y<sizeof($pResult); $y++)
			{
				$table .= "<tr class='alternate'>";
				
				foreach($pResult[$y] as $key => $value)
				{
					$table .= "<td>" . $pResult[$y][$key]['VALUE'] . "</td>";
				}
				
				$table .= "<td><button type='button' name='edit' class='btn btn-primary btn-xs edit' id='" . $pResult[$y]['id']['VALUE'] . 
				"'>Edit</button></td>
				<td><button type='button' name='delete' class='btn btn-danger btn-xs delete' id='" . $pResult[$y]['id']['VALUE'] . 
				"'>Delete</button></td>";

				$table .= "</tr>";
			}
		}
		
		else
		{
			$table .= "<tr>";
			$table .= "<td>no results</td>";
			$table .= "</tr>";
		}
		
		$table .= "</table></div><br /></div>";

		$table .= "<p>"; 

		$table .= "</p>";

		$table .= "<form method='get'>";
		$table .= "Lines/page :";
    $table .= "<input type='hidden' name='page' value='";
		$table .= $pFileIndex; 
		$table .= "'>";
		$table .= "<tr>
		<td colspan='";
		$table .= $colSpan;		
		$table .= "'> <select name='linesPerPage'>";

		$table .= "<option value='5'";
		if($pLinesPerPage == 5) {$table .= " selected='selected'";} 
		$table .= ">5 lines</option>";

		$table .= "<option value='20'";
		if($pLinesPerPage == 20) {$table .= " selected='selected'";} 
		$table .= ">20 lines</option>";

		$table .= "<option value='50'";
		if($pLinesPerPage == 50) {$table .= " selected='selected'";} 
		$table .= ">50 lines</option>";

		$table .= "<option value='100'";
		if($pLinesPerPage == 100) {$table .= " selected='selected'";} 
		$table .= ">100 lines</option>";

		$table .= "<option value='500'";
		if($pLinesPerPage == 500) {$table .= " selected='selected'";} 
		$table .= ">500 lines</option>";

		$table .= "		</select>
		<input type='Submit' name='oSubmit' value='Apply'>
		</td>
		</tr>";
		$table .= "</form>";
		
		return($table);
	}


	
?>

