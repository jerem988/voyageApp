<?php
	include(__DIR__.'/../voyageController.php');
	use Controller\voyageController;
	$voyageController = new voyageController();
	$voyages = $voyageController->listVoyage();
?>
<table>
  <tr>
    <th>Id</th>
    <th>Libellé du fichier</th>
    <th>Date Création</th>
    <th>Date Modification</th>
    <th>Voir</th>
    <th>Supprimer</th>
  </tr>

  	<?php 
	  	foreach ($voyages as $voyage) {
	  		echo
	  		"<tr>
			    <td>" . $voyage['id'] ."</td>
			    <td>" . $voyage['libelle_fichier'] . "</td>
			    <td>" . $voyage['created_at'] . "</td>
			    <td>" . $voyage['updated_at'] . "</td>
			    <td><a href='./views/etapeVue.php?id=" . $voyage['id'] . "'>Voir</a></td>
			    <td><a href='voyageController.php?action=deleteVoyage&id=" . $voyage['id'] . "'>Supprimer</a></td>
			</tr>";
	  	}
  	?>
</table>