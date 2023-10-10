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

$query =
"SELECT *" . PHP_EOL . 
"FROM test"  . PHP_EOL;

require_once(FILE_QUERY);

?>

<script>

var TabExp = document.getElementById('exptable');
  /*
  $(TabExp).tableExport({
      headers: true,
      footers: true,
      formats: ['xlsx', 'csv', 'txt'],
      filename: 'id',
      bootstrap: true,
      position: 'bottom',
      ignoreRows: null,
      ignoreCols: null,
      ignoreCSS: '.tableexport-ignore',
      emptyCSS: '.tableexport-empty',
      trimWhitespace: false,
      RTL: false,
      sheetname: 'id'
  });
	*/

$(TabExp).tableExport({
 	bootstrap: false,
	ignoreCols: [4,5]
});	

</script>
