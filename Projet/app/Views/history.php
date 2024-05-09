<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIT | History</title>
    <style>
        body {
            background-color: #f1f1f1;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100vh;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #FF3131; /* Couleur bleue */
            color: white; /* Texte en blanc */
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <thead> 
                <th>id</th>
                <th>action</th>
                <th>table_name</th>
                <th>date</th>
            </thead>
            <tbody>
                <?php foreach($history as $tracker) :?>
                    <tr>
                        <td>$tracker['id']</td>
                        <td>$tracker['action']</td>
                        <td>$tracker['table_name']</td>
                        <td>$tracker['date']</td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </tr>
    </table>
</body>
</html>