<div class="content-wrapper">   
            <!-- Content -->
            <div class="container-xxl flex--1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestion </span> Proforma</h4>

              <div class=">


                <!-- Merged -->
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Saisie de proforma</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">
                    <form action="<?php echo site_url("welcome/formulaireDemandeConge"); ?>" method="post">

                    <div class="mb-3">
                        <div class="input-group">
                            <label class="input-group-text" for="inputGroupSelect01">Articles</label>
                            <select class="form-select" id="inputGroupSelect01">
                              <option selected>Choisir</option>
                              <option value="1">One</option>
                              <option value="2">Two</option>
                              <option value="3">Three</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <label class="input-group-text" for="inputGroupSelect01">Fournisseur</label>
                            <select class="form-select" id="inputGroupSelect01">
                              <option selected>Choisir</option> 
                              <option value="1">One</option>
                              <option value="2">Two</option>
                              <option value="3">Three</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="html5-number-input" class="col-md-2 col-form-label">Quantite <Article></Article></label>
                          <input class="form-control" type="number" value="0.0" id="html5-number-input" />
                    </div>

                    <div class="mb-3">
                        <label for="html5-number-input" class="col-md-2 col-form-label">Prix TTC</label>
                          <input class="form-control" type="number" value="18" id="html5-number-input" />
                    </div>

                      <div class="mb-3">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" />
                            <label class="form-check-label" for="defaultCheck1"> TVA </label>
                          </div>
                      </div>

                      <button type="submit" class="btn btn-primary">Enregistrer</button>
                    
                    </form>
                    </div>
                  </div>
                </div>

                </div>
            </div>
        </div>
