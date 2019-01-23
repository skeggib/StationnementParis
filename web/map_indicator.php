<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8" />
    <title>Indicator of place</title>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   		integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   		crossorigin=""/>
	 <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
   		integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
   		crossorigin=""></script>
  </head>
  <body>
  	<p id="indicator_result">
  		<?php 
	  		if (isset($_POST['number']) && isset($_POST['street']) && isset($_POST['district']) && isset($_POST['radius']))
		    {

		        $fichier = 'test_formulaire.xml';
				$xml = simplexml_load_file($fichier);

				$addexist = false;

				foreach($xml as $address)
				{
					$attAddress = $address->attributes();

					if(strtolower($attAddress->number) == strtolower($_POST['number']) 
						&& strtolower($attAddress->street) == strtolower($_POST['street']) 
						&& strtolower($attAddress->district) == strtolower($_POST['district']))
					{
						$addexist = true;

						foreach($address as $indicator)
						{
							$attindicator = $indicator->attributes();
							if($attindicator->radius == $_POST['radius'])
							{
								$place = intval(number_format(floatval($indicator),2) * 10);
								echo "Pour votre adresse : ".$_POST['number'].", ".$_POST['street']." 750".$_POST['district']." PARIS, il existe environ ".$place." places pour 10 personnes.";

								$longitude = $attAddress->longitude;
								$latitude = $attAddress->latitude;

								if($indicator < 0.25)
								{
									$color = 'red';
									$fillColor = '#f03';
								}
								elseif ($indicator < 0.75) 
								{
									$color = 'orange';
									$fillColor = '#FFA500';
								}
								elseif ($indicator >= 0.75) 
								{
									$color = 'green';
									$fillColor = '#9ACD32';
								}
								 
								if($_POST['radius'] == 100)
								{
									$zoom = 17;
								}
								elseif($_POST['radius'] == 200)
								{
									$zoom = 16;
								}
								elseif($_POST['radius'] == 500)
								{
									$zoom = 15;
								}

							}
						}
					}
				}

				if($addexist == false)
				{
					echo "Il n'existe pas d'indicateur pour votre adresse.";
				}
		    }
		    else
		    {
		        echo "<p>Les données fournies par le formulaire sont incomplètes. Impossible de calculer l'indicateur.</p>";
		    }  			
  		?>
  	</p>
	
	<div id="mapid" style="height: 400px;"></div>
	<script type="text/javascript">
		var mymap = L.map('mapid').setView([<?php echo $latitude ?>, <?php echo $longitude ?>], <?php echo $zoom ?>);
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    	axZoom: 18,
    	id: 'mapbox.streets',
    	accessToken: 'pk.eyJ1IjoiY3lyaWxkbHQiLCJhIjoiY2pyNm50a2JqMTNtejQzcDRmN2FiYzcwMSJ9.tuoKnKQ24S-vrWdnQliNeQ'
		}).addTo(mymap);

		var marker = L.marker([<?php echo $latitude ?>, <?php echo $longitude ?>]).addTo(mymap);
		var circle = L.circle([<?php echo $latitude ?>, <?php echo $longitude ?>], {
													color: <?php echo json_encode($color) ?>,
											    	fillColor: <?php echo json_encode($fillColor) ?>,
											    	fillOpacity: 0.5,
											    	radius: <?php echo $_POST['radius'] ?>}).addTo(mymap);
	</script>
	

	<input type="button" value="back" onClick="document.location.href = document.referrer" class="button_reset"/>
	

  </body>
</html>