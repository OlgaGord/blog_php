<!-- 
Nom : Gordeyeva Olga,  Bourgault Steve
Projet : Cours Programmation WEB2 –TP#2
Organisation : Collège de Maisonneuve 
Page : login.php
Date création : 2018-05-26
Description : La page de login. 
-->

<?php
	//si l'usager est connecter
	if(isset($_SESSION["IDUsager"])){
		//on affiche le bouton de deconnexion
		$btnConnexion="<a href='index.php?action=Logout'>Se deconnecter</a>";
		//on affiche le bouton ajout d'article
		$btnAjtArticle="<a href='index.php?action=FormAjouteArticle'>Ajouter un article</a>";
	}
	//si l'usager n'est pas connecter
	else{
		//on affiche le bouton connection
		$btnConnexion="<a href='index.php?action=Login'>Se connecter</a>";
		//on laisse le bouton ajout d'article vide
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
		<!--Entête-->
		<header>
			<!--Menu principal-->	
			<div class="topnav">
				<!--Navigation -->
				<div class="menu">
					<a href="index.php?action=Accueil">Accueil</a>
			        <a href="index.php?action=ListArticles">Afficher les articles</a>
			        <a href="index.php?action=ListMotCle">Afficher les articles par mots clés</a>
			        <!--affiche le bouton ajout d'article-->
			        <?php echo $btnAjtArticle; ?>
					<a href="index.php?action=Login">Login</a>
				</div>
				<!--affiche le bouton connexion/deconnexion-->
				<?php echo $btnConnexion; ?>
			</div>
			<h1>Connexion</h1>
		</header>
		<!-- fin entête -->
		<main>
			<section class="article">
				<?php
					//si l'usager n'est pas connecter
					if(!isset($_SESSION["IDUsager"]))
					{
					//on affiche le formulaire
				?>
				<form method="POST" action="index.php">
					<h4>Nom d'usager : </h4><input type="text" name="nomUsager">
					<h4>Mot de passe : </h4><input type="password" name="motPasse">
					<br>
					<br>
					<input type="submit" value="Connexion">
					<input type="hidden" name="action" value="Authentification">
				</form>
				<?php
					}
					//si l'usager est connecter
					else
					{
						// on affiche le nom de l'uager et un lien pour se deconnecter
						echo "<p>Vous êtes déjà connecté sous le nom " . $_SESSION["NomUsager"] . "</p>";
						echo "<a href='index.php?action=Logout'>Se déconnecter</a>";
					}
					//si le message d'erreur a été remplit on l'affiche
					if(isset($msgErreur)){
						echo "<p>$msgErreur</p>";
					}
				?>
			</section>
		</main>
		<footer>
			<p> Blogue par Olga Gordeyeva et Steve Bourgault&nbsp; &copy; Copyrights &nbsp; 2018</p>
		</footer>
	</body>
</html>
