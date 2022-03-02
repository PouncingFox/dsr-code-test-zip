<?php
if(isset($_POST['submit'])){
	$api_url = "http://api.zippopotam.us/us/".$_POST['zipcode'];
	$error = '';
	function check_response($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
	}
	if (check_response($api_url) != "200"){
			$error = "Whoops! That Zip Code doesn't seem to work!<br>Try again, or enter a different Zip Code!";
	} else {
			$json_result = file_get_contents($api_url);

			$response = json_decode($json_result, true);
		
			$zip = $response['post code'];
			$city = $response['places'][0]['place name'];
			$state_abbr = $response['places'][0]['state abbreviation'];
			$state = $response['places'][0]['state'];
			$country = $response['country'];
			$country_abbr = $response['country abbreviation'];
			$lat = $response['places'][0]['latitude'];
			$long = $response['places'][0]['longitude'];
	}
} 
?>
<!doctype html>
<head>
	<meta charset="utf-8">
	<title>Zip Code</title>
	<meta name="description" content="A dev aptitude test by Deep Space Robots.">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="reset.css">
	<link rel="stylesheet" href="style.css">
</head>
	<body>
		<div id="form">
			<h1>Zippy the Zip Code Tool!</h1>
			<p><i>Feed it a Zip Code below and it'll send back all the data its got!</i></p>
			<form action="" method="post">
				<input type="text" name="zipcode" placeholder="75751" inputmode="numeric" pattern="[0-9]{5,5}" minlenght="5" maxlength="5" required/>
				<input type="submit" name="submit" class="submit-btn"/>
			</form>
		</div>
		<?php if(isset($_POST['submit'])) { ?>
		<section id="results">			
			<div class="center">
				<h3>Here's what you entered:</h3>
				<h2><?php echo $_POST['zipcode']; ?></h2>
			</div>
			<?php if ($error !== '') { ?>
				<div class="center">
					<h2><?php echo $error; ?></h2>
				</div>
			<?php }; ?>
			<?php if ($error == '') { ?>
			<div class="center">
				<strong class="state-name"><?php echo $state; ?></strong>
			</div>
			<div class="col-container">
				<div class="col left">
					<div class="img-wrapper">
						<img src="states/<?php echo $state_abbr; ?>.svg">
					</div>
				</div>
				<div class="col right">
					<div class="city">
						<p>City:</p>
						<strong><?php echo $city; ?></strong>
					</div>
					<div class="state">
						<p>State:</p>
						<strong><?php echo $state; ?> (<?php echo $state_abbr; ?>)</strong>
					</div>
					<div class="country">
						<p>Coutry:</p>
						<strong><?php echo $country; ?> (<?php echo $country_abbr; ?>)</strong>
					</div>
				</div>
			</div>
			<div class="technical">
				<h3>If you wanna get technical:</h3>
				<div class="details">
					<div class="lat">
						<p>Latitude: <?php echo $lat; ?></p>
					</div>
					<div class="long">
						<p>Longitude: <?php echo $long; ?></p>
					</div>
				</div>
			</div>
			<?php }; ?>
		</section>
		<?php } ?>
</body>
</html>