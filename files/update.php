<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UFT-8");
header("Access-Control-Allow-Headers: Content-Type, Acces-Control-Allow-Headers, Authorization, X-Requested-With");

require 'config.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id)) {
	$msg['message'] = '';
	$post_id = $data->id;
	
	$get_post = "SELECT * FROM `estudiante` WHERE id=post_id";
	$get_stmt = $conn->prepare($get_post);
	$get_stmt->bindValue(':post_id',$post_id,PDO::PARAM_INT);
	$get_stmt->execute();
	
	if($get_stmt->rowCount() > 0){
		
		$row = $get_stmt->fetch(PDO::FETCH_ASSOC);
		
		$post_identificacion = isset($data->identificacion) ? $data->identificacion : $row['identificacion'];
		$post_nombre = isset($data->nombre) ? $data->nombre : $row['nombre'];
		$post_curso = isset($data->curso) ? $data->curso : $row['curso'];
		$post_nota1 = isset($data->nota1) ? $data->nota1 : $row['nota1'];
		$post_nota2 = isset($data->nota2) ? $data->nota2 : $row['nota2'];
		$post_nota3 = isset($data->nota3) ? $data->nota3 : $row['nota3'];
		
		$update_query = "UPDATE `estudiante` SET identificacion = :identificacion, nombren = :nombre, curso = :curso, nota1 = :nota1, nota2 = :nota2, nota3 = :nota3 WHERE id = :id";
		$update_stmt = $conn->prepare($update_query);
		
		$update_stmt->bindValue(':identificacion', htmlspecialchars(strip_tags($post_identificacion)),PDO::PARAM_STR);
		$update_stmt->bindValue(':nombre', htmlspecialchars(strip_tags($post_nombre)),PDO::PARAM_STR);
		$update_stmt->bindValue(':curso', htmlspecialchars(strip_tags($post_curso)),PDO::PARAM_STR);
		$update_stmt->bindValue(':nota1', htmlspecialchars(strip_tags($post_nota1)),PDO::PARAM_STR);
		$update_stmt->bindValue(':nota2', htmlspecialchars(strip_tags($post_nota2)),PDO::PARAM_STR);
		$update_stmt->bindValue(':nota3', htmlspecialchars(strip_tags($post_nota3)),PDO::PARAM_STR);
		$update_stmt->bindValue(':id', $post_id,PDO::PARAM_STR);
		
		if($update_stmt->execute()){
			$msg['message'] = 'datos actualizados correctamente';
		}else{
			$msg['message'] = 'datos no encontrados';
		}
	}else{
		$msg['message'] = 'id invalido';
	}
	echo json_encode($msg);
}

?>