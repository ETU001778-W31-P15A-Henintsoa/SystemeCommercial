<?php
    // var_dump($anormal); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Reception</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em;
        }

        section {
            margin: 20px;
        }

        .order-summary {
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        .total {
            margin-top: 20px;
            text-align: right;
        }

        .signatures {
            margin-top: 30px;
            text-align: center;
        }

        .signature-box {
            display: inline-block;
            border: 1px solid #ddd;
            padding: 10px;
            margin: 0 20px;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bon de Reception</h1>
    </header>

    <section>
        <div class="order-summary">
            <h2>Récapitulatif de la reception </h2>

            <!-- Informations sur la commande -->
            <p><strong>Date de reception:</strong> <?= $reception[0]->datereception ?></p>
            <p><strong>Envoyeur : </strong> DIMPEX </p>
            <p><strong>Destinataire : </strong> <?= $fournisseur->nomfournisseur ?> </p>
            <p><strong>Identifiant Bon de Commande : </strong> <?= $reception[0]->idbondecommande ?> </p>

            <table>
                <thead>
                    <tr>
                        <th>Designation</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($reception as $r){ 
                        if($r->quantite != 0){?>
                        <tr>
                            <td><?= $r->nomarticle ?></td>
                            <td><?= $r->quantite?></td>
                        </tr>   
                    <?php }
                    } ?>
                </tbody>
            </table>
                <h5 style="text-decoration: underline;">Non equivalence dans la reception</h5>
            <table>
                <thead>
                    <tr>
                        <th>Designation</th>
                        <th>Quantité Commande</th>
                        <th>Quantité Recus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($anormal as $a){  ?>
                        <tr>
                            <td><?= $a['article'] ?></td>
                            <td style="color: green;"><?= $a['quantiteDemande']?></td>
                            <td style="color: red;"><?= $a['quantiteRecu']?></td>
                        </tr>   
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </section>

    <!-- <footer>
        <p>Merci de votre commande !</p>
    </footer> -->
</body>
</html>
