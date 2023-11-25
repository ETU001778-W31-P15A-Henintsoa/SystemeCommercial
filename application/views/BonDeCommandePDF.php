<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de commande</title>
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
        <h1>Bon de commande</h1>
    </header>

    <section>
        <div class="order-summary">
            <h2>Récapitulatif de la commande</h2>

            <!-- Informations sur la commande -->
            <p><strong>Date de la commande:</strong> <?= $donnee[0]['datebondecommande'] ?></p>
            <p><strong>Fournisseur : </strong><?= $donnee[0]['nomfournisseur'] ?></p>
            <p><strong>Délai de livraison :</strong><?= $donnee[0]['delailivraison'] ?></p>
            <p><strong>Livraison partielle :</strong><?= $donnee[0]['livraison'] ?></p>
            <p><strong>Mode de paiement :</strong><?= $donnee[0]['paiement'] ?></p>

            <table>
                <thead>
                    <tr>
                        <th>Designation</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total TTC</th>
                        <th>HT</th>
                        <th>TVA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sommeht = 0;
                    $sommetva = 0;
                    foreach ($donnee as $donnees) {
                        $ttc = $donnees['ttc'];
                        $ht = $ttc / (1 + (20 / 100));
                        $tva = $ht * (20 / 100);
    
                        echo '<tr>
                            <td>' . $donnees['idarticle'] . '</td>
                            <td>' . $donnees['quantite'] . '</td>
                            <td>' . $donnees['pu'] . '</td>
                            <td>' . $ttc . '</td>
                            <td>' . $ht . '</td>
                            <td>' . $tva . '</td>
                        </tr>';
    
                        $sommeht += $ht;
                        $sommetva += $tva;
                    }
                    ?>
                    <tr>
                        <td></td><td></td><td></td>
                        <td><?= $sommeTTC ?></td>
                        <td><?= $sommeht ?></td>
                        <td><?= $sommetva ?></td>
                    </tr>
                    
                </tbody>
            </table>

            <div class="total">
                <p>Arrêter le présent commande à la somme de <?= $lettre ?> Ariary</p>
            </div>
        </div>

    </section>

    <!-- <footer>
        <p>Merci de votre commande !</p>
    </footer> -->
</body>
</html>
