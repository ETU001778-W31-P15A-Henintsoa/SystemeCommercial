<div class="content-wrapper">   
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Messages </span> DIMPEX </h4>
                 
              <?php //var_dump($departements); ?>
              
              <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Departements</h5>
                     <!-- List group Flush (Without main border) -->
                     <div class="mb-3">
                      <div class="demo-inline-spacing mt-3">
                        <div class="list-group list-group-flush">
                            <?php foreach($departements as $departement){ ?>
                          <a href=<?= site_url("Mail/versAfficheMessagesDepartement?iddepartement=".$departement->iddepartement) ?> class="list-group-item list-group-item-action"><?=$departement->nomdepartement?></a>
                          <?php } ?>
                          
                        </div>
                      </div>
                    </div>
                    <!--/ List group Icons -->
            </div>
        </div>