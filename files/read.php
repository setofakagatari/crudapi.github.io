<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UFT-8");

require 'config.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

if(isset($_GET['id']))
	{
		$post_id = filter_var($_GET['id'], FILTER_VALIDATE_INT, [
			'options' => [
				'default' => 'all_posts',
				'min_range' => 1
			]
		]);
	}
else {
	$post_id = 'all_posts';
}

$sql = is_numeric($post_id) ? "SELECT * FROM `estudiante` WHERE id='$post_id'" : "SELECT * FROM `estudiante`";
$stmt = $conn->prepare($sql);
$stmt->execute();

if($stmt->rowCount() > 0){
	$estudiante_array = [];
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$post_data = [
			'id' => $row['id'],
			'identificacion' => $row['id'],
			'nombre' => $row['identificacion'],
			'curso' => $row['curso'],
			'nota1' => $row['nota1'],
			'nota2' => $row['nota2'],
			'nota3' => $row['nota3']
		];
		array_push($estudiante_array, $post_data);
	}
	echo json_encode($estudiante_array);
}
else{
	echo json_encode(['message'=>'estudiante no encontrado']);
}

?>