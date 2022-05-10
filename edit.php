<?php
include 'db_connection.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])){
	$id = $_GET['id'];
}else{
	header("Location: ./");
	die();
}

if(isset($_POST['Category']) && $_POST['Category'] && isset($_POST['Title']) && $_POST['Title'] && isset($_POST['Price']) && is_numeric($_POST['Price']) && isset($_POST['Description']) && $_POST['Description'] && isset($_POST['Status']) && is_numeric($_POST['Status'])){
	mysqli_query($conn, "UPDATE ccdb_accounts SET Category='".$_POST['Category']."', Title='".$_POST['Title']."', Price=".$_POST['Price'].", Description='".$_POST['Description']."', Status=".$_POST['Status']." WHERE ID = ".$id);
}

$result = mysqli_query($conn, "SELECT * FROM ccdb_accounts WHERE ID=".$id);
$row = mysqli_fetch_array($result);

$Category = $row['Category'];
$Title = $row['Title'];
$Price = $row['Price'];
$Description = $row['Description'];
$Status = $row['Status'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chicks Challenge - Edit</title>
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
		  <h2><a class="btn btn-primary" href="./" role="button"><i class="fa-solid fa-angle-left"></i> Back</a> Edit ID: #<?php echo $id; ?></h2>
		  <form class="pb-2" action="http://localhost/chicks-challenge/edit.php?id=<?php echo $id; ?>" method="post">
			<div class="row align-items-center">
			  <div class="col-md-2">
			    <label for="Category">Category</label>
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
			    <label for="Title">Title</label>
				<input type="text" class="form-control mb-2" id="Title" name="Title" placeholder="Title" value="<?php echo $Title; ?>">
			  </div>
			  <div class="col-md-2">
			    <label for="Price">Price</label>
				<input type="number" class="form-control mb-2" id="Price" name="Price" placeholder="Price" value="<?php echo $Price; ?>">
			  </div>
			  <div class="col-md-3">
			    <label for="Description">Description</label>
				<input type="text" class="form-control mb-2" id="Description" name="Description" placeholder="Description" value="<?php echo $Description; ?>">
			  </div>
			  <div class="col-md-2">
			    <label for="Status">Status</label>
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
			    <button type="submit" class="btn btn-primary mb-2" style="margin-top: 21px;">Submit</button>
			  </div>
			</div>
		  </form>
		</div>
	  </div>
	</div>
  </body>
</html>