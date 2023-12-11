<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement de produit recu</title>
</head>
<style>
    body{
        width:1000px;
        margin-left:auto;
        margin-right:auto;
        float:right;
        backgroundcolor:red;
    }
   
    /* input{
        width:1000px;
    } */
</style>
<body>
    <form action="<?php echo site_url("AccuseReception/validerExplication"); ?>" method="post" >
        <input type="hidden" value=<?php echo $accuse; ?> name="idbon" id="inputHidden">
        <div class="mb-3 row">
            <div>
                <label for="exampleFormControlTextarea1" class="form-label">Votre Explication</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="raison"></textarea>
            </div>
        </div>
        <div class="mb-3">
            <div class="card-body">
                <div class="demo-inline-spacing">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
        </div>
    </form> 
</body>
</html>
