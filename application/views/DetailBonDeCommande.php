
    <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Bon de</span> Commande</h4>

        <!-- Logo -->
        
       
        <div class="card">
            <center>
              <h3>Bon de commande</h3>
            <h3><?php
                date_default_timezone_set('Africa/Nairobi');
              //$date=new dateTime($donnee['date']->date);
                echo $donnee[0]['datebondecommande'];
              ?> </h3>  
            </center>
        </div>

        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-body">
                        <p for=""><strong>Fournisseur : </strong> <?php echo $donnee[0]['nomfournisseur']; ?></p>
                        <p for=""><strong>IDBonDeCommande : </strong> <?php echo $donnee[0]['idbondecommande']; ?></p>
                        <p for=""><strong>Delai de livraison :</strong> </p>
                        <p for=""><strong>livraison partielle :</strong> <?php ?></p>
                        <p for=""><strong>Mode de payment :</strong> <?php ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header"></h5>
            <div class="card-body">
                <div class="text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>quantite</th>
                                <th>pu</th>
                                <th>Total TTC</th>
                                <th> HT</th>
                                <th> TVA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                // $sommettc = 0;
                                $sommeht = 0;
                                $sommetva = 0;
                                foreach($donnee as $donnees) { 
                                    $ttc;
                            ?>
                            <tr>
                                <td><?php echo $donnees['idarticle']; ?></td>
                                <td><?php echo $donnees['quantite']; ?></td>
                                <td><?php echo $donnees['pu']; ?></td>
                                <td><?php echo $ttc = $donnees['ttc']; ?></td>
                                <td><?php echo $ht = $ttc / (1 + (20 / 100)); ?></td>
                                <td><?php echo $tva = $ht * (20 / 100); ?></td>
                            </tr>
                            
                            <?php  
                                // $sommettc += $ttc; 
                                $sommeht += $ht;
                                $sommetva += $tva;
                            } ?>
                            <tr>
                                <td></td><td></td><td></td>
                                <td><?php echo  $sommeTTC; ?></td>
                                <td><?php echo  $sommeht; ?></td>
                                <td><?php echo  $sommetva; ?></td>
                            <tr>
                        </tbody>
                     
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-body">
                        <p>Arreter le present commande a la somme de <?php echo $lettre; ?> Ariary <b>
                        </p>
                   </div>
                </div>
            </div>
        </div>
    </div>