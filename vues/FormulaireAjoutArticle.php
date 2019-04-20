<!-- 
Nom : Gordeyeva Olga,  Bourgaul Steve
Projet : Cours Programmation WEB2 –TP#2
Organisation : Collège de Maisonneuve 
Page : FormulaireAjoutArticle.php
Date création : 2018-05-26
Description : Formulaire d'ajout d'article. 
-->
<!--si on n'est pas IDUsager en $_SESSION on appele index.php et il affiche la page d'acceuil -->
<?php
	if(!(isset($_SESSION["IDUsager"]))){
		header("Location: index.php");
	}
?>

<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<meta name="discription" content="Blogue, article"/>
		<meta name="Keywords" content="Blogue, article"/>
	    <title>Formulaire d'ajout d'un article</title>
	    <link rel="stylesheet" href="css/style.css">
	</head>
	<body id="home"> 
		<!--Entête-->
		<header>
		<!--Menu principal-->	
			<div class="topnav">
			<!--Navigation -->
				<div class="menu">
					<a href="index.php?action=Accueil">Accueil</a>
					<a href="index.php?action=ListArticles">Afficher les articles</a>
					<a href="index.php?action=ListMotCle">Afficher les articles par mots clés</a>
					<a href='index.php?action=FormAjouteArticle'>Ajouter un article</a>
					<a href="index.php?action=Login">Login</a>
				</div>
				<!--on appele l'action logout pour deconnecter-->
				<a href='index.php?action=Logout'>Se deconnecter</a>
			</div>
			<h1>Ajout d'un article</h1>
		</header><!-- fin entête -->
		<main>
			<section class="article">
				<!-- message erreur si un champ est vide apres d'ajout d'article -->
				<?php 
					if(isset($msgErreur)){
						echo $msgErreur; 
					}
				?>
				<!-- Formulaire pour ajouter un article -->
				<form method="POST" action="index.php">
					<h4>Mot(s) clé(s):</h4><input type="text" name="motcle"/>
					<h4>Les titres d'article:</h4> <input type="text" name="titre"/>
					<h4>Le texte d'article:</h4> <textarea rows="10" cols="70" name="text"></textarea>
					<br>
					<input type="submit" value="Ajouter">
					<!-- L'action insereArticle pour écrire les données de formulaire à la base de données -->
					<input type="hidden" name="action" value="InsereArticle">
				</form>
			</section>
		</main>
		<footer>
				<p> Blogue par Olga Gordeyeva et Steve Bourgault&nbsp; &copy; Copyrights &nbsp; 2018</p>
		</footer>
	</body>
</html>


