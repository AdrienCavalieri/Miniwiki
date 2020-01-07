<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Rechercher un article - Mini Wiki</title>
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
			<p id="resultat-recherche">Résultat(s) de la recherche :</p>
			<?php
			// Vérification des données entrées dans le formulaire.
			if(isset($_GET['mot-clef']) && trim($_GET['mot-clef']) != '')
			{
				try
				{
					// Connexion à MySQL et sélection de la base de données.
					require_once('connexion.php');

					// Formulation de la requête.
					$sql = "SELECT id, titre, DATE_FORMAT(date_modification, '%d/%m/%Y \à %H:%i:%S') AS date_modification FROM articles WHERE titre LIKE :mot OR contenu LIKE :mot ORDER BY date_modification DESC";
					$requete = $bdd -> prepare($sql);
					$requete -> bindValue(':mot',  '%' . $_GET['mot-clef'] . '%');

					// Envoi de la requête et retour.
					$retour = $requete -> execute();
					if($retour)
					{
						echo '<ul>';
						while($tab_ligne = $requete -> fetch(PDO::FETCH_ASSOC))
						{
							echo '<li>';
								echo '<p><a href="article.php?id=', $tab_ligne['id'], '">', $tab_ligne['titre'], '</a>, modifié le ' , $tab_ligne['date_modification'] , '</p>';
							echo '</li>';
						}
						
						echo '</ul>';
					}
					else
					echo '<p id="erreur-requete">Erreur ! Requête défaillante.</p>';
				}

				catch (PDOException $e)
				{
					// On termine le script en affichant le code de l’erreur ainsi que le message
					die('<p>La connexion a échoué. Erreur[' . $e -> getCode() . '] : '. $e -> getMessage() . '</p>');
				}
			}
			?>
		</section>
	</body>
</html>
