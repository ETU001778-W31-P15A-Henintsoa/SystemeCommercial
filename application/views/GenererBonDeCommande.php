
<style>
  #choix{
    width:900px;
       margin-left:300px;
       margin-right:auto;
  }
</style>
<div class="content-wrapper" id="choix">
<div class="container-xxl flex-grow-1 container-p-y" class="choix">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Bon de</span> Commande</h4>
             <!-- Basic Layout -->
              <div class="row">
                <div class="col-xl">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Generer Bon De Commande</h5>
                      <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">
                        <?php if(isset($erreur)){
                            echo "<p style=color:red;>".$erreur."</p>";
                        }?>
                      <form action="<?php  echo site_url("BonDeCommande/genererBonDeCommande"); ?>" method="post">
                      <div class="mb-3 row">
                        <label for="html5-date-input" class="col-md-2 col-form-label">Date delai de livraison</label>
                        <div class="col-md-10">
                          <input class="form-control" type="date"  name="delai" id="html5-date-input" />
                        </div>
                      </div>
                      <div class="mb-3">
                            <label for="defaultSelect" class="form-label">Type de paiment</label>
                            <?php //echo count($employe); ?>
                            <select id="defaultSelect" class="form-select" name="paiement">
                            <!-- <option>Choisir</option> -->
                            <?php foreach($typepaiement as $typepaiements) { ?>
                                <option value="<?php echo $typepaiements['idtypedepayement']; ?>"><?php echo $typepaiements['libelle']; ?> </option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="defaultSelect" class="form-label">Livraison</label>
                            <?php //echo count($employe); ?>
                            <select id="defaultSelect" class="form-select" name="livraison">
                            <!-- <option>Choisir</option> -->
                            <?php foreach($livraison as $livraisons) { ?>
                                <option value="<?php echo $livraisons['idlivraison']; ?>"><?php echo $livraisons['libelle']; ?> </option>
                            <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Generer</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
</div>
</div>