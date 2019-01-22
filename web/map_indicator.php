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
  		L'indicateur pour votre adresse : 
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
							echo $_POST['number'].", ".$_POST['street']." ".$_POST['district']." dans un rayon de ".$_POST['radius']."m est de ";
							echo $indicator;
						}
					}
				}
			}

			if($addexist == false)
			{
				echo "il n'existe pas d'indicateur pour votre adresse.";
			}
	    }
	    else
	    {
	        echo '<p>Les données fournies par le formulaire sont incomplètes.</p>';
	    }
  			
  		?>
  	</p>
	<div id="mapid" style="height: 400px;"></div>

	<script type="text/javascript">
		var mymap = L.map('mapid').setView([48.8534,  2.3488], 15);
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    	axZoom: 18,
    	id: 'mapbox.streets',
    	accessToken: 'pk.eyJ1IjoiY3lyaWxkbHQiLCJhIjoiY2pyNm50a2JqMTNtejQzcDRmN2FiYzcwMSJ9.tuoKnKQ24S-vrWdnQliNeQ'
		}).addTo(mymap);
		var marker = L.marker([48.8534,  2.3488]).addTo(mymap);
		var circle = L.circle([48.8534,  2.3488], {
    	color: 'red',
    	fillColor: '#f03',
    	fillOpacity: 0.5,
    	radius: 200
		}).addTo(mymap);
	</script>
	<input type="button" value="back" onClick="document.location.href = document.referrer" class="button_reset"/>
	

  </body>
</html>