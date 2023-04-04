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

  require_once(FILE_HEADER);	

  echo('</head>');	
  echo('<body>');

?>

<div class='container'>
  <br />
    <h3 align='center'>DEMO PJE - PHP Jquery UI Editor</h3><br />
  <br />
  <div align='right' style='margin-bottom:5px;'>
    <button type='button' name='add' id='add' class='btn btn-success btn-xs'>Add</button>
  </div>
  <div class='table-responsive' id='user_data'>
  </div>
	<br />
</div>


<div id="user_dialog" title="Add Data">
  <form method="post" id="user_form">
    <div class="form-group">
      <label>Enter Column 1</label>
      <input type="text" name="column_1" id="column_1" class="form-control" />
      <span id="error_fcolumn_1" class="text-danger"></span>
    </div>
    <div class="form-group">
      <label>Enter Column 2</label>
      <input type="text" name="column_2" id="column_2" class="form-control" />
      <span id="error_column_2" class="text-danger"></span>
    </div>
    <div class="form-group">
      <label>Enter Column 3</label>
      <input type="text" name="column_3" id="column_3" class="form-control" />
      <span id="error_column_3" class="text-danger"></span>
    </div>
    <div class="form-group">
      <input type="hidden" name="action" id="action" value="insert" />
      <input type="hidden" name="hidden_id" id="hidden_id" />
      <input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
    </div>
  </form>
</div>
    
<div id="action_alert" title="Action">      
</div>
    
<div id="delete_confirmation" title="Confirmation">
  <p>Are you sure you want to Delete this data?</p>
</div>

<?php

  if(isset($_GET["linesPerPage"]))					{	$linesPerPage 			= $_GET["linesPerPage"];			} else {$linesPerPage					= 5;}
  if(isset($_GET["currentPage"]))						{	$currentPage 				= $_GET["currentPage"];		} else {$currentPage					= 1;}

  $query =
  "SELECT *" . PHP_EOL . 
  "FROM test"  . PHP_EOL;

  if(isset($_GET["order"]))
  {
  $query .=	"ORDER BY " . $_GET["order"] ;
  }	
  else
  {
  $query .= "ORDER BY 1";
  }

  require(FILE_QUERY);

  echo(fncDisplayTableEditor($_GET, $recordset, FILE_DEMO, $linesPerPage));	

  require(FILE_FOOTER);


  echo('</body>');
	echo('</html>');

  require(FILE_DEMO_EDITOR);

?>