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

	session_start();

	require_once('constant.php');

	require_once(FILE_FUNCTION);

	if(($_POST["page"] !== 'false') AND isset($_POST["page"]))
	{
		require_once($_POST["page"]);
	}
	else
	{
		$_POST["page"] = FILE_DEMO;
		require_once(FILE_DEMO);
	}
	



?>

