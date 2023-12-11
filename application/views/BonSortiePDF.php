<?php
    // var_dump($articles[0]['detail']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Sortie</title>
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
        <h1>Bon de Sortie</h1>
    </header>

    <section>
        <div class="order-summary">
            <h2>Récapitulatif de la sortie </h2>

            <!-- Informations sur la commande -->
            <p><strong>Date de sortie:</strong> <?= $articles[0]['sorti']->datesortie ?></p>
            <!--  <p><strong>Envoyeur : </strong> Magasine </p> -->
            <p><strong>Destinataire : </strong> <?= $articles[0]['sorti']->nomdepartement ?> </p>
            <p><strong>Numero Bon de Sortie : </strong> <?= $articles[0]['sorti']->idbonsortie ?> </p>
            <!-- <p><strong>Identifiant : </strong> <?php //$articles[0]['sorti']->idbonreception ?> </p> -->

            <table>
                <thead>
                    <tr>
                        <th>Designation</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($articles as $a){ 
                        foreach($a['detail'] as $ad){?>
                        <tr>
                            <td><?= $ad->nomarticle ?></td>
                            <td><?= $ad->quantite?></td>
                        </tr>   
                    <?php }
                    } ?>
                </tbody>
            </table>

            <br>
            <!-- <br>
                <h5 style="text-decoration: underline;">Non equivalence dans la articles</h5>
            <br>
                <table> -->
                <!-- <thead>
                    <tr>
                        <th>Designation</th>
                        <th>Quantité Commande</th>
                        <th>Quantité Recus</th>
                    </tr>
                </thead> -->
                <!-- <tbody>
                    <?php //foreach($anormal as $a){  ?>
                        <tr>
                            <td><?php //$a['article'] ?></td>
                            <td style="color: green;"><?php //$a['quantiteDemande']?></td>
                            <td style="color: red;"><?php //$a['quantiteRecu']?></td>
                        </tr>   
                    <?php //} ?>
                </tbody> -->
            <!-- </table> -->
        </div>

    <!-- </section> -->

    <!-- <footer>
        <p>Merci de votre commande !</p>
    </footer> -->
</body>
</html>
