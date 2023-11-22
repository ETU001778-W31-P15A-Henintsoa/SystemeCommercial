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
        width:400px;
    }
    #button{
        width:200px;
        margin-left:550px;
    }
</style>
 <div class="row mb-5">
    <?php 
        for ($i=0; $i <count($regroupement) ; $i++) { ?>
            <div class="col-md-6 col-lg-4 mb-3"  id="nonValide">
                  <div class="card">
                    <div class="card-body">
                        <div>
                        <h5 class="card-title" id="date"><?php echo "Date: ".$regroupement[$i]['regroupement']->dateregroupement; ?></h5></div>
                            

                        <div class="card" id="detail">
                            <div class="table-responsive text-nowrap">
                            <table class="table" >
                                <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th>Quantite</th>
                                        <tr><th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <?php
                                        for ($j=0; $j <count($regroupement[$i]['detail']) ; $j++) { ?>
                                                <tr>
                                                    <td><?php echo $regroupement[$i]['detail'][$j]->nomarticle; ?></td>
                                                    <td><?php echo $regroupement[$i]['detail'][$j]->quantite; ?></td>
                                                    <td>
                                                        <a href="<?php echo site_url("ControllerRegroupement/avoirDetailRegroupement?idArticle=". $regroupement[$i]['detail'][$j]->idarticle."& idRegroupement=".$regroupement[$i]['regroupement']->idregroupement  ); ?>" class="btn btn-primary">voir détail</a>
                                                    </td>
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
       
</div>