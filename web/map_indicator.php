<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8" />
    <title>Indicator of place</title>
    <link rel="stylesheet" href="formulaire.css" />
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

					// $indicator = $address->indicator;
					// foreach($indicator as $indicator_radius)
					// {
					// 	// $attindicator = $indicator->attributes();

					// 	if($attindicator->radius == $_POST['radius'])
						// {
							echo $_POST['number'].", ".$_POST['street']." ".$_POST['district']." dans un rayon de ".$_POST['radius']."m est de ";
							echo $address->indicator;
							// .$indicator_radius. '<br>';
					// 	}
					// }
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

	

  </body>
</html>