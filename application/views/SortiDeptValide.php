<?php 
   // var_dump($sorti[0]);
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
    a{
        color:blue;
        margin-left:auto;
        margin-right:auto;
    }
</style>
 <div class="row mb-5">
    <?php 
        for ($i=0; $i <count($sorti) ; $i++) { ?>
            <div class="col-md-6 col-lg-4 mb-3"  id="nonValide">
                  <div class="card">
                    <div class="card-body">
                        <div>
                        <h5 class="card-title" id="date"><?php echo "Date: ".$sorti[$i]['sorti']->datesortie; ?></h5></div>
                        <br>
                        <div>
                        <h5 class="card-title" id="date"><?php echo "Département: ".$sorti[$i]['sorti']->nomdepartement; ?></h5>
                        </div>
                            

                        <div class="card" id="detail">
                            <div class="table-responsive text-nowrap">
                             <?php
                                        for ($j=0; $j <count($sorti[$i]['detail']) ; $j++) { ?>
                                <table class="table" >
                                <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th>Quantite</th>
                                        <tr><th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                   
                                                <tr>
                                                    <td><?php echo $sorti[$i]['detail'][$j]->nomarticle; ?></td>
                                                    <td><?php echo $sorti[$i]['detail'][$j]->quantite; ?></td>
                                                </tr>
                                    
                                </tbody>
                            </table>
                            <div>
                        <a  href="<?php echo site_url('Mail/versEnvoieMailBonSortie?idbonsorti='.$sorti[$i]['sorti']->idbonsortie).'&iddepartement='.$sorti[$i]['sorti']->iddepartement; ?>">Envoyer Mail</a>
                    </div>
                    <div>
                        <a  href="<?php echo site_url('BonSorti/genererPDF?idbonsorti='.$sorti[$i]['sorti']->idbonsortie).'&iddepartement='.$sorti[$i]['sorti']->iddepartement; ?>">Generer PDF</a>
                    </div>

                            <?php } ?>
                            </div>
                        </div>
                </div>
            </div>
        <?php }?>
       
</div>