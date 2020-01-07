<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Supprimer un article - Mini Wiki</title>
		<link rel="stylesheet" href="css/minimal.css"/>
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
			<?php
			// Vérification des données entrées dans le formulaire.
			if(isset($_GET['id']) && trim($_GET['id']) != '')
			{
				try
				{
					// Connexion à MySQL et sélection de la base de données.
					require_once('connexion.php');

					// Formulation de la requête.
					$sql = "DELETE FROM articles WHERE id = :id";
					$requete = $bdd -> prepare($sql);
					$requete -> bindValue(':id', htmlspecialchars($_GET['id'], ENT_QUOTES));

					// Envoi de la requête et retour.
					$retour = $requete -> execute();
					if($retour)
					{
						echo '<p class="confirmation-suppression">Article supprimé !</p>';
						header("refresh:2; url=./");
					}

					else
						echo '<p class="erreur-suppression">Erreur de suppression.</p>';
				}

				catch (PDOException $e)
				{
					// On termine le script en affichant le code de l’erreur ainsi que le message.
					die('<p>La connexion a échoué. Erreur[' . $e -> getCode() . '] : ' . $e -> getMessage() . '</p>');
				}
			}
			?>
		</section>
	</body>
</html>
