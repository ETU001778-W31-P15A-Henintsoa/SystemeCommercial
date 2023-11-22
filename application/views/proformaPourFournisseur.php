        <style>
            #main {
                display: center;
                text-align: left;
            }
        </style>


        <div id='main'>
              <h2> Demande de Proforma </h2>
                <div class="text-nowrap">
                    <tbody>
                        <?php foreach($regroupement as $chacun){ ?>
                            <div>
                                <p> <strong>Article : </strong> <?= $chacun -> nomarticle ?> (<?= $chacun -> quantite ?> pieces)</p>
                            </div>
                        <?php } ?>                        
                    </tbody>
                </div>
        </div>
