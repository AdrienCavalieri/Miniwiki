<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Modifier un article - Mini Wiki</title>
		<link rel="stylesheet" href="css/minimal.css"/>
		<link rel="stylesheet" href="css/modifier.css"/>
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
				// Connexion à MySQL et sélection de la base de données.
				require_once('connexion.php');

				try
				{
					// Formulation de la requête.
					$sql = "SELECT titre, contenu FROM articles WHERE id = :id";
					$requete = $bdd -> prepare($sql);
					$requete -> bindValue(':id', htmlspecialchars($_GET['id'], ENT_QUOTES));

					// Envoi de la requête et retour.
					$retour = $requete -> execute();
					if($retour)
					{
						$tab_ligne = $requete -> fetch(PDO::FETCH_ASSOC);

						echo '<form id="formulaire-modification" action="" method="post">';
						echo 'Titre<br/>';
							echo '<input type="text" value="', $tab_ligne['titre'], '" name="titre"><br/>';
							echo 'Contenu<br/>';
							echo '<textarea name="contenu">', $tab_ligne['contenu'], '</textarea><br/>';
						echo '<input type="submit" name="modifier" value="Modifier">';
						echo '</form>';
					}

					else
						echo '<p class="erreur-modification">Erreur de modification.</p>';
				}

				catch (PDOException $e)
				{
					// On termine le script en affichant le code de l’erreur ainsi que le message
					die('<p> La connexion a échoué. Erreur[' . $e -> getCode() . '] : ' . $e -> getMessage() . '</p>');
				}

				if(isset($_POST['titre']) && trim($_POST['titre']) != '' && $_POST['contenu'] && trim($_POST['contenu']) != '')
				{
					try
					{
						// Formulation de la requête.
						$sql = "UPDATE articles SET titre = :titre, contenu = :contenu, date_modification = NOW() WHERE id = :id";
						$requete = $bdd -> prepare($sql);
						$requete -> bindValue(':id', htmlspecialchars($_GET['id'], ENT_QUOTES));
						$requete -> bindValue(':titre', htmlspecialchars($_POST['titre'], ENT_QUOTES));
						$requete -> bindValue(':contenu', htmlspecialchars($_POST['contenu'], ENT_QUOTES));

						// Envoi de la requête et retour.
						$retour = $requete -> execute();
						if($retour)
						{
							echo '<p class="confirmation-modification">Article modifié !</p>';
							header("refresh:2; url=./");
						}
						else
							echo '<p class="erreur-modification">Erreur de modification.</p>';
					}
					
					catch (PDOException $e)
					{
						// On termine le script en affichant le code de l’erreur ainsi que le message
						die('<p>La connexion a échoué. Erreur[' . $e -> getCode() . '] : ' . $e -> getMessage() . '</p>');
					}
				}
			}
			?>
	</body>
</html>
