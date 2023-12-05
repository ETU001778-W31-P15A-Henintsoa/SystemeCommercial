<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= site_url("../assets/css/message.css") ?>>
    <title>DIMPEX - Messages</title>
</head>
        <div class="content-wrapper">   
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Interaction mail - </span> <?= $nomFournisseur ?></h4>
                <!-- Merged -->
                <div class="col-md-12">
                  <div class="card mb-3" id="conteneur-message">
                    <p style="color: grey;"><?= $taille ?></p>
                    <?php
                    // var_dump($messages); 
                    foreach($messages as $message){ 
                        if($message->etat==1){
                        ?>
                            <!-- <div class="messaging-container"> -->
                            <div class="mb-3 person person-1">
                                
                                <div id="icone"><i class="fas fa-user"></i></div>
                                <div id="icone" class="bubble2">
                                    <div class="message"><?= explode("//", $message->libelle)[1] ?></div>
                                    <?php if($message->p==1){ ?>
                                        <div><img src=<?= base_url("upload/".$message->piecejointe) ?> alt=<?= $message->piecejointe ?>></div>
                                    <?php } ?>    
                                </div>
                                
                                <div id="date"><?= $message->dateenvoie ?></div>
                            </div>
                        <?php }else{ ?>
                    <div class="mb-3 person person-2">
                       <!-- <i class="fas fa-user"></i> -->
                       <div class="bubble1">
                            <div class="message"><?= explode("//", $message->libelle)[1] ?></div>
                            <?php if($message->p==1){ ?>
                                <div><img src="<?= base_url("upload/".$message->piecejointe) ?>" alt=<?= $message->piecejointe ?>></div>
                            <?php } ?>
                        </div>
                        <div id="date"><?= $message->dateenvoie ?></div>
                    </div>
                    <?php }
                    } ?>
                <!-- Ajoutez plus de messages ici -->
                <!-- </div> -->
                </div>
                </div>
            </div>
        </div>
