<div class="content-wrapper">   
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> Listes </span> Entrees</h4>
                 
              <?php //var_dump($fournisseurs); ?>
              
              <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Entrees Valides</h5>
                     <div class="mb-3">
                      <div class="demo-inline-spacing mt-3">
                        <div class="list-group list-group-flush">
                        <table class="table" >
                                <tr>
                                    <th>Id Bon Entree</th>
                                    <th>Date Entree</th>
                                    <th>Reception</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tbody class="table-border-bottom-0">
                                <?php
                                    for ($j=0; $j <count($valide) ; $j++) { ?>
                                            <tr>
                                                <td><?php echo $valide[$j]->idbonentre ?></td>
                                                <td><?php echo $valide[$j]->dateentre; ?></td>
                                                <td><?php echo $valide[$j]->idbonreception; ?></td>
                                                <!-- <td><a href= <?php // site_url("Mail/versEnvoieMailBonEntree?idbonentre=".$valide[$j]->idbonentre)?>>Envoyer</a></td> -->
                                                <td><a href= <?= site_url("BonEntre/versDetailBonEntree?idbonentre=".$valide[$j]->idbonentre); ?>>Details</a></td>
                                                <td><a href= <?= site_url("BonEntre/genererPDF?idbonentre=".$valide[$j]->idbonentre); ?>>Gerener PDF</a></td>
                                            </tr>
                                        <?php }
                                ?>
                                </tbody>
                                    </table>
                      </div>
                    </div>
            </div>
        </div>