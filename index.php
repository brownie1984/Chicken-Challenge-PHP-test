<?php
include 'db_connection.php';

//Add new
if(isset($_POST['Category']) && $_POST['Category'] && isset($_POST['Title']) && $_POST['Title'] && isset($_POST['Price']) && is_numeric($_POST['Price']) && isset($_POST['Description']) && $_POST['Description'] && isset($_POST['Status']) && is_numeric($_POST['Status'])){
	mysqli_query($conn, "INSERT INTO ccdb_accounts (Category, Title, Price, Description, Status) VALUES ('".$_POST['Category']."', '".$_POST['Title']."', ".$_POST['Price'].", '".$_POST['Description']."', ".$_POST['Status'].")");
}

//Delete
if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
	mysqli_query($conn, "DELETE FROM ccdb_accounts WHERE id=".$_GET['delete']);
}

//Feed
$selected = '';
$where = 0;

if(isset($_GET['Category']) && $_GET['Category']){
	if (in_array($_GET['Category'], $categories)){
		$Category = strval($_GET['Category']);
		$where++;
		$query_category = ' Category = "'.$Category.'"';
	}else{
		$Category = '';
		$query_category = '';
	}
}else{
	$Category = '';
	$query_category = '';
}

if(isset($_GET['Title']) && $_GET['Title']){
	$Title = strval($_GET['Title']);
	$where++;
	if($where === 1){
		$query_category = ' `Title` LIKE "%'.$Title.'%"';
	}else{
		$query_category = ' AND `Title` LIKE "%'.$Title.'%"';
	}
	$query_title = '';
}else{
	$Title = '';
	$query_title = '';
}

if(isset($_GET['min-Price']) && $_GET['min-Price']){
	$min_Price = floatval($_GET['min-Price']);
}else{
	$min_Price = 0;
}

if(isset($_GET['max-Price']) && $_GET['max-Price']){
	$max_Price = floatval($_GET['max-Price']);
}else{
	$max_Price = 999999999.99;
}

$query_price = '';
if($min_Price < $max_Price){
	$where++;
	if($where === 1){
		$query_price = ' Price BETWEEN '.$min_Price.' AND '.$max_Price;
	}else{
		$query_price = ' AND Price BETWEEN '.$min_Price.' AND '.$max_Price;
	}
}

if(isset($_GET['Description']) && $_GET['Description']){
	$Description = strval($_GET['Description']);
	$where++;
	$query_description = ' AND `Description` LIKE "%'.$Description.'%"';
}else{
	$Description = '';
	$query_description = '';
}

if(isset($_GET['Status']) && is_numeric($_GET['Status'])){
	if (in_array($_GET['Status'], $status)){
		$Status = $_GET['Status'];
		$where++;
		$query_status = ' AND `Status` = '.$Status;
	}else{
		$Status = '';
		$query_status = '';
	}
}else{
	$Status = '';
	$query_status = '';
}

if($where > 0){
	$where = ' WHERE'.$query_category.$query_title.$query_title.$query_price.$query_description.$query_status;
}

$result = mysqli_query($conn, "SELECT * FROM ccdb_accounts".$where);

