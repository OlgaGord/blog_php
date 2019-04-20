<?php
	//ouverture de session
	session_start();
	
	//vérifie si on recoit action
	if(isset($_REQUEST["action"]))
		//si action est vide on donne la valeur accueil pour rediriger vers accueil
		if(trim($_REQUEST["action"])==""){
			$action = "Accueil";
		}
		//si oui on le met dans la var action
		else{
			$action = $_REQUEST["action"];
		}
	//sinon on met accueil dans la var action
	else
	{
		$action = "Accueil";
	}

	//on lie le fichier qui contient tous les functions
	require_once("FonctionsDB.php");
	
	//ici on traite la var action
	switch($action)
	{
		//affiche la page d'accueil
        case "Accueil":
        	require_once("vues/accueil.php");
        	break;

        //Recupère tous les articles et redirige vers la page d'affichage des articles
        case "ListArticles":
        	$donnees=GetAllArticles();
        	require_once("vues/AfficheArticle.php");
			break;

		//recupère tous les mot cle de la bd et redirige vers la page d'affichage des mots clés
		case "ListMotCle":
        	$donnees=GetAllMotCleCount();
        	require_once("vues/AfficheMotCle.php");
        	break;

        //redirige vers le formulaire d'ajout
		case "FormAjouteArticle":
			require_once("vues/FormulaireAjoutArticle.php");
			break;

		//recois le formulaire d'ajout et le traite
		case "InsereArticle":
			//si on recoit les champs du formulaire
			if(isset($_POST["titre"]) && isset($_POST["text"]) && isset($_POST["motcle"]))
			{	
				//on vérifie si ils sont bien remplie
				if(trim($_POST["titre"]) == "" || trim($_POST["text"]) == "" || trim($_POST["motcle"]) == "")
				{
					//si un des champs est vide on retourne vers le formulaire d'ajout avec un message d'erreur
					$msgErreur="Vous avez laissé un champ vide";
					require_once("vues/FormulaireAjoutArticle.php");					
				}
				//si bien remplit on procède à l'insertion dans la bd
				else
				{
					//dabord on insère le titre le texte avec un id usager dans la bd
					InsereArticle($_POST["titre"], $_POST["text"], $_SESSION["IDUsager"]);
					//ensuite on recupère l'article qui vien juste d'être ajouté
					$idDernArticle=GetDernArticle();
					//et on traite les mots clés entré par l'usager
					VerifyMotCle($_POST["motcle"],$idDernArticle);
					//après l'ajout,on recupère tous les articles et on les affiche
					header("location: index.php?action=ListArticles");				
				}
			}
			//si on ne recoit pas les champs du formulaire on redirige vers le formulaire d'ajout
			else{
				require_once("vues/FormulaireAjoutArticle.php");
			}
			break;

		//recupère un article et nous envoie vers le formulaire de modification
		case "FormModificationArticle":
			//recupère un article avec son id
			$donnees = GetArticleParID($_REQUEST["IDArticle"]);
			$rangee = mysqli_fetch_assoc($donnees);
			//affiche le formulaire de modification d'article
		 	require_once("vues/FormulaireModifArticle.php");
		 	break;

		//quand les modifictations sont terminer ont traite les modifications
		case "SouvegarderArticle";
			//si on recoit le formulaire de modif
			if(isset($_POST["titre"]) && isset($_POST["text"]) && $_POST["IDArticle"])
			{		
				//si les champs sont vide
				if(trim($_POST["titre"]) == "" || trim($_POST["text"]) == "")
				{
					//on répcupère à nouveau l'article et sont contenu
					$donnees = GetArticleParID($_REQUEST["IDArticle"]);
					$rangee = mysqli_fetch_assoc($donnees);
					//on envoie également un message d'erreur
					$msgErreur="Vous avez laissé un champ vide";
					//puis on redirige le tous vers le formulaire de modifications
		 			require_once("vues/FormulaireModifArticle.php");			
				}
				//si les champs sont bien remplit
				else
				{
					//procéder à l'insertion
					SouvegarderArticle($_POST["titre"], $_POST["text"], $_POST["IDArticle"]);
					//après l'ajout, récupère tous les articles et redirige vers la page d'affichage des articles
					$donnees=GetAllArticles();
					require_once("vues/AfficheArticle.php");				
				}
			}
			//si on ne recoit pas le formulaire on redirige vers l'affichage des articles
			else{
				$donnees=GetAllArticles();
				require_once("vues/AfficheArticle.php");
			}
			break;

        //affiche la page de login
        case "Login":
			require_once("vues/Login.php");
			break;

		//traite le formulaire de login
		case "Authentification":
			//si on recoit le formulaire
			if(isset($_POST["nomUsager"])&&isset($_POST["motPasse"])){
				//si les champs sont vides
				if(trim($_POST["nomUsager"])==""||trim($_POST["motPasse"])==""){
					//on remplit le message d'erreur et on renvois vers login
					$msgErreur="Veuillez remplir tous les champs";
					require_once("vues/Login.php");
				}
				//si les champs sont bien remplit
				else{
					//on appel la function Authentification
					//si le resultat est 1 (tous est bon)
					if(Authentification($_POST["motPasse"],$_POST["nomUsager"])==1){
						//on enregistre le nom d'usager dans la var session
						$_SESSION["NomUsager"]=$_POST["nomUsager"];
						//puis redirige vers accueil
						require_once("vues/accueil.php");
					}
					//si le resultat est 2 (le mot de passe n'est pas bon)
					elseif(Authentification($_POST["motPasse"],$_POST["nomUsager"])==2){
						//remplit le message d'erreur et redirige vers login
						$msgErreur="Mauvais mot de passe";
						require_once("vues/Login.php");
					}
					//si on recoit un autre resultat(le nom usager n'est pas bon)
					else{
						//remplit le message d'erreur et redirige vers login
						$msgErreur="Nom d'usager inexistant";
						require_once("vues/Login.php");
					}
				}
			}
			//si on ne recoit pas le formulaire on redirige vers la page login
			else{
				require_once("vues/Login.php");
			}
			break;

		//déconnexion de l'usager puis redirige vers login
		case "Logout":
			$_SESSION = array();
			if(isset($_COOKIE[session_name()])){
				setcookie(session_name(), '', time() - 3600);
			}
			session_destroy();
			require_once("vues/Login.php");
			break;

		default:
			require_once("vues/accueil.php");
        	break;
	}		
?>