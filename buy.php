<?php
include 'db_connection.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])){
	$id = $_GET['id'];
}else{
	header("Location: ./");
	die();
}
$result = mysqli_query($conn, "SELECT * FROM ccdb_accounts WHERE ID=".$id);
$row = mysqli_fetch_array($result);

$Category = $row['Category'];
$Title = $row['Title'];
$Price = $row['Price'];
$Description = $row['Description'];

$pays = '';
foreach ($paymethods as $item){
	$pays = $pays.'<option value="'.$item.'">'.$item.'</option>';
}

//Add new
if(isset($_POST['PaymentMethod']) && $_POST['PaymentMethod']){
	mysqli_query($conn, "INSERT INTO ccdb_order (Total, PaymentMethod, OrderAccount) VALUES (".$Price.", '".$_POST['PaymentMethod']."', ".$id.")");
	header("Location: ./order.php");
}

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
		  <form class="pb-2" action="http://localhost/chicks-challenge/buy.php?id=<?php echo $id; ?>" method="post">
		  <table class="table table-dark">
		    <thead>
			  <tr>
			    <th>ID</th>
			    <th>Category</th>
				<th>Title</th>
				<th>Price</th>
				<th>Description</th>
				<th style="text-align:center;">PaymentMethod</th>
				<th style="text-align:center;">Buy</th>
			  </tr>
			</thead>
			<tbody>
		    <?php	  
				echo '<tr>'
					.'<td>' . $id . '</td>'
					.'<td>' . $Category . '</td>'
					.'<td>' . $Title . '</td>'
					.'<td>$' . $Price . '</td>'
					.'<td>' . $Description . '</td>'
					.'<td><select name="PaymentMethod" id="PaymentMethod" class="form-control mb-2 custom-select">
						<option value="">- Payment Method -</option>
						'.$pays.'
					</select></td>'
					.'<td style="text-align:center;"><button type="submit" class="btn btn-primary mb-2">Buy <i class="fa-solid fa-cart-shopping"></i></button></td>'
				.'</tr>';
		    ?>
			</tbody>
		  </table>
		  </form>
		</div>
	  </div>
	</div>
  </body>
</html>