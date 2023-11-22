
<style>
    #listeEmp{
        width:75%;
       margin-left:300px;
       margin-right:auto;
    }
</style>
    <div class="card" id="listeEmp">
         
         
          </nav>
                <h5 class="card-header">Liste des regroupements</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead class="table-dark">
                    <tr>
                        <th>idregroupement </th>
                        <th>date regroupement </th>
                        <th>etat</th>
                        <th>quantite</th>
                        <th>idarticle</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php 
                            foreach($regroupement as $regroupements) { ?>
                                 <tr>
                                    <td><?php echo $regroupements['idregroupement']; ?></td>
                                    <td><?php echo $regroupements['dateregroupement']; ?></td>
                                    <td><?php echo $regroupements['etat']; ?></td>
                                    <td><?php echo $regroupements['quantite']; ?></td>
                                    <td><?php echo $regroupements['idarticle']; ?></td>
                                    <td><a href="<?php echo site_url('BonDeCommande/generer?idregroupement='.$regroupements['idregroupement']); ?>">Generer Bon De Commande</a></td>
                                </tr>
                            <?php }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
