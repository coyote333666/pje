<script>
	/**
	 * pje2 - PHP jquery UI editor
	 *
	 * @see https://github.com/coyote333666/pje2 The pje2 GitHub project
	 *
	 * @author    Vincent Fortier <coyote333666@gmail.com>
	 * @copyright 2023 Vincent Fortier
	 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
	 * @note      This program is distributed in the hope that it will be useful - WITHOUT
	 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
	 * FITNESS FOR A PARTICULAR PURPOSE.
	 */


sessionStorage.setItem("linesPerPage",5);
sessionStorage.setItem("currentPage",1);
sessionStorage.setItem("order",1);
sessionStorage.setItem("direction","ASC");

$(document).ready(function(){  

	$("select.lpp").change(function(){
	  var selectedLpp = $(this).children("option:selected").val();
		sessionStorage.setItem("linesPerPage",selectedLpp);
		sessionStorage.setItem("currentPage",1);
		load_data();
	});

	$(document).on('click', '.page-item', function(){
		var id = $(this).attr("id");
		sessionStorage.setItem("currentPage",id);
		load_data();
	});

	$(document).on('click', '.column-header', function(){
		var colOrder = $(this).attr("id");
		if(sessionStorage.getItem("order") == colOrder)
		{
			if(sessionStorage.getItem("direction") == 'ASC')
			{
				sessionStorage.setItem("direction",'DESC');
			}
			else
			{
				sessionStorage.setItem("direction",'ASC');
			}
		}
		sessionStorage.setItem("order",colOrder);
		load_data();
	});

	load_data();
	
	function load_data()
	{
		$.ajax({
			url: '<?php echo(DIR_APP . FILE_DEMO_FETCH); ?>',
			method: "POST",
			data: { 
    		linesPerPage: sessionStorage.getItem("linesPerPage"), 
    		currentPage: sessionStorage.getItem("currentPage"), 
    		order: sessionStorage.getItem("order") + " " + sessionStorage.getItem("direction")
 			},			
			success:function(data)
			{
				$('#user_data').html(data);
			}
		});
	}
   
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
				url: '<?php echo(DIR_APP . FILE_DEMO_ACTION); ?>',
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#user_dialog').dialog('close');
					$('#action_alert').html(data);
					$('#action_alert').dialog('open');
					load_data();
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
			url: '<?php echo(DIR_APP . FILE_DEMO_ACTION); ?>',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				console.log("clic sur edit");
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
					url: '<?php echo(DIR_APP . FILE_DEMO_ACTION); ?>',
					method:"POST",
					data:{id:id, action:action},
					success:function(data)
					{
						$('#delete_confirmation').dialog('close');
						$('#action_alert').html(data);
						$('#action_alert').dialog('open');
						load_data();
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
