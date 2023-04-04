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

		if(((($currentPage-1)*$linesPerPage)+$linesPerPage) > $recCount[0]["Count"]["VALUE"])
		{
			$lineCount = $recCount[0]["Count"]["VALUE"]-(($currentPage-1)*$linesPerPage);
		}
		else
		{
			$lineCount = $linesPerPage;
		}
		echo("<p>Results : from " . ((($currentPage-1)*$linesPerPage)+1) . " to " . ((($currentPage-1)*$linesPerPage)+$lineCount) . ", of " . $recCount[0]["Count"]["VALUE"] . " (" . fncGetLoadTime() . ")</p>");
		echo paginate($_GET, "&currentPage=", $pageCount, $currentPage);
		echo('<br>');

		
?>
