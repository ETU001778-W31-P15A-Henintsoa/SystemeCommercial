<style>
    a :hover{
        color: orange;
    }

    a{color: orange;}
</style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Listes </span> Regroupements</h4>
              <div class="card">
                <h5 class="card-header">Regroupement sans Proforma</h5>
                <div class="text-nowrap">
                  <table class="table">
                      <!-- <thead> -->
                        <tr>
                          <th><strong>idRegroupement</strong></th>
                          <th><strong>Date Regroupement</strong></th>
                          <th><strong>Etat</strong></th>
                          <th><strong></strong></th>
                        </tr>
                      <!-- </thead> -->
                      <tbody class="table-border-bottom-0">
                        <?php // var_dump($demandeemployevalider); ?>
                        <?php for($i=0; $i<count($regroupement); $i++){ ?>
                        <tr>
                            <td>
                                <!-- <i class="fab fa-angular fa-lg text-danger me-3"></i>  -->
                            <?= $regroupement[$i]->idregroupement ?></td>
                            <td><?= $regroupement[$i]->dateregroupement ?></td>
                            <td><span class="badge bg-label-warning me-1"><a  href="<?php echo site_url('Mail/versEnvoieMail?idregroupement='.$regroupement[$i]->idregroupement); ?>">Demande de Proforma</a></span></td>
                        </tr>
                        <?php } ?>  
                      </tbody>
                  </table>
                </div>
              </div>
