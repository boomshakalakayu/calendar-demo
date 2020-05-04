<?php 
header('Content-Type: application/json; charset=utf-8');
include('../../db.php');
include('../HttpStatusCode.php');

try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'],$db['password']);
} catch (PDOException $e) {
	echo 'Error';
	exit;
}

if (empty($_POST['title']))
	new HttpStatusCode(400, 'title cannot be blank.');

$start_time = explode(':', $_POST['start_time']);
$end_time = explode(':', $_POST['end_time']);
if ($start_time[0] > $end_time[0] || ($start_time[0] == $end_time[0] && $start_time[1] > $end_time[1]))
	new HttpStatusCode(400, 'time range error.');	

$sql = 'INSERT INTO events (title, year, month, `date`, start_time, end_time, description)
		VALUES (:title, :year, :month, :date, :start_time, :end_time, :description)';
$statement = $pdo->prepare($sql);
$statement->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
$statement->bindValue(':year', $_POST['year'], PDO::PARAM_INT);
$statement->bindValue(':month', $_POST['month'], PDO::PARAM_INT);
$statement->bindValue(':date', $_POST['date'], PDO::PARAM_INT);
$statement->bindValue(':start_time', $_POST['start_time'], PDO::PARAM_STR);
$statement->bindValue(':end_time', $_POST['end_time'], PDO::PARAM_STR);
$statement->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
if ($statement->execute()) {
	$id = $pdo->lastInsertId();

	$sql = 'SELECT id, title, start_time FROM events WHERE id=:id';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
	$event = $statement->fetch(PDO::FETCH_ASSOC);

	$event['start_time'] = substr($event['start_time'], 0, 5);
	echo json_encode($event);

}