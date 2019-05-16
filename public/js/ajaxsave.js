
$(document).ready(function()
	{
		$('.ph_btn').click(function()
		{
			var phdata = {};
			phdata.no = $('.phone').val().trim();
			 $('#formPh').tmpl(phdata).appendTo('.ph_div');
		});

	$('body').on('click', '.del_btn', function(){
		// alert('hello');
		var delInput = $(this).closest('.cloneInput').remove();
	});
		$('.inputSub').click(function()
		{
			
			var data=getData();
			saveData(data);
			$('input[type=text]').val('');
		});
	
		function getData()
		{
			var data = {};
			 
		    data.name = $('.name').val().trim();
		    data.email = $('.email').val().trim();
		    data.address = $('.address').val().trim();
			data.parentname = $('.parentname').val().trim();
			data.phone = $('.phone').val().trim();

			var success = true;

			if (data.name =='') 
			 {
				$('.er-name').css("color","red").html("<i>fill u name</i>");
				success = false;
			 }
			 if (data.email =='') 
			 {
				$('.er-email').css("color","red").html("<i>fill u email</i>");
				success = false;
			 }
			 if (data.address =='') 
			 {
				$('.er-address').css("color","red").html("<i>fill u address</i>");
				success = false;
			 }
			 
			 if(!success) return ;
				return data;
		}

		function saveData(data)
		{
			$.ajax({
					type: 'POST',
					url: '/student/ajaxsave',
					cache: false,
					data:{
						ins_name:data.name,
						ins_email:data.email,
						ins_address:data.address,
						ins_parentname:data.parentname,
						ins_phone:data.phone
						},
					dataType:'json'
				}).done(function(data)
				{
				
					if(data == 'success')
					{

						window.location.reload();
						
					}
					if(data == 'fail')
					{
						alert("fail");
						return false;
					}
				});
		}

		$('.del').click(function(){
		var _this = $(this);
		var id = $(this).prev('.remId').val();
		$.ajax({
			type: 'POST',
			url: '/student/ajaxdelete',
			cache: false,
			data: {
				rem_id: id
			},
			dataType: 'json'
		}).done(function(data) {
			if(data == 'success'){
				$(_this).closest('tr').remove();
			} else {
				alert('Failed to remove');
				return false;
			}
		});
	});
});
