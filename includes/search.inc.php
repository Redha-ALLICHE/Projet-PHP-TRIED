<?php
if(isset($_GET['search_submit'])){
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
    $n_filter =3;
    // nombre total de résultats par pages
    $total_reg = "10";
    // check inputs
    if (empty($mots_cle) && empty($sujet) && empty($etudiant) && empty($entreprise) && empty($date) && empty($lieu)){
        header("Location: ../index.php?error=EmptyFields");
        exit();
    }
    //pour mots clé 
    elseif (!empty($mots_cle)){
        if (preg_match("/[A-Za-z0-9']/", $mots_cle) && !preg_match("/^'/",$mots_cle)){
            $mots_cle = filter_var($mots_cle, FILTER_SANITIZE_STRING);
            $array = [$mots_cle, $mots_cle, "%".$mots_cle ."%"];
            $requete = "SELECT `Stage`.`titre_sujet`, 
                               `Personne`.nom, 
                               `Personne`.prenom, 
                               `Entreprise`.nom_entreprise ,
                               `Entreprise`.ville, 
                               `Entreprise`.pays, 
                               `Stage`.annee,
                               `Stage`.mots_cles,
                               cast((LENGTH(`Rapport`.`rapport`)- LENGTH(REPLACE(lower(`Rapport`.`rapport`), lower(?), '')))/LENGTH(?) as integer) as nb_occurence
                        FROM `Rapport`
                        inner join `Stage` on `Rapport`.id_stage = `Stage`.id_stage
                        inner join `Personne` on `Stage`.id_stagiaire1 = `Personne`.`id_personne`
                        inner join `Entreprise` on  `Stage`.id_entreprise = `Entreprise`.id_entreprise
                        where rapport like ? 
                        ";

            if (!empty($sujet) && preg_match("/[A-Za-z0-9']/", $sujet) && !preg_match("/^'/",$sujet)){
                $sujet = filter_var($sujet, FILTER_SANITIZE_STRING);
                $requete .= " AND `Stage`.`titre_sujet` like ?";
                array_push($array, $sujet);
            }

            if (!empty($etudiant) && preg_match("/[A-Za-z']/", $etudiant) && !preg_match("/^'/",$etudiant)){
                $etudiant = filter_var($etudiant, FILTER_SANITIZE_STRING);
                $requete .= " AND (`Personne`.`nom` like ? OR `Personne`.`prenom` like ?)";
                array_push($array, $etudiant);
                array_push($array, $etudiant);
            }

            if (!empty($date) && preg_match("/^\d{4}$/", $date)){
                $requete .= " AND `Stage`.annee = ?";
                array_push($array, $date);
            }

            if (!empty($entreprise) && preg_match("/[A-Za-z0-9']/", $entreprise) && !preg_match("/^'/",$entreprise)){
                $entreprise = filter_var($entreprise, FILTER_SANITIZE_STRING);
                $requete .= " AND `Entreprise`.nom_entreprise like ?";
                array_push($array, $entreprise);
            }

            if (!empty($lieu) && preg_match("/[A-Za-z']/", $lieu) && !preg_match("/^'/",$lieu)){
                $lieu = filter_var($lieu, FILTER_SANITIZE_STRING);
                $requete .= " AND (`Entreprise`.ville like ? or `Entreprise`.pays like ?)";
                array_push($array, $lieu);
                array_push($array, $lieu);
            }

            $requete .= " ORDER BY nb_occurence desc;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $requete)){
                header("Location: ../index.php?error=sqlerror");
                exit();
            }
            else{
                
                $types = str_repeat('s', count($array)); 
                mysqli_stmt_bind_param($stmt, $types, ...$array);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result_check = mysqli_stmt_num_rows($stmt);
                mysqli_stmt_bind_result($stmt, $sujet, $nom, $prenom, $entreprise, $ville, $pays, $annee, $mots_cle_res, $nb_occ);
                if ($result_check > 0){
                    require('model_accueil.php');
                    echo('<script>
                            document.getElementById("nb_result").hidden = false;
                            document.getElementById("nb_result").innerText = '.$result_check.';
                         </script>
                        ');
                   echo('<script>
                            document.getElementById("searchInput").value = "'.$_GET["searchInput"].'";
                         </script>
                        ');
                    // ajouter la classe ici
                    echo('<div id="mytable" class="table-responsive bg-dark">
                        <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Pertinence</th>
                            <th scope="col">Sujet</th>
                            <th scope="col">Nom de l\'étudiant</th>
                            <th scope="col">Prénom de l\'étudiant</th>
                            <th scope="col">Entreprise</th>
                            <th scope="col">Lieu</th>
                            <th scope="col">Année</th>
                            <th scope="col">Mots Clé</th>
                        </tr>
                        </thead>
                        <tbody>
                    ');   
                    while(mysqli_stmt_fetch($stmt))
                    {
                        echo('
                        <td>'.$nb_occ.'</td>
                        <td>'.$sujet.'</td>
                        <td>'.$nom.'</td>
                        <td>'.$prenom.'</td>
                        <td>'.$entreprise.'</td>
                        <td>'.$ville.'/'.$pays.'</td>
                        <td>'.$annee.'</td>
                        <td>'.$mots_cle_res.'</td>
                        </tr>');
                    }
                    echo('
                    </tbody>
                    </table>
                    </div>
                    </form>
                    </div>
                  
                    <script>
                      function show_form() {
                        var x = document.getElementById("advanced_search");
                  
                        if (x.hidden) {
                          document.getElementById("sujet").value = "";
                          document.getElementById("etudiant").value = "";
                          document.getElementById("date").value = "";
                          document.getElementById("entreprise").value = "";
                          document.getElementById("lieu").value = "";
                          x.hidden = false;
                        } else {
                          document.getElementById("sujet").value = "";
                          document.getElementById("etudiant").value = "";
                          document.getElementById("date").value = "";
                          document.getElementById("entreprise").value = "";
                          document.getElementById("lieu").value = "";
                          x.hidden = true;
                        }
                      }
                  
                      function reset_all() {
                        document.getElementById("searchInput").value = "";
                        document.getElementById("sujet").value = "";
                        document.getElementById("etudiant").value = "";
                        document.getElementById("date").value = "";
                        document.getElementById("entreprise").value = "";
                        document.getElementById("lieu").value = "";
                        document.getElementById("advanced_search").hidden = true;
                        document.getElementById("nb_result").innerText = "0";
                        document.getElementById("mytable").remove();
                      }
                  
                      const customSelects = document.querySelectorAll("select");
                      const deleteBtn = document.getElementById(\'delete\')
                      const choices = new Choices(\'select\', {
                        searchEnabled: false,
                        itemSelectText: \'\',
                        removeItemButton: true,
                      });
                      for (let i = 0; i < customSelects.length; i++) {
                        customSelects[i].addEventListener(\'addItem\', function(event) {
                          if (event.detail.value) {
                            let parent = this.parentNode.parentNode
                            parent.classList.add(\'valid\')
                            parent.classList.remove(\'invalid\')
                          } else {
                            let parent = this.parentNode.parentNode
                            parent.classList.add(\'invalid\')
                            parent.classList.remove(\'valid\')
                          }
                        }, false);
                      }
                      deleteBtn.addEventListener("click", function(e) {
                        e.preventDefault()
                        const deleteAll = document.querySelectorAll(\'.choices__button\')
                        for (let i = 0; i < deleteAll.length; i++) {
                          deleteAll[i].click();
                        }
                      });
                    </script>
                      <style>
                      .s010 #form1 .table-responsive{
                        background: #FFF;
                        margin-top: 10px;
                        border-radius: 10px;
                      }
                      </style>
                  </body>
                  
                  </html>
                    ');
                    exit();
                }
                else{
                    header("Location: ../index.php?error=noresult&searchInput=".$_GET["searchInput"]);
                    exit();
                }
            }
        }
        else{
            header("Location: ../index.php?error=InvalidText");
            exit();
        }
    }
    else {
        header("Location: ../index.php?error=EmptyFields");
        exit();
        }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    }
    



