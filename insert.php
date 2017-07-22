<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$image = '';
		if($_FILES["teacher_image"]["name"] != '')
		{
			$image = upload_image();
		}
		$statement = $connection->prepare("
			INSERT INTO enseignant 
			(nom, prenom,email,username, password,image,codegr,intitule,codedep) 
			VALUES (:nom, :prenom, :email,:password,:username,:image,:codegr,:intitule,:codedep)
		");
		$result = $statement->execute(
			array(
				':nom'	=>	$_POST["nom"],
				':prenom'	=>	$_POST["prenom"],
				':email'=>	$_POST["email"],
				':username'=>	$_POST["username"],
				':password'=>	sha1($_POST['password']),
				':image'		=>	$image,
				':codegr'=>	$_POST["codegr"],
				':intitule'=>	$_POST["intitule"],
				':codedep'=>	$_POST["codedep"]

			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
	if($_POST["operation"] == "Edit")
	{
		$image = '';
		if($_FILES["teacher_image"]["name"] != '')
		{
			$image = upload_image();
		}
		else
		{
			$image = $_POST["hidden_teacher_image"];
		}
		$statement = $connection->prepare(
			"UPDATE enseignant 
			SET nom = :nom,
			 prenom = :prenom, 
			 username = :username, 
			 password = :password, 
			 email = :email, 
			 image = :image  ,
			 codegr = :codegr, 
			 intitule = :intitule, 
			 codedep = :codedep 

			WHERE
			 teacherid = :teacherid
			"
		);
		$result = $statement->execute(
			array(
				':nom'	=>	$_POST["nom"],
				':prenom'	=>	$_POST["prenom"],
				':email'=>	$_POST["email"],
				':username'=>	$_POST["username"],
				':password'=>sha1($_POST['password']),
				':image'		=>	$image,
				':codegr'=>	$_POST["codegr"],
				':intitule'=>	$_POST["intitule"],
				':codedep'=>	$_POST["codedep"],
				':teacherid'	=>	$_POST["teacher_id"]
			)
		);
		if(!empty($result))
		{
			echo 'Teacher Updated';
		}
	}
}

?>