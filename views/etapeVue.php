<?php
	include(__DIR__.'/../voyageController.php');
	use Controller\voyageController;

	$voyageController = new voyageController();
	$etapes = $voyageController->showEtapes();
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/menu.css" type="text/css">
		<link rel="stylesheet" href="../css/table.css" type="text/css">
	</head>
    <body>
		<ul>
		  <li><a class="active" href="../index.php">Accueil</a></li>
		  <li><a href="./uploadVue.php">Uploader Fichier</a></li>
		</ul>

		<table>
		  <tr>
		    <th>type</th>
		    <th>transport_number</th>
		    <th>departure_date</th>
		    <th>arrival_date</th>
		    <th>departure</th>
		    <th>arrival</th>
		    <th>seat</th>
		    <th>gate</th>
		    <th>baggage_drop</th>
		    <th>created_at</th>
		    <th>updated_at</th>
		  </tr>

		  	<?php 
			  	foreach ($etapes as $etape) {
			  		echo
			  		"<tr>
					    <td>" . $etape['type'] ."</td>
					    <td>" . $etape['number'] ."</td>
					    <td>" . $etape['departure_date'] ."</td>
					    <td>" . $etape['arrival_date'] ."</td>
					    <td>" . $etape['departure'] ."</td>
					    <td>" . $etape['arrival'] ."</td>
					    <td>" . $etape['seat'] ."</td>
					    <td>" . $etape['gate'] ."</td>
					    <td>" . $etape['baggage_drop'] ."</td>
					    <td>" . $etape['created_at'] ."</td>
					    <td>" . $etape['updated_at'] ."</td>
					 </tr>";
			  	}
		  	?>
		</table>
	</body>
</html>