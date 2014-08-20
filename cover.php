<?php

	$location = "http://unsplash.com";
	$images = array();

	$ch = cURL_init();
	$timeout = 5;

	cURL_setOpt($ch, CURLOPT_URL, $location);
	cURL_setOpt($ch, CURLOPT_RETURNTRANSFER, 1);
	cURL_setOpt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

	$html = cURL_exec($ch);
	cURL_close($ch);

	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	foreach($dom->getElementsByTagName("img") as $link) {
		if(strpos($link->getAttribute("class"), "photo_img") !== false) {
			array_push($images, $link->getAttribute("src"));
		}
	}

?>
<!doctype html>
<html>

	<head>

		<title>Hello</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Alegreya+Sans:100">

		<style type="text/css">

			body {
				background: #000;
			}

			#time {
				font-size: 1000%;
				color: #fff;
				position: absolute;
				left: 50%;
				top: 50%;
				-webkit-transform: translate(-50%, -65%);
				font-family: "Alegreya Sans", sans-serif;
				font-weight: 100;
				text-shadow: 0px 3px 3px rgba(0, 0, 0, 0.15);
			}

			.canvas {
				position: fixed;
				z-index: -1;
				left: 0;
				right: 0;
				top: 0;
				bottom: 0;
				opacity: 0.75;
			}
		
		</style>

	</head>

	<body>

		<div id="time"></div>
		<div class="canvas"></div>

		<script type="text/javascript">

			window.onload = function() {

				// Let's have all the images in JS so we could make a sldeshow if we'd like.

				<?php

					echo "var bgImages = [";

					foreach($images as $key => $value) {
						echo "\"";
						echo $value;
						echo "\",";
					}

					echo "\"http://37.media.tumblr.com/d77e21ed167c2125627b210b48e23f81/tumblr_na0kw25OtD1st5lhmo1_1280.jpg\"]";

				?>

				document.querySelector(".canvas").style.backgroundImage = "url('" + bgImages[Math.floor(bgImages.length * Math.random())] + "')";
				document.querySelector(".canvas").style.backgroundSize = "cover";

				setInterval(function() {

					var d = new Date();

					if(d.getMinutes() < 10) {
						var dMins = "0" + d.getMinutes();
					} else {
						dMins = d.getMinutes();
					}

					if(d.getHours() < 10) {
						var dHrs = "0" + d.getHours();
					} else {
						dHrs = d.getHours();
					}
					document.querySelector("#time").innerHTML = dHrs + ":" + dMins;
					
				}, 1000);

			}

		</script>

	</body>

</html>
