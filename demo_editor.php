<script>
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
 	bootstrap: false
});	

$(document).ready(function(){  
   
	$("#user_dialog").dialog({
		autoOpen:false,
		width:400
	});

	$('#add').click(function(){
		$('#user_dialog').attr('title', 'Add Data');
		$('#action').val('insert');
		$('#form_action').val('Insert');
		$('#user_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$("#user_dialog").dialog('open');
	});

	$('#user_form').on('submit', function(event){
		event.preventDefault();
		var error_column_1 = '';
		var error_column_2 = '';
		var error_column_3 = '';
		if($('#column_1').val() == '')
		{
			error_column_1 = 'Column 1 is required';
			$('#error_column_1').text(error_column_1);
			$('#column_1').css('border-color', '#cc0000');
		}
		else
		{
			error_column_1 = '';
			$('#error_column_1').text(error_column_1);
			$('#column_1').css('border-color', '');
		}
		if($('#column_2').val() == '')
		{
			error_column_2 = 'Column 2 is required';
			$('#error_column_2').text(error_column_2);
			$('#column_2').css('border-color', '#cc0000');
		}
		else
		{
			error_column_2 = '';
			$('#error_column_2').text(error_column_2);
			$('#column_2').css('border-color', '');
		}
		if($('#column_3').val() == '')
		{
			error_column_2 = 'Column 3 is required';
			$('#error_column_3').text(error_column_2);
			$('#column_3').css('border-color', '#cc0000');
		}
		else
		{
			error_column_3 = '';
			$('#error_column_3').text(error_column_3);
			$('#column_3').css('border-color', '');
		}

		if(error_column_1 != '' || error_column_2 != '' || error_column_3 != '')
		{
			return false;
		}
		else
		{
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url: '<?php echo(PARAMETER_REDIRECTOR . FILE_DEMO_ACTION); ?>',
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#user_dialog').dialog('close');
					$('#action_alert').html(data);
					$('#action_alert').dialog('open');
					window.location.reload();
					$('#form_action').attr('disabled', false);
				}
			});
		}

	});

	$('#action_alert').dialog({
		autoOpen:false
	});

	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single';
		$.ajax({
			url: '<?php echo(PARAMETER_REDIRECTOR . FILE_DEMO_ACTION); ?>',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#column_1').val(data.column_1);
				$('#column_2').val(data.column_2);
				$('#column_3').val(data.column_3);
				$('#user_dialog').attr('title', 'Edit Data');
				$('#action').val('update');
				$('#hidden_id').val(id);
				$('#form_action').val('Update');
				$('#user_dialog').dialog('open');
			}
		});
	});

	$('#delete_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var id = $(this).data('id');
				var action = 'delete';
				$.ajax({
					url: '<?php echo(PARAMETER_REDIRECTOR . FILE_DEMO_ACTION); ?>',
					method:"POST",
					data:{id:id, action:action},
					success:function(data)
					{
						$('#delete_confirmation').dialog('close');
						$('#action_alert').html(data);
						$('#action_alert').dialog('open');
						window.location.reload();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});

	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		$('#delete_confirmation').data('id', id).dialog('open');
	});

});  
</script>
