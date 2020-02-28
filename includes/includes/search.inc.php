<?php
if(isset($_GET['search_submit'])){
    echo( "hello world ");
    require("dbhandler.inc.php");

    // get inputs
    $mots_cle = $_GET["searchInput"];
    $sujet = $_GET["sujet"];
    $etudiant = $_GET["etudiant"];
    $entreprise = $_GET["entreprise"];
    $date = $_GET["date"];
    $lieu = $_GET["lieu"];

    //requete
    $requete = "";
    // check inputs
    if (empty($mots_cle) && empty($sujet) && empty($etudiant) && empty($entreprise) && empty($date) && empty($lieu)){
        header("Location: ../index.php?error=EmptyFields");
        exit();
    }
    //pour mots clé 
    elseif (!empty($mots_cle) && empty($sujet) && empty($etudiant) && empty($entreprise) && empty($date) && empty($lieu)){
        if (preg_match("/[A-za-z0-9']/", $mots_cle) && !preg_match("/^'/",$mots_cle) && !empty($mots_cle)){
            $mots_cle = filter_var($mots_cle, FILTER_SANITIZE_STRING);
            $requete = "SELECT * FROM stage where MATCH(sujet, mots_cle) AGAINST('?') LIMIT 30";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $requete)){
                header("Location: ../index.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $mots_cle);
                mysqli_stmt_store_result($stmt);
                $result_check = mysqli_stmt_num_rows($stmt);
                echo($result_check);
                if ($result_check > 0){
                    while($row=mysqli_stmt_get_result($stmt))
                    {
                        echo "'><span class='title'>".$row['sujet']."</span><br><span class='desc'>".$row['etudiant']."</span></a></li>";
                    }
                exit();
                }
                else{
                    header("Location: ../index.php?error=noresult");
                    exit();
                }
            }
        }
    }
    else {
        exit();

    }
    
    

}
