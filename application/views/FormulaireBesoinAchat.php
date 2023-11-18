<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions/Reponses</title>
</head>
<body>

<?php  // var_dump($besoin); ?>
    <form action="<?php echo site_url("welcome/formulaireFicheEvaluation"); ?>" method="post">
        <div >
            <!-- <h3>Question pour le <?php echo $besoin[$i]->branche; ?></h3> -->
            <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="hidden" name="<?php echo $article[$i]->idArticle; ?>" value="<?php echo $article[$i]->idArticle; ?>"></div>
            <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="hidden" name="iddepartement" value="<?php echo $besoin[$i]->iddepartement; ?>"></div>
            <!-- Question 1 -->
            <div id="question1">
                <h5>Question 1</h5>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="text" name="<?php echo $article[$i]->idArticle; ?>question1" placeholder="Question1"></div>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="number" name="<?php echo $article[$i]->idArticle; ?>coeffquestion1" placeholder="Coefficient"></div>
                </br>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="text" name="<?php echo $article[$i]->idArticle; ?>question1reponse" placeholder="question1reponse1"></div>
                </br>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="text" name="<?php echo $article[$i]->idArticle; ?>question1autre1" id="question1autre1" placeholder="Autre 1"><span id="<?php echo $article[$i]->idArticle; ?>11"><button type="button" id="<?php echo $article[$i]->idArticle; ?>11" onclick="plusautrereponse('<?php echo $article[$i]->idArticle; ?>',1,1)">+</button></span></div>
                <div id='question1autre2'></div>
            </div>

            <!-- Question 2 -->
             <div id="question2">
                <h5>Question 2</h5>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="text" name="<?php echo $article[$i]->idArticle; ?>question2" placeholder="Question2"></div>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="number" name="<?php echo $article[$i]->idArticle; ?>coeffquestion2" placeholder="Coefficient"></div>
                </br>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="text" name="<?php echo $article[$i]->idArticle; ?>question2reponse" placeholder="question2reponse1"></div>
                </br>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="text" name="<?php echo $article[$i]->idArticle; ?>question2autre1" id="question2autre1" placeholder="Autre 1"><span id="<?php echo $article[$i]->idArticle; ?>21"><button type="button" id="<?php echo $article[$i]->idArticle; ?>21" onclick="plusautrereponse('<?php echo $article[$i]->idArticle; ?>',2,1)">+</button></span></div>
                <div id='question2autre2'></div>
            </div>

             <!-- Question 3 -->
            <div id="question3">
                <h5>Question 3</h5>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="text" name="<?php echo $article[$i]->idArticle; ?>question3" placeholder="Question3"></div>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="number" name="<?php echo $article[$i]->idArticle; ?>coeffquestion3" placeholder="Coefficient"></div>
                </br>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="text" name="<?php echo $article[$i]->idArticle; ?>question3reponse" placeholder="question3reponse1"></div>
                </br>
                <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="text" name="<?php echo $article[$i]->idArticle; ?>question3autre1" id="question3autre1" placeholder="Autre 1"><span id="<?php echo $article[$i]->idArticle; ?>31"><button type="button" id="<?php echo $article[$i]->idArticle; ?>31" onclick="plusautrereponse('<?php echo $article[$i]->idArticle; ?>',3,1)">+</button></span></div>
                <div id='question3autre2'></div>
            </div>
            </div>
    </div>
    <div class="mb-3"><input id="basic-default-fullname" class="form-control" type="submit" value="OK">
    </form> 
</body>


<script>
    function plusautrereponse(idbesoins, numeroquestion, numeroreponse) {
        var string = 'question' + numeroquestion + 'autre' + numeroreponse;
        // alert(string);
        var element = document.getElementById(string);
            if (element.value == "") {
                alert("Suggestion vide");
            } else {

                numeroreponseavant = numeroreponse;
                numeroreponse = numeroreponse + 1;
                numeromanaraka = numeroreponse + 1;

                var idspan = "" + idbesoins + numeroquestion+numeroreponse

                var nouveau = "<div class="mb-3"><input id="basic-default-fullname" class="form-control" type=text name='"+idbesoins+"question" + numeroquestion + "autre" + numeroreponse + "' id='question"+numeroquestion+"autre"+numeroreponse+"' placeholder='Autre " + numeroreponse + "'  "+"/> <span id='"+ idspan +"'><button type='button' id='"+ idspan +"'  onclick=plusautrereponse('" +idbesoins+ "'," + numeroquestion + "," + numeroreponse + ")>+</button></span>" +
                    "<div id='question" + numeroquestion + "autre" + numeromanaraka + "'></div>";

                string = 'question' + numeroquestion + 'autre' + numeroreponse;
                // alert(nouveau);

                var conteneur = document.getElementById(string);
                conteneur.innerHTML = nouveau;

                //Creation du bouton
                // let btn = document.createElement("button");
                // btn.innerHTML = "+";
                // btn.type = "button";

                // btn.addEventListener("click",()=>{
                //     plusautrereponse(idbesoins , numeroquestion,numeroreponse); 
                // });

                // var span = document.getElementById(idspan);
                // span.appendChild(btn);

                // alert("" + idbesoins + numeroquestion + "" + numeroreponseavant);

                // Suppression du span
                var ancienSpan = document.getElementById("" + idbesoins + numeroquestion + "" + numeroreponseavant);
                ancienSpan.remove();
            }   
    }
</script>
</html>