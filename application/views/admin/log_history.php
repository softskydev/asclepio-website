<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table tr td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <h1>Log History Link Zoom "<?= $judul_kelas ?>"</h1>
    <table border="1">
        <thead>
            <tr>
                <td>Log</td>
                <td>date</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($log as $l) { ?>
                <tr>
                    <td><?= $l->link_zoom ?></td>
                    <td><?= $l->updated_at ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>

</html>