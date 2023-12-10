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
    h5{
        margin-left:450px;

    }
</style>
 <div class="row mb-5">
 <div class="mb-3 row">
        <h5 class="card-header"  id="message">Liste des Accusés de reception validées</h5>
    </div>
    <br>
    <?php 
        for ($i=0; $i <count($accuse) ; $i++) { ?>
            <div class="col-md-6 col-lg-4 mb-3"  id="nonValide">
                  <div class="card">
                    <div class="card-body">
                        <div>
                        <h5 class="card-title" id="date"><?php echo "Date: ".$accuse[$i]['accuse']->dateaccuse; ?></h5></div>
                        <br>
                            

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
                                        for ($j=0; $j <count($accuse[$i]['detail']) ; $j++) { ?>
                                                <tr>
                                                    <td><?php echo $accuse[$i]['detail'][$j]->nomarticle; ?></td>
                                                    <td><?php echo $accuse[$i]['detail'][$j]->quantite; ?></td>
                                                </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                        <a  href="<?php echo site_url('AccuseReception/validerAccuseReception?idaccuse='.$accuse[$i]['accuse']->idaccusereception); ?>">Convertir en PDF</a>
                        <a  href="<?php echo site_url('AccuseReception/annuler'); ?>">Annuler </a>
                    </div>

                </div>
            </div>
        <?php }?>
       
</div>