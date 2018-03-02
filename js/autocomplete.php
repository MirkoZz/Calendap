<?php 
$pdo = new PDO('mysql:host=localhost;dbname=calendapp','root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8')); 

$request = $pdo->query("SELECT DISTINCT city FROM professional");

$city = array();

while ($info = $request->fetch(PDO::FETCH_ASSOC)) 
{
  foreach ($info as $key => $value) 
  {
    $city[] = $value;
  }
}

$request = $pdo->query("SELECT DISTINCT activity FROM professional");

$activity = array();

while ($info = $request->fetch(PDO::FETCH_ASSOC)) 
{
  foreach ($info as $key => $value) 
  {
    $activity[] = $value;
  }
}

// echo "<pre>"; var_dump($city); echo "</pre>";
// echo "<pre>"; var_dump($activity); echo "</pre>";
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
	var city = <?php echo json_encode($city); ?>;
	$( function() 
	{
	    $( "#city" ).autocomplete(
	    {
	      source: city
	      minLength: 2
    	});
  	});

  	var activity = <?php echo json_encode($activity); ?>;
	$( function() 
	{
	    $( "#activity" ).autocomplete(
	    {
	      source: activity
	      minLength: 2
    	});
  	});
</script>