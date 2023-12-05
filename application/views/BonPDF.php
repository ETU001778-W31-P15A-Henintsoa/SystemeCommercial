<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de <?= $nombon ?> </title>
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
        <h1>Bon de <?= $nombon ?></h1>
    </header>

    <section>
        <div class="order-summary">
            <h2>Récapitulatif de la <?= $action ?> </h2>

            <!-- Informations sur la commande -->
            <p><strong>Date de la commande:</strong> <?= $date ?></p>
            <p><strong>Envoyeur : </strong><?= $nom ?></p>

            <table>
                <thead>
                    <tr>
                        <th>Designation</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>

    </section>

    <!-- <footer>
        <p>Merci de votre commande !</p>
    </footer> -->
</body>
</html>
