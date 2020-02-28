<html>
  <head>
      <title>page1</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700" rel="stylesheet" />
    <link href="main.css" rel="stylesheet" />
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
.inputstl { 
    padding: 9px; 
    border: solid 1px #517B97; 
    outline: 0; 
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CDDBE4), to(#FFFFFF)); 
    background: -moz-linear-gradient(top, #FFFFFF, #CDDBE4 1px, #FFFFFF 25px); 
     
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px; 

    } 

.frspan { 
    border: solid 1px #517B97; 
    background: #517B97; 
    }     
   
</style>
  </head>
  <body>
  
        <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container-fluid d-flex">

      <div class="logo mr-auto">
          
        <!--<h1 align="center"  class="text-light"><a  href="index.html"><span>TRIED </span></a></h1>>
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="index.html"><img src="./images/logo.png" alt="" class="img-responsive" align= "left" ></a>
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="get-started"><a href="#about" id="créer">créer un compte</a></li>
          
      
          <li class="get-started"><a href="#about" id="seconnecter">se connecter</a></li>
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->
      
      
      </********************>

    <div class="s010">
      <form id="form1" action="includes/search.inc.php" method="get" >
      <?php
        if ($_GET["error"] === "EmptyFields"){
          echo('<div class="alert alert-danger" role="alert">
                  Please fill the form!
                </div>');
        }
        elseif ($_GET["error"] === "sqlerror"){
          echo('<div class="alert alert-danger" role="alert">
                  SQL error!
                </div>');
        }
        elseif ($_GET["error"] === "noresult"){
          echo('<div class="alert alert-danger" role="alert">
                  No results!
                </div>
                <script>
                  document.getElementById("nb_result").innerText = "0";
                </script>
                ');
        }


      ?>
        <div class="inner-form">
<!création de la barre de recherche>
          <div class="basic-search">
            <div class="input-field">
              <input id="searchInput" name="searchInput" type="text" placeholder="Mot clé" >
              <div class="icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                </svg>
              </div>
            </div>
          </div>
            <div class="advance-search">

           <button type="button" class="btn btn-info" onclick="show_form()" class="desc">Recherche avancée</button>
<!création de la check box>            
            <div id="advanced_search" class="form-group" hidden>
              <input class="form-control" id ="sujet" name="sujet" type="text" placeholder="Sujet"><br>
              <input class="form-control" id ="etudiant" name="etudiant" type="text" placeholder="Etudiant" ><br>
                <input class="form-control" id ="date" name="date" type="text" placeholder="Année" ><br>
                <input class="form-control" id ="entreprise" name="entreprise" type="text" placeholder="Entreprise" ><br>
                <input class="form-control" id ="lieu" name="lieu" type="text" placeholder="lieu" ><br>
            </div>
          
<!création des deux boutons rechercher er reset ainsi que le nbr de résultats>           
            <div class="row third">
              <div class="input-field">
                <div class="result-count">
                  <span id="nb_result" >0 </span>résultats</div>
                <div class="group-btn">
                  <button onclick="reset_all()" type="reset" class="btn-delete" name="reset">RESET</button>
                  <button type="submit" class="btn-search" name="search_submit">rechercher</button>
                </div>
              </div>
            </div>
            
            </div>
          </div>
        
      </form>
    </div>
    <script src="js/extention/choices.js"></script>
    <script>
      function show_form(){
        var x = document.getElementById("advanced_search");
        
        if (x.hidden){
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
      }}
      function reset_all(){
        document.getElementById("form1").reset();
        document.getElementById("advanced_search").hidden = true;
      }

      const customSelects = document.querySelectorAll("select");
      const deleteBtn = document.getElementById('delete')
      const choices = new Choices('select',
      {
        searchEnabled: false,
        itemSelectText: '',
        removeItemButton: true,
      });
      for (let i = 0; i < customSelects.length; i++)
      {
        customSelects[i].addEventListener('addItem', function(event)
        {
          if (event.detail.value)
          {
            let parent = this.parentNode.parentNode
            parent.classList.add('valid')
            parent.classList.remove('invalid')
          }
          else
          {
            let parent = this.parentNode.parentNode
            parent.classList.add('invalid')
            parent.classList.remove('valid')
          }
        }, false);
      }
      deleteBtn.addEventListener("click", function(e)
      {
        e.preventDefault()
        const deleteAll = document.querySelectorAll('.choices__button')
        for (let i = 0; i < deleteAll.length; i++)
        {
          deleteAll[i].click();
        }
      });

    </script>
  </body>
</html>
