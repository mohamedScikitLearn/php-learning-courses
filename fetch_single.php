<?php
include('db.php');
include('function.php');
if(isset($_POST["teacher_id"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM enseignant 
		WHERE teacherid = '".$_POST["teacher_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["nom"] = $row["nom"];
		$output["prenom"] = $row["prenom"];
		$output["email"] = $row["email"];
		$output["intitule"] = $row["intitule"];
		$output["codegr"] = $row["codegr"];
		$output["codedep"] = $row["codedep"];
		$output["username"] = $row["username"];


		if($row["image"] != '')
		{
			$output['teacher_image'] = '<img src="upload/'.$row["image"].'"
		 class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_teacher_image" value="'.$row["image"].'" />';
		}
		else
		{
			$output['teacher_image'] = '<input type="hidden" name="hidden_teacher_image" value="" />';
		}
	}
	echo json_encode($output);
}
?>