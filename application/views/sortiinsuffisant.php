<?php 
    // var_dump($insu);
?>
<style>
   a{
        color:white;
   } 
   #detail{
        width:400px;
        margin-left:auto;
        margin-right:auto;
    }
</style>
<br>
<br>
<div class="card" id="detail">
    <div class="mb-3 row">
        <h5 class="card-header" style="color:red" id="message">Vous ne pouvez pas faire cette sortie, quantite insuffisant</h5>
    </div>
     <div class="table-responsive text-nowrap">
     <table class="table" >
         <thead>
             <tr>
                 <th>Article</th>
                 <th>Quantité en stock</th>
                 <th>Quantité à faire sortir</th>
                 <tr><th>
             </tr>
         </thead>
         <tbody class="table-border-bottom-0">
             <?php
                 for ($j=0; $j <count($insu) ; $j++) { ?>
                         <tr>
                            <td><?php echo $insu[$j]['article']; ?></td>
                             <td><?php echo $insu[$j]['quantitedemande']; ?></td>
                             <td><?php echo $insu[$j]['quantiteStock']; ?></td>
                        </tr>
                    <?php }
            ?>
        </tbody>
    </table>

    <div class="demo-inline-spacing">
        <button type="button" class="btn btn-primary"><a href= <?php echo site_url("BonSorti/avoirSortiNonValideDept") ;?>>Annuler </a></button>
    </div>

    </div>