
<style>
    #detail{
        width:400px;
        margin-left:auto;
        margin-right:auto;
    }
    #message{
       width:700px;
       margin-left:auto;
       margin-right:auto;
    }
    a{
        color:white;
    }
    button{
        margin-left:auto;
        margin-right:auto;
    }
</style>
<h5 class="card-header" style="color:red" id="message">Il semblerait que les quantité recu de correspondent pas au quantité commandé, veillez envoyer un mail chez notre fournisseur</h5>
<div class="card" id="detail">
     <div class="table-responsive text-nowrap">
     <table class="table" >
         <thead>
             <tr>
                 <th>Article</th>
                 <th>Quantite normal</th>
                 <th>Quantite recu</th>
                 <tr><th>
             </tr>
         </thead>
         <tbody class="table-border-bottom-0">
             <?php
                 for ($j=0; $j <count($nbArticleAnormal) ; $j++) { ?>
                         <tr>
                            <td><?php echo $nbArticleAnormal[$j]['article']; ?></td>
                             <td><?php echo $nbArticleAnormal[$j]['quantiteDemande']; ?></td>
                             <td><?php echo $nbArticleAnormal[$j]['quantiteRecu']; ?></td>
                        </tr>
                    <?php }
            ?>
        </tbody>
    </table>
    </div>
    <div class="demo-inline-spacing">
        <button type="button" class="btn btn-primary"><a href= <?= site_url("Mail/versEnvoieMailBonDeReception?idfournisseur=".$nbArticleAnormal[0]['fournisseur']."&idreception=".$nbArticleAnormal[0]['idreception']); ?>>Envoyer un mail et valider</a></button>


        <button type="button" class="btn btn-primary"><a href= <?= site_url("BonReception/genererPDF?idfourniseur=".$nbArticleAnormal[0]['fournisseur']."&idreception=".$nbArticleAnormal[0]['idreception']); ?>>Gerener PDF</a></button>
    </div>
</div>