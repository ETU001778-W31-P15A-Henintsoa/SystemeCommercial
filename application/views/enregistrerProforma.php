<div class="content-wrapper">   
            <!-- Content -->
            <div class="container-xxl flex--1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestion </span> Proforma</h4>

              <div class="row">


                <!-- Merged -->
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Saisie de proforma</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">
                    <form action="<?php echo site_url("proforma/formulaireEnregitrementProforma"); ?>" method="post">
                    <input type="hidden" value=<?= $_GET['idproforma'] ?> name="idproforma"/>
        
                    <div class="mb-3">
                    <label for="html5-number-input" class="col-md-2 col-form-label"> Articles </label>
                            <select class="form-select" id="inputGroupSelect01" name="idarticle">
                              <option selected>Choisir</option>
                              <?php for($i=0; $i<count($articles); $i++){ ?>
                                <option value="<?= $articles[$i]->idarticle ?>"><?= $articles[$i]->nomarticle ?></option>
                              <?php } ?>
                            </select>
                    </div>

                    <div class="mb-3">
                          <label for="html5-number-input" class="col-md-2 col-form-label">Quantite </label>
                          <input class="form-control" type="number" value="0.0" id="html5-number-input" name="quantite"/>
                    </div>

                    <div class="mb-3">
                        <label for="html5-number-input" class="col-md-2 col-form-label">Prix TTC</label>
                          <input class="form-control" type="number" value="18" id="html5-number-input" name="prixTTc" />
                    </div>

                      <div class="mb-3">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="defaultCheck1" name="tva"/>
                            <label class="form-check-label" for="defaultCheck1"> TVA </label>
                          </div>
                      </div>

                      <div class="mb-3">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="defaultCheck1" name="livraisonpartielle"/>
                            <label class="form-check-label" for="defaultCheck1"> Livraison Partielle </label>
                          </div>
                      </div>

                      <button type="submit" class="btn btn-primary">Enregistrer</button>
                      <button type="button" class="btn btn-primary"><a href=<?= site_url("welcome/versAcceuil") ?>> Retour a L'acceuil</a></button>
                    
                    </form>
                    </div>
                  </div>
                </div>

                </div>
            </div>
        </div>
