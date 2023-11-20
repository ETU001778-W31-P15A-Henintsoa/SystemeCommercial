
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
                        <th>departement </th>
                        <th>article </th>
                        <th>quantite</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php 
                            foreach($detail as $detail) { ?>
                                 <tr>
                                    <td><?php echo $detail->nomdepartement; ?></td>
                                    <td><?php echo $detail->nomarticle; ?></td>
                                    <td><?php echo $detail->quantite; ?></td>
                                </tr>
                            <?php }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
