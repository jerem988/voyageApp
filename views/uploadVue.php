<html>
	<head>
		<link rel="stylesheet" href="../css/menu.css" type="text/css">
	</head>
    <body>
		<ul>
		  <li><a class="active" href="../index.php">Accueil</a></li>
		  <li><a href="./uploadVue.php">Uploader Fichier</a></li>
		</ul>
		<br>
		<form action="../voyageController.php?action=storeFromRequest" method="post" enctype="multipart/form-data">
	      Fichier json à importer:
	      <input type="file" name="fileToUpload" id="fileToUpload">
	      <input type="submit" value="Importer" name="submit">
	    </form>
	</body>
</html>