if($min_Price===0){$min_Price='';}
if($max_Price===999999999.99){$max_Price='';}

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
		  <form class="pb-2" action="http://localhost/chicks-challenge/" method="get">
			<div class="row align-items-center">
			  <div class="col-md-2">
				<select name="Category" id="Category" class="form-control mb-2 custom-select">
				  <option value="">- Category -</option>
				  <?php
					foreach ($categories as $item){
						if($item === $Category){$selected = ' selected';}else{$selected = '';}
						echo '<option value="'.$item.'"'.$selected.'>'.$item.'</option>';
					}
				  ?>
				</select>
			  </div>
			  <div class="col-md-2">
				<input type="text" class="form-control mb-2" id="Title" name="Title" placeholder="Title" value="<?php echo $Title; ?>">
			  </div>
			  <div class="col-md-1">
				<input type="number" class="form-control mb-2" id="min-Price" name="min-Price" placeholder="min Price" value="<?php echo $min_Price; ?>">
			  </div>
			  <div class="col-md-1">
				<input type="number" class="form-control mb-2" id="max-Price" name="max-Price" placeholder="max Price" value="<?php echo $max_Price; ?>">
			  </div>
			  <div class="col-md-3">
				<input type="text" class="form-control mb-2" id="Description" name="Description" placeholder="Description" value="<?php echo $Description; ?>">
			  </div>
			  <div class="col-md-2">
				<select name="Status" id="Status" class="form-control mb-2 custom-select">
				  <option value="">- Status -</option>
				  <?php
					foreach ($status as $item){
						if($item === $Status){$selected = ' selected';}else{$selected = '';}
						echo '<option value="'.$item.'"'.$selected.'>'.$item.'</option>';
					}
				  ?>
				</select>
			  </div>
			  <div class="col-md-1">
			    <button type="submit" class="btn btn-primary mb-2">Submit</button>
			  </div>
			</div>
		  </form>
		  <table class="table table-dark">
		    <thead>
			  <tr>
			    <th>ID</th>
			    <th>Category</th>
				<th>Title</th>
				<th>Price</th>
				<th>Description</th>
				<th style="text-align:center;">Status</th>
				<th style="text-align:center;">Edit</th>
				<th style="text-align:center;">Remove</th>
				<th style="text-align:center;">Buy</th>
			  </tr>
			</thead>
			<tbody>
		    <?php	  
			  if($result){
			    while($row = mysqli_fetch_array($result)){
					echo '<tr>'
						.'<td>' . $row['ID'] . '</td>'
						.'<td>' . $row['Category'] . '</td>'
						.'<td>' . $row['Title'] . '</td>'
						.'<td>$' . $row['Price'] . '</td>'
						.'<td>' . $row['Description'] . '</td>'
						.'<td style="text-align:center;">' . $row['Status'] . '</td>'
						.'<td style="text-align:center;"><a href="edit.php?id='.$row['ID'].'"><i class="fa-solid fa-pencil"></i></a></td>'
						.'<td style="text-align:center;"><a href="?delete='.$row['ID'].'" class="text-danger"><i class="fa-solid fa-xmark"></i></a></td>'
						.'<td style="text-align:center;"><a href="buy.php?id='.$row['ID'].'" class="text-success"><i class="fa-solid fa-cart-shopping"></i></a></td>'
					.'</tr>';
				}
				//echo "Returned rows are: " . $result -> num_rows;
			    //$result -> free_result();
			  }
		    ?>
			</tbody>
		  </table>
		  
		  <h2 style="margin-top:50px;">Add</h2>
		  <form class="pb-2" action="http://localhost/chicks-challenge/" method="post">
			<div class="row align-items-center">
			  <div class="col-md-2">
				<select name="Category" id="Category" class="form-control mb-2 custom-select">
				  <option value="">- Category -</option>
				  <?php
					foreach ($categories as $item){
						echo '<option value="'.$item.'"'.$selected.'>'.$item.'</option>';
					}
				  ?>
				</select>
			  </div>
			  <div class="col-md-2">
				<input type="text" class="form-control mb-2" id="Title" name="Title" placeholder="Title">
			  </div>
			  <div class="col-md-2">
				<input type="number" class="form-control mb-2" id="Price" name="Price" placeholder="Price">
			  </div>
			  <div class="col-md-3">
				<input type="text" class="form-control mb-2" id="Description" name="Description" placeholder="Description">
			  </div>
			  <div class="col-md-2">
				<select name="Status" id="Status" class="form-control mb-2 custom-select">
				  <option value="">- Status -</option>
				  <?php
					foreach ($status as $item){
						echo '<option value="'.$item.'"'.$selected.'>'.$item.'</option>';
					}
				  ?>
				</select>
			  </div>
			  <div class="col-md-1">
			    <button type="submit" class="btn btn-primary mb-2">Submit</button>
			  </div>
			</div>
		  </form>
		</div>
	  </div>
	</div>
  </body>
</html>