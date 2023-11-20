<?php 
    // var_dump($besoinAchat[0]);
?>
<style>
 #nonValide{
        margin-left:auto;
        margin-right:auto;
       
    }
    #date{
        float:right;
        margin-top:-25px;
    }
    #detail{
        width:200px;
    }
    #button{
        width:200px;
        margin-left:550px;
    }
</style>
 <div class="row mb-5">
    <?php 
        for ($i=0; $i <count($besoinAchat) ; $i++) { ?>
            <div class="col-md-6 col-lg-4 mb-3"  id="nonValide">
                  <div class="card">
                    <div class="card-body">
                        <div><h5 class="card-title"><?php echo $besoinAchat[$i]['besoin']->nom." ".$besoinAchat[$i]['besoin']->prenom; ?></h5>
                        <br>
                        <h5 class="card-title" id="date"><?php echo "Date: ".$besoinAchat[$i]['besoin']->datebesoin; ?></h5></div>
                            

                        <div class="card" id="detail">
                            <h5 class="card-header">Details des besoins</h5>
                            <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th>Quantite</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <?php
                                        for ($j=0; $j <count($besoinAchat[$i]['detail']) ; $j++) { ?>
                                                <tr>
                                                    <td><?php echo $besoinAchat[$i]['detail'][$j]->nomarticle; ?></td>
                                                    <td><?php echo $besoinAchat[$i]['detail'][$j]->quantite; ?></td>
                                                </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                
            </div>
        <?php }?>
        <div class="row mb-3" id="button">
             <a href="<?php echo site_url("ControllerBesoinAchat/regrouper") ?>" class="btn btn-primary">Regrouper les achats</a>
        </div>
       
</div>