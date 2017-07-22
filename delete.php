<?php

include('db.php');
include("function.php");

if(isset($_POST["teacher_id"]))
{
	$image = get_image_name($_POST["teacher_id"]);
	if($image != '')
	{
		unlink("upload/" . $image);
	}
	$statement = $connection->prepare(
		"DELETE FROM enseignant WHERE teacherid = :teacherid"
	);
	$result = $statement->execute(
		array(
			':teacherid'	=>	$_POST["teacher_id"]
		)
	);
	
	if(!empty($result))
	{
		echo 'Teacher  Deleted';
	}
}



?>