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
    a{
        color:blue;
        margin-left:auto;
        margin-right:auto;
    }
</style>
 <div class="row mb-5">
    <?php 
        for ($i=0; $i <count($entre) ; $i++) { ?>
            <div class="col-md-6 col-lg-4 mb-3"  id="nonValide">
                  <div class="card">
                    <div class="card-body">
                        <div>
                        <h5 class="card-title" id="date"><?php echo "Date: ".$entre[$i]['entre']->dateentre; ?></h5></div>
                            

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
                                        for ($j=0; $j <count($entre[$i]['detail']) ; $j++) { ?>
                                                <tr>
                                                    <td><?php echo $entre[$i]['detail'][$j]->nomarticle; ?></td>
                                                    <td><?php echo $entre[$i]['detail'][$j]->quantite; ?></td>
                                                </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <a  href="<?php echo site_url('bonentre/validerBonEntre?idBonEntre='.$entre[$i]['entre']->idbonentre); ?>">Valider</a>
                  </div>
                </div>
            </div>
        <?php }?>
       
</div>