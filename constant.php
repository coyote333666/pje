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


define("FILE_FUNCTION"		, "function.php");
define("FILE_INDEX"				, "index.php");
define("FILE_QUERY"				, "query.php");
define("FILE_DEMO"				, "demo.php");
define("FILE_DEMO_FETCH"	, "demo_fetch.php");
define("FILE_DEMO_ACTION"	, "demo_action.php");
define("FILE_DEMO_EDITOR"		, "demo_editor.php");
define("APP_TITLE"				, "Demo pje PHP Jquery UI Editor");
define("DIR_APP"					, "/pje/");
define("PARAMETER_REDIRECTOR"	, "?page=");
define("FILE_HEADER"			, "header.html");
define("PG_SERVER"				, "localhost");
define("PG_USERNAME"			, "test");
define("PG_PASSWORD"			, "test");
define("PG_DATABASE"			, "test");
define("PG_PORT"				, "5432");						
define("LOAD_START"				, microtime(true));

// JQuery
define("DIR_JQUERY"			, "../node_modules/jquery/dist/");
define("FILE_JQUERY"			, DIR_JQUERY	. "jquery.min.js");

// JQuery UI
define("DIR_JQUERY_UI"		, "../node_modules/jquery-ui/dist/");
define("FILE_JQUERY_UI_JS"	, DIR_JQUERY_UI	. "jquery-ui.min.js");
define("FILE_JQUERY_UI_CSS"	, DIR_JQUERY_UI	. "themes/smoothness/jquery-ui.min.css");

// Bootstrap
define("DIR_BOOTSTRAP"			, "../node_modules/bootstrap/dist/");
define("FILE_BOOTSTRAP_JS"			, DIR_BOOTSTRAP	. "js/bootstrap.min.js");
define("FILE_BOOTSTRAP_CSS"			, DIR_BOOTSTRAP	. "css/bootstrap.min.css");

// TableExport.js
define("FILE_DIR_NODE_MODULES"		, "../node_modules/");		
define("FILE_XLSX_JS"		, FILE_DIR_NODE_MODULES . "xlsx/dist/xlsx.full.min.js");	
define("FILE_FILESAVER_JS"	, FILE_DIR_NODE_MODULES . "file-saverjs/FileSaver.min.js");	
define("FILE_TABLEXPORT_JS"	, FILE_DIR_NODE_MODULES . "tableexport/dist/js/tableexport.min.js");	
define("FILE_TABLEXPORT_CSS"	, FILE_DIR_NODE_MODULES . "tableexport/dist/css/tableexport.min.css");	

?>