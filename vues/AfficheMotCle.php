<!-- 
Nom : Gordeyeva Olga,  Bourgault Steve
Projet : Cours Programmation WEB2 –TP#2
Organisation : Collège de Maisonneuve 
Page : affichage.php
Date création : 2018-05-26
Description :Affiche les mots clé et les articles relié à ce mot cle. 
-->

<?php
	//verifie si l'usager est authentifier
	//si authentifier
	if(isset($_SESSION["IDUsager"])){
		//affiche le bouton deconnexion
		$btnConnexion="<a href='index.php?action=Logout'>Se deconnecter</a>";
		//affiche le bouton ajout article
		$btnAjtArticle="<a href='index.php?action=FormAjouteArticle'>Ajouter un article</a>";
		//affiche le bouton pour modifier article
		$btnModif=true;
	}
	else{
		//affiche le bouton connexion
		$btnConnexion="<a href='index.php?action=Login'>Se connecter</a>";
		//n'affiche pas le bouton d'ajout et le bouton modifier
		$btnAjtArticle="";
		$btnModif=false;
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
			        <!--Bouton ajout d'article-->
			        <?php echo $btnAjtArticle; ?>
			        <a href="index.php?action=Login">Login</a>
				</div>
				<!--Bouton connexion/deconnexion-->
				<?php echo $btnConnexion; ?>
			</div>
			<h1>Mots clés</h1>
		</header>
		<main>
			<div id="motcle">
				<?php
					//pour chaque mot cle dans la bd on affiche un lien qui est le mot cle lui meme puis le nombre de fois que le lien est associé à un article.
					foreach ($donnees as $mot){
				    	echo "<a href='index.php?action=ListMotCle&mot=" . $mot["mot"] . "'>" . $mot["mot"] . "(" . $mot["decompte"] . ")</a>";
    				}
    			?>
			</div>
			<section class="article">
				<?php
					echo "<br><br>";

					//lors qu'on clique sur un lien, on recoit un mot cle dans l'url
					if(isset($_GET["mot"])){
						//on recupère les tous les article qui son associé à ce mot cle
						$resultat=ArticleParMotCle($_GET["mot"]);

						//pour chaque article trouver on affiche le titre, le texte, et le nom de l'auteur.
						foreach ($resultat as $article){
							echo "<div><h2>" . $article["titre"] . "</h2>";
							echo "<p>" . $article["contenu"] . "</p>";
							echo "<p>Auteur : " .  $article["nom"] . "</p>";
							echo "<p>Mot clé pour cet article: "; 
							// on affiche les mots clés pour cet article
							echo GetMotCleArticle($article["IDArticle"]);
							echo "</p>";
							//si l'usager est connecter on affiche le bouton modifier pour les articles qu'il a ecrit
							if($btnModif){
								if($article["IDUsager"]==$_SESSION["IDUsager"]){
									echo "<a href='index.php?action=FormModificationArticle&IDArticle=" . $article["IDArticle"] . "'>Modifier un article</a>";
								}
							}
							echo "</div>";
				    	}
				    }

				?>
			</section>
		</main>
		<footer>
			<p> Blogue par Olga Gordeyeva et Steve Bourgault&nbsp; &copy; Copyrights &nbsp; 2018</p>
		</footer>
	</body>
</html>