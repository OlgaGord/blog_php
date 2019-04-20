<!-- 
Nom : Gordeyeva Olga,  Bourgaul Steve
Projet : Cours Programmation WEB2 –TP#2
Organisation : Collège de Maisonneuve 
Page : AfficheArticle.php
Date création : 2018-05-26
Description : Affichage des articles. 
-->
<?php
// Si l'usager est connecté on affiche le lien pour logout et bouton pour ajouter et modifier un article
	if(isset($_SESSION["IDUsager"])){
		$btnConnexion="<a href='index.php?action=Logout'>Se deconnecter</a>";
		$btnAjtArticle="<a href='index.php?action=FormAjouteArticle'>Ajouter un article</a>";
		$btnModif=true;
	}
	// Si l'usager n'est pas connecté on affiche le lien pour login
	else{
		$btnConnexion="<a href='index.php?action=Login'>Se connecter</a>";
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
					<!-- on affiche le bouton "ajoute Article" pour les usagers qui sont connectés -->
					<?php echo $btnAjtArticle; ?>
					<a href="index.php?action=Login">Login</a>
				</div>
				<!--on appele l'action login pour connection et logout pour deconnecter-->
				<?php echo $btnConnexion; ?>
			</div>
			<h1>Les Articles</h>
		</header><!-- fin entête -->
		<main>
			<section class="article">
				<?php
					// on affiche les données de a'article
					while($rangee = mysqli_fetch_assoc($donnees))
					{  
						echo "<div><h2>".$rangee["titre"] . "</h2>";
						echo "<p>" . $rangee["contenu"] ."</p>";
						echo "Auteur: ".$rangee["nom"];
						echo "<p>Mot clé pour cet article: "; 
						// on affiche les mots clés pour cet article
						echo GetMotCleArticle($rangee["idarticle"]);
						echo "</p>";
						// si l'usager est connecté et il est auteur d'article on affiche le lien pour modification de cet article
						if($btnModif){
							if($rangee["IDUsager"]==$_SESSION["IDUsager"]){
								echo "<a href='index.php?action=FormModificationArticle&IDArticle=" . $rangee["idarticle"] . "'>Modifier un article</a>";
							}
						}
						echo "</div>";
					}	
				?>
			</section>
		</main>
		<footer>
			<div class="footer_div">
				<span class="footer_span"> Blogue par Olga Gordeyeva et Steve Bourgault&nbsp; &copy; Copyrights &nbsp; 2018</span><br>
			</div>
		</footer>
	</body>
</html>
