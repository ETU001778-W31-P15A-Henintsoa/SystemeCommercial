<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de commande</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

.card {
    /* margin-bottom: 20px; */
    border: 2px solid #3498db;
    border-radius: 8px;
    padding: 15px;
    background-color: #fff;
}

.card-center {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    border: 1px solid #3498db;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #3498db;
    color: #fff;
}

.card-footer {
    border-top: 2px solid #3498db;
    padding-top: 15px;
}

/* Ajoutez ici votre style CSS personnalisé pour le PDF */


    </style>
</head>
<body>

<div class="card">
    <center>
        <h3>Bon de commande : <?= $donnee[0]['idbondecommande']?></h3>
        <h3>Date<?= $donnee[0]['datebondecommande'] ?></h3>
    </center>


<div class="card mb-4">
    <div class="card-body">
        <p><strong>Fournisseur : </strong><?= $donnee[0]['nomfournisseur'] ?></p>
        <p><strong>Délai de livraison :</strong><?= $donnee[0]['delailivraison'] ?></p>
        <p><strong>Livraison partielle :</strong><?= $donnee[0]['livraison'] ?></p>
        <p><strong>Mode de paiement :</strong><?= $donnee[0]['paiement'] ?></p>
    </div>
</div>

<div class="card">
    <div class="card-body">
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
    </div>
</div>
            </div>
<div class="card mb-4">
    <div class="card-body">
        <p>Arrêter le présent commande à la somme de <?= $lettre ?> Ariary</p>
    </div>
</div>

</body>
</html>
