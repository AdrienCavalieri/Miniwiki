<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Ajouter un article - Mini Wiki</title>
		<link rel="stylesheet" href="css/minimal.css"/>
		<link rel="stylesheet" href="css/ajouter.css"/>
	</head>
	<body>
		<nav id="navigation">
			<a href=""><img src="images/logo_mini_wiki.svg"/></a>
			<ul>
				<li><a href="ajouter.php">Ajouter un article</a></li>
			</ul>
		</nav>
		<div id="recherche">
			<form id="formulaire-recherche" action="rechercher.php">
				<input type="text" name="mot-clef"/>
				<input type="submit" value="Rechercher"/>
			</form>
		</div>
		<section>
			<form id="formulaire-ajout" action="" method="post">
				Titre
				<br/>
				<input type="text" name ="titre"/>
				<br/>
				Contenu
				<br/>
				<textarea name ="contenu"></textarea>
				<br/>
				<input type="submit" name="ajouter" value="Ajouter"/>
			</form>
			<?php
			// Vérification des données entrées dans le formulaire.
			if(isset($_POST['ajouter']) and isset($_POST['titre']) and trim($_POST['titre']) != '' and $_POST['contenu'] and trim($_POST['contenu']) != '')
			{
				try
				{
					// Connexion à MySQL et sélection de la base de données.
					require_once('connexion.php');

					// Formulation de la requête.
					$sql = "INSERT INTO articles (titre, contenu, date_creation, date_modification) VALUES (:titre, :contenu,  NOW(), NOW())";
					$requete = $bdd -> prepare($sql);
					$requete -> bindValue(':titre', htmlspecialchars($_POST['titre'], ENT_QUOTES));
					$requete -> bindValue(':contenu', htmlspecialchars($_POST['contenu'], ENT_QUOTES));

					// Envoi de la requête et retour.
					$retour = $requete -> execute();

					if($retour)
					{
						echo '<p class="confirmation-ajout">Article ajouté !</p>';
						header("refresh:2; url=./");
					}

					else
					{
						echo '<p class="erreur-ajout">Erreur d\'ajout.</p>';
					}
				}

				catch (PDOException $e)
				{
					// On termine le script en affichant le code de l’erreur ainsi que le message
					die('<p>La connexion a échoué. Erreur[' . $e -> getCode() . '] : ' . $e -> getMessage() . '</p>');
				}
			}
			?>
		</section>
	</body>
</html>
