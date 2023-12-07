        <div class="content-wrapper">   
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Envoyer un </span> Bon Reception</h4>

              <div class="row">


                <!-- Merged -->
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Envoyer Bon De Reception a <?= $fournisseur[0]->nomfournisseur ?></h5>
                    
                    <div class="card-body demo-vertical-spacing demo-only-element">
                      <?php if(isset($erreur)){
                      echo "<p style='color:red;''>".$erreur."</p>";
                      } ?>
                    <form action="<?php echo site_url("mail/envoieMailReception"); ?>" method="post" enctype="multipart/form-data">
                      <input type="hidden" value="<?= $fournisseur[0]->idfournisseur ?>" name="idfournisseur">
                      <input type="hidden" value="<?= $_GET['idreception']?>" name="idreception">

                      <div class="mb-3">
                        <label for="formFile" class="form-label">Message</label>
                        <div class="input-group input-group-merge speech-to-text">
                            <textarea class="form-control" placeholder="Chere Jean, ......" rows="2" name="message"></textarea>
                        </div>
                      </div>

                      <div class="mb-3">
                        <label for="formFile" class="form-label">Piece jointe</label>
                        <input class="form-control" type="file" id="formFile" name="piecejointe" />
                      </div>

                      <button type="submit" class="btn btn-primary">Envoyer</button>
                    
                    </form>
                    </div>
                  </div>
                </div>

                </div>
            </div>
        </div>
