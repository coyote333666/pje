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

require_once('constant.php');
	 
require_once(FILE_FUNCTION);
	
if(isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$queryInsert = "
		INSERT INTO test (column_1, column_2, column_3) VALUES ('".$_POST["column_1"]."', '".$_POST["column_2"]."', '".$_POST["column_3"]."')
		";
		# echo('<pre>' . $queryInsert . '</pre>');	
		echo '<p>Data Inserted...</p>';
		fncQueryPg($queryInsert);

	}
	if($_POST["action"] == "fetch_single")
	{
		$queryFetch = "
		SELECT * FROM test WHERE id = '".$_POST["id"]."'
		";
		# echo('<pre>' . $queryFetch . '</pre>');	
		$result = fncQueryPg($queryFetch);

		for($y=0; $y<sizeof($result); $y++)
		{	
			
			$output['column_1'] = $result[$y]['column_1']['VALUE'];
			$output['column_2'] = $result[$y]['column_2']['VALUE'];
			$output['column_3'] = $result[$y]['column_3']['VALUE'];

		}

		echo json_encode($output);
	}
	if($_POST["action"] == "update")
	{
		$queryUpdate = "
		UPDATE test 
		SET column_1 = '".$_POST["column_1"]."', 
		column_2 = '".$_POST["column_2"]."',
		column_3 = '".$_POST["column_3"]."'
		WHERE id = '".$_POST["hidden_id"]."'
		";
		# echo('<pre>' . $queryUpdate . '</pre>');	
		fncQueryPg($queryUpdate);
		echo '<p>Data Updated</p>';
	}
	if($_POST["action"] == "delete")
	{
		$queryDelete = "DELETE FROM test WHERE id = '".$_POST["id"]."'";
		# echo('<pre>' . $queryDelete . '</pre>');	
		fncQueryPg($queryDelete);
		echo '<p>Data Deleted</p>';
	}
}

?>