<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Article - Mini Wiki</title>
		<link rel="stylesheet" href="css/minimal.css"/>
		<link rel="stylesheet" href="css/article.css"/>
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
			<article class="article">
				<?php
				if(isset($_GET['id']) && trim($_GET['id']) != '')
				{
					// Inclusion de la fonction BBCodeToHTML.
					require_once('fonctions/BBCodeToHTML.php');

					try
					{
						// Connexion à MySQL et sélection de la base de données.
						require_once('connexion.php');

						// Formulation de la requête.
						$sql = "SELECT id, titre, contenu, date_creation, date_modification FROM articles WHERE id = :id";
						$requete = $bdd -> prepare($sql);
						$requete -> bindValue(':id', $_GET['id']);

						// Envoi de la requête.
						$retour = $requete -> execute();
						if($retour)
						{
							$tab_ligne = $requete -> fetch(PDO::FETCH_ASSOC);

							if($tab_ligne['titre'] == '')
									echo '<p class="erreur-article">Erreur ! Article introuvable.</p>';

							else
							{
								echo '<div id="conteneur-boutons">';
								echo '<a href="modifier.php?id=', $tab_ligne['id'], '"><img class="bouton" src="images/bouton_modifier.svg"/></a>';
								echo '<a href="supprimer.php?id=', $tab_ligne['id'], '"><img class="bouton" src="images/bouton_effacer.svg"/></a>';
								echo '</div>';

								echo '<h1>', $tab_ligne['titre'], '</h1>';
								echo BBCodeToHTML($tab_ligne['contenu']);
							}
						}

						else
							echo '<p class="erreur-article">Erreur ! Requête défaillante.</p>';
					}

					catch (PDOException $e)
					{
						// On termine le script en affichant le code de l’erreur ainsi que le message
						die('<p>La connexion a échoué. Erreur[' . $e -> getCode() . '] : ' . $e -> getMessage() . '</p>');
					}
				}

				else
					echo '<p class="erreur-article">Erreur ! ID d\'article invalide.</p>';
		  ?>
		 </article>
		</section>
	</body>
</html>
