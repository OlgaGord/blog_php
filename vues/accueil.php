<!DOCTYPE html>
<!-- 
Nom : Gordeyeva Olga, Steve Bourgault
Projet : Cours Programmation dynamque 2
Organisation : Collège de Maisonneuve 
Page : affichage.php
Date création : 2018-05-26
Description : La page d'accueil du blogue. 
-->
<?php
// Si l'usager est connecté on affiche le lien pour logout et bouton pour ajouter un article
	if(isset($_SESSION["IDUsager"])){
		$btnConnexion="<a href='index.php?action=Logout'>Se deconnecter</a>";
		// On affiche le message Bonjour en ajoutant le nom de usager 
		$msgBienvenue="<h1>Bonjour " . $_SESSION["NomUsager"] . "</h1>";
		$btnAjtArticle="<a href='index.php?action=FormAjouteArticle'>Ajouter un article</a>";
	}
	// Si l'usager n'est pas connecté on affiche le lien pour login
	else{
		$btnConnexion="<a href='index.php?action=Login'>Se connecter</a>";
		$msgBienvenue="<h1>Bienvenu sur notre blogue</h1>";
		$btnAjtArticle="";
	}
?>

<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<meta name="discription" content="Blogue, article"/>
		<meta name="Keywords" content="Blogue, article"/>
	    <title>Bienvenu sur notre Blogue</title>
	    <link rel="stylesheet" href="css/style.css">
	</head>
	<body id="home"> 
		<header>
			<!--Menu principal-->	
			<div class="topnav">
			<!--Navigation -->
				<div class="menu">
					<a href="index.php?action=Accueil">Accueil</a>
					<a href="index.php?action=ListArticles">Afficher les articles</a>
					<a href="index.php?action=ListMotCle">Afficher les articles par mots clés</a>
					<?php echo $btnAjtArticle; ?>
					<a href="index.php?action=Login">Login</a>
				</div>
				<!--on affiche login si l'usager n'est pas connecté ou logout pour les usagers qui sont connectés -->
				<?php echo $btnConnexion; ?>
			</div>
			<h1>Le Blogue</h>
		</header><!-- fin entête -->
		<main>
			<section class="article">
				<!-- l'affichage de message-->
				<?php echo $msgBienvenue; ?>
			</section>
		</main>
		<footer>
				<p>Blogue par Olga Gordeyeva et Steve Bourgault&nbsp; &copy; Copyrights &nbsp; 2018</p>
		</footer>
	</body>
</html>



