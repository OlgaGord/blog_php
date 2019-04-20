<?php
	//function pour se connecter à la base de donnée
	function connect()
	{
		$c = mysqli_connect("localhost", "root", "", "blogue1");
		if(!$c){
			trigger_error("Erreur de connexion : " . mysqli_connect_error());
		}
		mysqli_query($c, "SET NAMES 'utf8'");
		return $c;
	}
	
	//varible qui contient la connexion à la base de donnée
	$connexion = connect();

	//function qui permet de filtrer le champ d'un formulaire pour proteger des injections
	function filtreInput($champ){
		global $connexion;
		$champFiltre=mysqli_real_escape_string($connexion, $champ);
		$champFiltre=strip_tags($champFiltre, "<b><p><a><i>");
		return $champFiltre;
	}
	
	//function pour authentifier l'utilisateurn et retourne une valeur selon le resultat du traitement
	function Authentification($motpasse,$nom){
		//connexion a la base de donnée
		global $connexion;
		//récupération des informations de l'usager portant le nom entrer dans le login
		$requete="SELECT id, nom, motdepasse FROM usager WHERE nom='" . filtreInput($nom) . "'";
		$resultat=mysqli_query($connexion, $requete);
		if($rangee=mysqli_fetch_assoc($resultat)){
			//verification du mot de passe entré et le mot de passe dans base de donnée
			//si le mot de passe est valide on sauvegarde l'id de l'usager dans var session et on retourne la valeur 1
			if(password_verify($motpasse,$rangee["motdepasse"])){
				$_SESSION["IDUsager"]=$rangee['id'];
				return 1;
			}
			//si le mot de passe n'est pas bon on retourne la valeur 2
			else{
				return 2;
			}
		}
		//si le nom entré ne correspond pas à un usager de la base de donnée on retourne 3
		else{
			return 3;
		}
	}
	
	//va chercher tous les articles
    function GetAllArticles()
    {
        global $connexion;
        //selection de tous les informations contenue dans les article et du nom de l'auteur associer
        $requete = "SELECT a.id as idarticle, a.titre, a.contenu, u.nom, u.id as IDUsager
                	FROM article as a
                   	JOIN usager as u ON
                   	u.id = a.idauteur
                   	ORDER BY a.id DESC";
        $resultat = mysqli_query($connexion, $requete);        
        return $resultat;
    }

    //function qui permet d'allez l'id du dernier ajout de la base de donnée
    function GetDernArticle(){
    	global $connexion;
    	$dernId=mysqli_insert_id($connexion);
    	return $dernId;
    }

    //function qui affiche tous les articles qui sont associer à un mot clé précis
    function ArticleParMotCle($motcle){
		global $connexion;
		$requete="SELECT a.id as IDArticle, a.titre, a.contenu, u.nom, u.id as IDUsager FROM article a
					JOIN usager u ON u.id = a.idauteur
					JOIN motclearticle c ON a.id = c.idarticle
					JOIN motcle m ON m.id = c.idmotcle
					WHERE m.mot ='" . $motcle . "'
					ORDER BY a.id DESC";
		$resultat=mysqli_query($connexion, $requete);
		return $resultat;
	}

	//function qui va chercher tous les mots clé et les affiches dans l'ordre de popularité
    function GetAllMotCleCount(){
    	global $connexion;
    	$requete="SELECT m.id,m.mot, COUNT(*) AS decompte FROM motclearticle a
				JOIN motcle m ON m.id=a.idmotcle
				GROUP BY idmotcle
				ORDER BY decompte DESC";
    	$resultat=mysqli_query($connexion, $requete);
    	return $resultat;
    }

    //function qui recupère tous les mots cles de la bd
	function GetAllMotCle(){
    	global $connexion;
    	$requete="SELECT id,mot FROM motcle";
    	$resultat=mysqli_query($connexion, $requete);
    	return $resultat;
    }    

    //function qui va chercher tous les mots clé associer à un article et les affiches
    function GetMotCleArticle($idArticle){
    	global $connexion;
    	$requete="SELECT mot FROM motcle m JOIN motclearticle a ON m.id = a.idmotcle WHERE a.idarticle = " . $idArticle . ";";
    	$resultat = mysqli_query($connexion, $requete);
   
       	if($motcle=mysqli_fetch_all($resultat)){
       		foreach ($motcle as $mot){
       			echo $mot[0] . " ";
       		}
       	}
    }
	
	//function qui permet d'ajouter un article à la base de donnée
	function InsereArticle($titre, $text, $IDusager)
	{
		global $connexion;
		$requete = "INSERT INTO article(titre, contenu, idauteur) VALUES ('" . filtreInput($titre) . "', '" . filtreInput($text) . "', '$IDusager')";
		$resultat = mysqli_query($connexion, $requete);
	}

	//function qui traite les mots clé lors de l'ajout d'article
	function VerifyMotCle($motcle,$idArticle){
		//récupère les mots clé entré par l'usager et les mets dans un tableau
    	$arrayMotCle=explode("&","$motcle");
    	//recupère tous les mots clés de la base de donnée
    	$resultat=GetAllMotCle();
    	if($rangee=mysqli_fetch_all($resultat)){
    		//pour chaque mots cles entré par l'usager
    		foreach ($arrayMotCle as $mot){
    			//on met le mot en minuscule et on déclare la var ajout a true
    			$mot=strtolower($mot);
    			$ajout=true;
    			//ensuite on compare avec tous les mots de la base de donnée
    			foreach($rangee as $motbd){
    				//si le mot entré correspond 1 fois à un mot de la bd on met ajout à false
		    		if($mot==$motbd[1]){
		    			$ajout=false;
		    		}
	    		}
	    		//si ajout est a true apres le traitement
	    		if($ajout){
	    			//alors on appel la function pour ajouter le mot dans la bd
	    			AjoutMotCle($mot);
	    		}
    		}
	    }
	    //ensuite on doit rappeler la bd avec les nouveaux mots ajouté
	    $resultat=GetAllMotCle();
	    //on recupère tous les mots cles de la bd
    	if($rangee=mysqli_fetch_all($resultat)){
    		//pour chaque mot entré par l'usager
    		foreach ($arrayMotCle as $mot){
    			//on met le mot en minuscule
    			$mot=strtolower($mot);
    			//et on le compare avec les mots dans la bd
    			foreach($rangee as $motbd){
    				//si le mot entré correspond au mot de la bd
		    		if($mot==$motbd[1]){
		    			//on appel la function qui associe un mot clé et un article ensemble
		    			AssociMotCle($motbd[0],$idArticle);
		    		}
	    		}
    		}
	    }	    
    }

    //funciton qui permet d'ajouter un mot clé dans la bd
    function AjoutMotCle($motcle){
    	global $connexion;
    	$requete="INSERT INTO motcle (mot) VALUE ('" . $motcle . "')";
    	$resultat=mysqli_query($connexion, $requete);
    }

    //function qui permet d'associer un mot clé à un article
    function AssociMotCle($IdMotCle,$idArticle){
    	global $connexion;
    	$requete="INSERT INTO motclearticle VALUE ('" . $IdMotCle . "','" . $idArticle . "');";
    	$resultat=mysqli_query($connexion, $requete);
    }

    //function va chercher un article avec son ID
    function GetArticleParID($ID)
	{
		global $connexion;
		$requete = "SELECT a.titre, a.contenu, a.id as IDArticle
					FROM article a
				  	WHERE a.id = $ID";
		$resultat = mysqli_query($connexion, $requete);
		return $resultat;
	}

	//function qui permet de sauvegarder les modif. apporter à un article
    function SouvegarderArticle($titre, $text, $ID)
	{
		global $connexion;
		$requete = "UPDATE article SET titre='" . filtreInput($titre) . "', contenu='" . filtreInput($text) . "' WHERE id=$ID";
		$resultat = mysqli_query($connexion, $requete);
	}
	
?>