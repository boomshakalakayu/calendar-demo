<?php 

include('../db.php');

try {
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'],$db['password']);
} catch (PDOException $e) {
	echo 'Error';
	exit;
}

$year = date('Y');
$month = date('m');

$sql = 'SELECT * FROM events WHERE year=:year AND month=:month ORDER BY `date`, start_time ASC';
$statement = $pdo->prepare($sql);
$statement->bindValue(':year', $year, PDO::PARAM_INT);
$statement->bindValue(':month', $month, PDO::PARAM_INT);
$statement->execute();
$events = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($events as $key => $event) {
	$events[$key]['start_time'] = substr($event['start_time'], 0, 5);
};

$days = array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'STA' );

//這個月有幾天
$date = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//1號是星期幾
$fristDateTheMonth = new DateTime("$year-$month-1");
//最後一天星期幾
$lastDateTheMonth = new DateTime("$year-$month-$date");
//calendar 要填的padding
$frontPadding = $fristDateTheMonth->format('w');
$backPadding = 6 - $lastDateTheMonth->format('w');
//填前面的padding
for ($i=0; $i < $frontPadding; $i++) { 
	$dates[] = null;
}
//1-31
for ($i=0; $i < $date; $i++) { 
	$dates[] = $i+1;
}
//填後面的padding
for ($i=0; $i < $backPadding; $i++) { 
	$dates[] = null;
}
?>

<script>
	var $events = <?= json_encode($events, JSON_NUMERIC_CHECK) ?>;
</script>