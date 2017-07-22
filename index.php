<html>
	<head>
		<title>Gerer les enseignants</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style>
			body
			{
				margin:0;
				padding:0;
				background-color:#f1f1f1;
			}
			.box
			{
				width:1270px;
				padding:20px;
				background-color:#fff;
				border:1px solid #ccc;
				border-radius:5px;
				margin-top:25px;
			}
			.try{
				background-color: #1ABC9C;
				color: white
			}
			 #teacher_data_filter{
	position: relative;
    right: 399px;
    bottom: 107px;
    width: 418px;

			}
			.form-control .input-sm{
    padding: 24px;
				
			}
		</style>
	</head>
	<body>
		<div class="container box">
			<section class="try">
			<h1 align="center">Gerer les enseignants</h1>
			<br />

			<div class="table-responsive">
				<br />
				<div align="right">
					<button type="button" id="add_button" data-toggle="modal" data-target="#teacherModal" class="btn btn-info btn-lg">Add</button>
				</div>
			</section>

				<br /><br />
				<table id="teacher_data" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="10%">teacherid</th>

							<th width="10%">Image</th>
							<th width="23%">First Name</th>
							<th width="35%">Last Name</th>
							<th width="3%">email</th>
							<th width="3%">Grade</th>


							<th width="10%">Edit</th>
							<th width="10%">Delete</th>
						</tr>
					</thead>
				</table>
				
			</div>
		</div>
	</body>
</html>

<div id="teacherModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="teacher_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add teacher</h4>
				</div>
				<div class="modal-body">
					<label>Enter First Name</label>
					<input type="text" name="nom" id="nom" class="form-control" />
					<br />
					<label>Enter Last Name</label>
					<input type="text" name="prenom" id="prenom" class="form-control" />
					<br />
					<label>Enter code gr</label>
					<input type="text" name="codegr" id="codegr" class="form-control" />
					<br /><label>Enter email</label>
					<input type="text" name="email" id="email" class="form-control" />
					<br /><label>Enter username</label>
					<input type="text" name="username" id="username" class="form-control" />
					<br /><label>Enter intitule</label>
					<input type="text" name="intitule" id="intitule" class="form-control" />
					<br /><label>Enter codedep</label>
					<input type="text" name="codedep" id="codedep" class="form-control" />
					<br />
					<label>Enter password</label>
					<input type="password" name="password" id="password" class="form-control" />
					<br />
					
					<label>Select teacher Image</label>
					<input type="file" name="teacher_image" id="teacher_image" />
					<span id="teacher_uploaded_image"></span>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="teacher_id" id="teacher_id" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
	$('#add_button').click(function(){
		$('#teacher_form')[0].reset();
		$('.modal-title').text("Add teacher");
		$('#action').val("Add");
		$('#operation').val("Add");
		$('#teacher_uploaded_image').html('');
	});
	
	var dataTable = $('#teacher_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[0, 4, 5],
				"orderable":false,
			},
		],

	});

	$(document).on('submit', '#teacher_form', function(event){
		event.preventDefault();
		var firstName = $('#nom').val();
		var lastName = $('#prenom').val();
		var email = $('#email').val();
		var username = $('#username').val();
		var intitule = $('#intitule').val();
		var codegr = $('#codegr').val();
		var codedep = $('#codedep').val();
		var password = $('#password').val();


		var extension = $('#teacher_image').val().split('.').pop().toLowerCase();
		if(extension != '')
		{
			if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
			{
				alert("Invalid Image File");
				$('#teacher_image').val('');
				return false;
			}
		}	
		if(firstName != '' && lastName != ''&& email != ''&& username != ''&& intitule != ''&& codegr != ''&& codedep != ''&& password != '')
		{
			$.ajax({
				url:"insert.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#teacher_form')[0].reset();
					$('#teacherModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("Both Fields are Required");
		}
	});
	
	$(document).on('click', '.update', function(){
		var teacher_id = $(this).attr("id");
		$.ajax({
			url:"fetch_single.php",
			method:"POST",
			data:{teacher_id:teacher_id},
			dataType:"json",
			success:function(data)
			{
				$('#teacherModal').modal('show');
				$('#nom').val(data.nom);
				$('#prenom').val(data.prenom);
				$('#email').val(data.email);
				$('#username').val(data.username);
				$('#intitule').val(data.intitule);
				$('#codegr').val(data.codegr);
				$('#codedep').val(data.codedep);
				$('#password').val(data.password);
				$('.modal-title').text("Edit teacher");
				$('#teacher_id').val(teacher_id);
				$('#teacher_uploaded_image').html(data.teacher_image);
				$('#action').val("Edit");
				$('#operation').val("Edit");
			}
		})
	});
	
	$(document).on('click', '.delete', function(){
		var teacher_id = $(this).attr("id");
		if(confirm("Are you sure you want to delete this?"))
		{
			$.ajax({
				url:"delete.php",
				method:"POST",
				data:{teacher_id:teacher_id},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;	
		}
	});
	
	
});
</script>