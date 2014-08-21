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

		<title>What's my IP?</title>
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

		<div id="time">

			<?php

			function get_client_ip() {

				$ipaddress = "";

				if (getenv("HTTP_CLIENT_IP"))
					$ipaddress = getenv("HTTP_CLIENT_IP");
				else if(getenv("HTTP_X_FORWARDED_FOR"))
					$ipaddress = getenv("HTTP_X_FORWARDED_FOR");
				else if(getenv("HTTP_X_FORWARDED"))
					$ipaddress = getenv("HTTP_X_FORWARDED");
				else if(getenv("HTTP_FORWARDED_FOR"))
					$ipaddress = getenv("HTTP_FORWARDED_FOR");
				else if(getenv("HTTP_FORWARDED"))
				   $ipaddress = getenv("HTTP_FORWARDED");
				else if(getenv("REMOTE_ADDR"))
					$ipaddress = getenv("REMOTE_ADDR");
				else
					$ipaddress = "UNKNOWN";
				return $ipaddress;

			}

			echo get_client_ip();

			?>

		</div>
		
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

			}

		</script>

	</body>

</html>
