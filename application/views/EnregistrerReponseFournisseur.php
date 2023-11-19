<div class="content-wrapper">   
            <!-- Content -->
            <div class="container-xxl flex--1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestion </span> Proforma</h4>

              <div class="row">


                <!-- Merged -->
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Enregistrer Reponse Proforma </h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">
                    <?php if(isset($erreur)){
                      echo "<p style='color:red;''>".$erreur."</p>";
                      } ?>
                    <form action="<?php echo site_url("proforma/formulaireEnregistrementReponseProforma"); ?>" method="post">
                    <div class="mb-3">
                            <label for="formFile" class="form-label">Fournisseur</label>
                            <select class="form-select" id="" name="idfournisseur">
                              <option selected>Choisir</option> 
                              <?php for($i=0; $i<count($fournisseur); $i++){ ?>
                                <option value="<?= $fournisseur[$i]->idfournisseur ?>"><?= $fournisseur[$i]->nomfournisseur ?></option>
                              <?php } ?>
                            </select>
                    </div>

                    <input type="hidden" name="idbesoin" value="">

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Piece jointe</label>
                        <input class="form-control" type="file" id="formFile" name="piecejointe" />
                    </div>

                      <button type="submit" class="btn btn-primary">Enregistrer</button>                    
                    </form>
                    </div>
                  </div>
                </div>

                </div>
            </div>
        </div>
