
<head>
    <title>Liste Bon de Commande</title>
</head>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Bon de </span> Commande</h4>
        
          <div class="card">
                <h5 class="card-header">Bon de Commande Valides</h5>
                <div class="text-nowrap">
                  <table class="table">
                      <!-- <thead> -->
                        <tr>
                          <th><strong>idBonDeCommande</strong></th>
                          <th><strong>Fournisseur</strong></th>
                          <th><strong>date bon de commande</strong></th>
                          <th><strong></strong></th>
                        </tr>
                      <!-- </thead> -->
                      <tbody class="table-border-bottom-0">
                        <tr>
                        </tr>
                      </tbody>
                  </table>
                </div>
              </div>

             
                <div class="card">
                    <h5 class="card-header">Bon de Commande Non Valides</h5>
                    <div class="text-nowrap">
                    <table class="table">
                        <!-- <thead> -->
                        <tr>
                        <th><strong>idBonDeCommande</strong></th>
                            <th><strong>Fournisseur</strong></th>
                            <th><strong>date bon de commande</strong></th>
                            <th><strong></strong></th>
                        </tr>
                        <!-- </thead> -->
                        <tbody class="table-border-bottom-0">
                        <?php foreach($bonDeCommandeNonValide as $bdcnv) { ?>
                        <tr>
                            <td><?php echo $bdcnv['idbondecommande'];  ?></td>
                            <td><?php echo $bdcnv['idfournisseur']; ?></td>
                            <td><?php echo $bdcnv['datebondecommande']; ?></td>
                            <td><span class="badge bg-label-warning me-1">Non Valide</span></td>
                            <td>
                                <a href="<?php echo site_url(""); ?>">
                                    <i class="bx bx-check" style="color:green;">
                                    </i>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo site_url("BonDeCommande/versDetailBonDeCommande?id=".$bdcnv['idbondecommande']); ?>">Voir Detail</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>

             

             
              