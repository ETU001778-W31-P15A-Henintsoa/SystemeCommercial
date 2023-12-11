<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement de sorti</title>
</head>
<style>
    body{
        width:1000px;
        margin-left:auto;
        margin-right:auto;
        float:right;
        backgroundcolor:red;
    }
    #plus{
        margin-left:auto;
        margin-right:auto;
    }
    /* input{
        width:1000px;
    } */
</style>
<body>
    <form action="<?php echo site_url("BonSorti/entrerSortiClient"); ?>" method="post" >
        <input type="hidden" value="1" name="nombreArticle" id="inputHidden">
        <div class="mb-3 row">
            <label for="html5-date-input" class="col-md-2 col-form-label">Date de sorti</label>
                <div class="col-md-10">
                    <input class="form-control" type="date"  id="html5-date-input" name="datesorti" />
                </div>
        </div>
        <div class="mb-3 row">
            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="idClient">
                <?php 
                    for ($i=0; $i <count($client) ; $i++) { ?>
                        <option value="<?php echo $client[$i]->idclient; ?>"><?php echo $client[$i]->nomclient; ?></option>
                <?php }
                ?>
            </select>
        </div>
        <div class="mb-3" id="form">
            <label for="exampleFormControlSelect1" class="form-label">Entrez un article</label>
            <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="article1">
                <?php 
                    for ($i=0; $i <count($article) ; $i++) { ?>
                        <option value="<?php echo $article[$i]->idarticle; ?>"><?php echo $article[$i]->nomarticle; ?></option>
                <?php }
                ?>
            </select>
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <div class="mb-3 row">
                    <input
                        type="number"
                        class="form-control border-0 shadow-none"
                        placeholder="quantite"
                        name="quantite1"
                    />
                </div>
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                <span id="plus"><label for="exampleFormControlSelect1" class="form-label"><button type="button" onclick="autreArticle()" >+</button></label></span>
                </div>
              </div>
        </div>
        <div class="mb-3">
            <div class="card-body">
                <div class="demo-inline-spacing">
                    <button type="submit" class="btn btn-primary">Entrer</button>
                </div>
            </div>
        </div>
    </form> 
</body>


<script>
    window.onbeforeunload = function() {
        localStorage.setItem('quantiteArticle',1);
    };

    function avoirQuantite(){
        return localStorage.setItem('quantiteArticle');
    }

    function autreArticle() {
        var numero=localStorage.getItem('quantiteArticle');
        // var quantite = 'quantite'+$numero;
        var nombreArticle=parseInt(numero)+1;
        // var element = document.getElementById(string);
        //     if (element.value == "") {
        //         alert("Assurer vous d'abord que les anciens formulaires sont bien remplis");
        //     } else {
                var conteneurForm= document.getElementById("form");
                
                
                // var idspan = "" + idbesoins + numeroquestion+numeroreponse
                var div=document.createElement("div");
                var nouveau =   '<label for="exampleFormControlSelect1" class="form-label">Entrez un article</label><select name=article'+nombreArticle+' class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" ><?php for ($i=0; $i <count($article) ; $i++) { ?><option value="<?php echo $article[$i]->idarticle; ?>"><?php echo $article[$i]->nomarticle; ?></option><?php } ?></select><div class="navbar-nav align-items-center"><div class="nav-item d-flex align-items-center"><i class="bx bx-search fs-4 lh-0"></i><input type="number" class="form-control border-0 shadow-none" placeholder="quantite" name=quantite'+nombreArticle+' /> </div> </div> <div class="navbar-nav align-items-center"> <div class="nav-item d-flex align-items-center"><span id="plus"><label for="exampleFormControlSelect1" class="form-label"><button type="button" onclick="$nombreQuantite=autreArticle()">+</button></label></span> </div> </div>';
                div.innerHTML = nouveau;
                conteneurForm.appendChild(div);
                localStorage.setItem('quantiteArticle',nombreArticle)

                var hidden=document.getElementById("inputHidden");
                hidden.value=nombreArticle;

                var span = document.getElementById("plus");
                span.remove();
    }
</script>
</html>