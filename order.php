<?php
include 'db_connection.php';

//Feed
$selected = '';
$where = 0;

if(isset($_GET['PaymentMethod']) && $_GET['PaymentMethod']){
	if (in_array($_GET['PaymentMethod'], $paymethods)){
		$PaymentMethod = strval($_GET['PaymentMethod']);
		$where++;
		$query_PaymentMethod = ' PaymentMethod = "'.$PaymentMethod.'"';
	}else{
		$PaymentMethod = '';
		$query_PaymentMethod = '';
	}
}else{
	$PaymentMethod = '';
	$query_PaymentMethod = '';
}

if(isset($_GET['min-Total']) && $_GET['min-Total']){
	$min_Total = floatval($_GET['min-Total']);
}else{
	$min_Total = 0;
}

if(isset($_GET['max-Total']) && $_GET['max-Total']){
	$max_Total = floatval($_GET['max-Total']);
}else{
	$max_Total = 999999999.99;
}

$query_Total = '';
if($min_Total < $max_Total){
	$where++;
	if($where === 1){
		$query_Total = ' Total BETWEEN '.$min_Total.' AND '.$max_Total;
	}else{
		$query_Total = ' AND Total BETWEEN '.$min_Total.' AND '.$max_Total;
	}
}

if(isset($_GET['OrderAccount']) && is_numeric($_GET['OrderAccount'])){
	$OrderAccount = $_GET['OrderAccount'];
	$where++;
	$query_OrderAccount = ' AND `OrderAccount` = '.$OrderAccount;
}else{
	$OrderAccount = '';
	$query_OrderAccount = '';
}

if($where > 0){
	$where = ' WHERE'.$query_PaymentMethod.$query_Total.$query_OrderAccount;
}

$result = mysqli_query($conn, "SELECT * FROM ccdb_order".$where);

if($min_Total===0){$min_Total='';}
if($max_Total===999999999.99){$max_Total='';}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chicks Challenge</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<style>
	@font-face {
	  font-family: Fontawesome;
	  src: url(webfonts/fa-brands-400.woff2);
	}
	</style>
	<link rel="stylesheet" href="css/all.css">
  </head>
  <body>
	<div class="container" style="margin-top: 50px;">
	  <div class="row">
		<div class="col">
		  <h2>Filter</h2>
		  <form class="pb-2" action="http://localhost/chicks-challenge/order.php" method="get">
			<div class="row align-items-center">
			  <div class="col-md-3">
			    <select name="PaymentMethod" id="PaymentMethod" class="form-control mb-2 custom-select">
				  <option value="">- Payment Method -</option>
				  <?php
					foreach ($paymethods as $item){
						if($item === $PaymentMethod){$selected = ' selected';}else{$selected = '';}
						echo '<option value="'.$item.'"'.$selected.'>'.$item.'</option>';
					}
				  ?>
			    </select>
			  </div>
			  <div class="col-md-2">
				<input type="number" class="form-control mb-2" id="min-Total" name="min-Total" placeholder="min Total" value="<?php echo $min_Total; ?>">
			  </div>
			  <div class="col-md-2">
				<input type="number" class="form-control mb-2" id="max-Total" name="max-Total" placeholder="max Total" value="<?php echo $max_Total; ?>">
			  </div>
			  <div class="col-md-3">
				<input type="text" class="form-control mb-2" id="OrderAccount" name="OrderAccount" placeholder="Order Account" value="<?php echo $OrderAccount; ?>">
			  </div>
			  <div class="col-md-2">
			    <button type="submit" class="btn btn-primary mb-2">Submit</button>
			  </div>
			</div>
		  </form>
		  <table class="table table-dark">
		    <thead>
			  <tr>
			    <th>ID</th>
			    <th>Payment Method</th>
				<th>Total</th>
				<th>Order Account</th>
			  </tr>
			</thead>
			<tbody>
		    <?php	  
			  if($result){
			    while($row = mysqli_fetch_array($result)){
					echo '<tr>'
						.'<td>' . $row['ID'] . '</td>'
						.'<td>' . $row['PaymentMethod'] . '</td>'
						.'<td>$' . $row['Total'] . '</td>'
						.'<td>' . $row['OrderAccount'] . '</td>'
					.'</tr>';
				}
				//echo "Returned rows are: " . $result -> num_rows;
			    //$result -> free_result();
			  }
		    ?>
			</tbody>
		  </table>
		</div>
	  </div>
	</div>
  </body>
</html>