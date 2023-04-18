<?php

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
