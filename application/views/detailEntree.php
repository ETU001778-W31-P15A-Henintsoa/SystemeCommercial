<div class="content-wrapper">   
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> Details </span> Entree</h4>
                 
              <?php //var_dump($fournisseurs); ?>
              
              <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Entree du <?= $entree[0]->dateentre ?></h5>
                    <h5 class="card-header">idReception :  <?= $entree[0]->idbonreception ?></h5>
                     <div class="mb-3">
                      <div class="demo-inline-spacing mt-3">
                        <div class="list-group list-group-flush">
                        <table class="table" >
                                <tr>
                                    <th>Designation</th>
                                    <th>Quantite</th>
                                </tr>
                                <tbody class="table-border-bottom-0">
                                <?php foreach($entree as $r){ 
                                    if($r->quantite != 0){?>
                                        <tr>
                                            <td><?= $r->nomarticle ?></td>
                                            <td><?= $r->quantite?></td>
                                        </tr>   
                                    <?php }
                                    } ?>
                                </tbody>
                                    </table>
                                    <br>
                                    <br>
                                    <h5 style="text-decoration: underline;">Non equivalence dans la entree</h5>
                                    <br>
                        <table class='table'>
                             <tr>
                        <th>Designation</th>
                        <th>Quantité Commande</th>
                        <th>Quantité Recus</th>
                    </tr>
                <tbody>
                    <?php foreach($anormal as $a){  ?>
                        <tr>
                            <td><?= $a['article'] ?></td>
                            <td style="color: green;"><?= $a['quantiteDemande']?></td>
                            <td style="color: red;"><?= $a['quantiteRecu']?></td>
                        </tr>   
                    <?php } ?>
                </tbody>
            </table>
                      </div>
                    </div>
            </div>
        </div>