function fun_add_user(e)
{
	var formData = [];
	var element_s = $("."+e.form.name).find('input[type="text"],input[type="email"], input[type="date"], textarea, select').each(function(i, field) {
		key = field.name;//debugger;
		value = field.value;
		formData[i] = {key : key,value : value};
	});
	console.log(formData);
	var var_name = "#"+e.form.name+"_file";
    var file_data = $(var_name).prop('files')[0];
    var form_data = new FormData();
	form_data.append('file', file_data);
	form_data.append('tbl_name', 'tbl_users');
	form_data.append('data', JSON.stringify(formData));
	form_data.append('directory', $("."+e.form.name+' input[name="directory"]').val());
	form_data.append('image_name', $("."+e.form.name+' input[name="file_name"]').val());
	 $.ajax({
       url: "index.php/api/add_user",
        dataType: 'json', 
		data: form_data,
		type: 'post',
			cache: false,
			contentType: false,
			processData: false,
        success: function(data)
		{
			console.log(data);
            //alert(data.message);
			//$('form')[0].reset();
			//location.reload();
        },
		error: function(data)
		{
			alert('error');
		}
      });
}
function fun_update_user(e)
{
	var formData = [];
	var element_s = $("."+e.form.name).find('input[type="text"],input[type="checkbox"],input[type="email"], input[type="date"], textarea, select').each(function(i, field) {
		key = field.name;//debugger;
		value = field.value;
		formData[i] = {key : key,value : value};
	});
	console.log(formData);
	var var_name = "#"+e.form.name+"_file";
    var file_data = $(var_name).prop('files')[0];
    var form_data = new FormData();
	form_data.append('file', file_data);
	form_data.append('tbl_name', 'tbl_users');
	form_data.append('data', JSON.stringify(formData));
	form_data.append('directory', $("."+e.form.name+' input[name="directory"]').val());
	form_data.append('id', $("."+e.form.name+' input[name="id"]').val());
	form_data.append('image_name', $("."+e.form.name+' input[name="file_name"]').val());
	 $.ajax({
       url: "index.php/api/update_user",
        dataType: 'json', 
		data: form_data,
		type: 'post',
			cache: false,
			contentType: false,
			processData: false,
        success: function(data)
		{
			console.log(data);
            //alert(data.message);
			//$('form')[0].reset();
			location.reload();
        },
		error: function(data)
		{
			location.reload();
		}
      });
}
function fun_view(id,tbl)
{
	var identifier = "ViewDetails";
	var form_data = {action:'view',id:id,tbl:tbl};
	$.ajax({
       url: "index.php/api/actions",
        dataType: 'json', 
		data: form_data,
		type: 'post',
        success: function(data)
		{
			console.log(data);
			var datas = data[0];
			$('.ViewDetails').show();
			var tag = '<img src = '+datas.profileImage+' height = "100px;" width = "100px;" /><br><label>User name : <label><label>'+datas.Username+'<label><br><label>Email Id : <label><label>'+datas.EmailId+'<label><br><label>Mobile Number : <label><label>'+datas.Mobile+'<label><br><label>Date of Birth : <label><label>'+datas.DOB+'<label><br><label>Address : <label><label>'+datas.Address+'<label><br><label>City : <label><label>'+datas.city+'<label><br><label>State : <label><label>'+datas.state+'<label><br><label>Country : <label><label>'+datas.Country+'<label><br><button type= "button" onclick = "fun_view_close();">Close</button>';
			$('.ViewDetails').html(tag);
			$('.listView').hide();
        },
		error: function(data)
		{
			alert('error');
		}
      });
}
function fun_view_close()
{//debugger;
	$('.ViewDetails').hide();
	$('.listView').show();
}
function fun_delete(id,tbl)
{
	var form_data = {action:'delete',id:id,tbl:tbl};
	$.ajax({
       url: "index.php/api/actions",
        dataType: 'json', 
		data: form_data,
		type: 'post',
        success: function(data)
		{
			location.reload();
        },
		error: function(data)
		{
			location.reload();
		}
      });
}
function fun_view_close()
{//debugger;
	$('.ViewDetails').hide();
	$('.listView').show();
}
function fun_edit(id,tbl)
{
	var identifier = "EditDetails";
	var form_data = {action:'edit',id:id,tbl:tbl};
	$.ajax({
       url: "index.php/api/actions",
        dataType: 'json', 
		data: form_data,
		type: 'post',
        success: function(data)
		{
			console.log(data);
			var datas = data[0];
			$('.EditDetails').show();
			$.each(datas, function( index, value ) {
				$('.'+index).val(value);				
			});
			$('.listView').hide();
        },
		error: function(data)
		{
			alert('error');
		}
      });
}
function fun_edit_close()
{//debugger;
	$('.EditDetails').hide();
	$('.listView').show();
}