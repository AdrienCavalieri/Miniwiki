<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Accueil - Mini Wiki</title>
		<link rel="stylesheet" href="css/minimal.css"/>
		<link rel="stylesheet" href="css/index.css"/>
	</head>
	<body>
		<nav id="navigation">
			<a href=""><img src="images/logo_mini_wiki.svg"/></a>
			<ul>
				<li><a href="ajouter.php">Ajouter un article</a></li>
			</ul>
		</nav>
		<div id="recherche">
			<form action="rechercher.php">
				<input type="text" name="mot-clef"/>
				<input type="submit" value="Rechercher"/>
			</form>
		</div>
		<section>
			<article class="article">
				<?php
				// Inclusion de la fonction BBCodeToHTML.
				require_once('fonctions/BBCodeToHTML.php');

				try
				{
					// Connexion à MySQL et sélection de la base de données.
					require_once('connexion.php');

					// Formulation de la requête.
					$sql = "SELECT contenu FROM articles ORDER BY RAND() LIMIT 1";
					$requete = $bdd -> prepare($sql);

					// Envoi de la requête.
					$retour = $requete -> execute();
					if($retour)
					{
						$tab_ligne = $requete -> fetch(PDO::FETCH_ASSOC);

						echo '<h2>Article au hasard</h2>';
						echo BBCodeToHTML($tab_ligne['contenu']);
					}
					else
						echo '<p class="erreur-requete">Erreur ! Requête défaillante.</p>';
				}

				catch (PDOException $e)
				{
					// On termine le script en affichant le code de l’erreur ainsi que le message
					die('<p>La connexion a échoué. Erreur[' . $e -> getCode() . '] : ' . $e -> getMessage() . '</p>');
				}
				?>
			</article>
			<article class="article" id="presentation">
				<h2>Présentation</h2>
				<p>Mini Wiki est un projet d’encyclopédie en ligne s'inspirant grandement de Wikipédia. Le but est
					d'implémenter les fonctions d'un Wiki : ajout, modification, suppression d'articles et formatage de ceux-ci. <br/><br/>
					A long terme, le site intégrera une gestion de comptes utilisateurs.</p>
			</article>
		</section>
   </body>
</html>
