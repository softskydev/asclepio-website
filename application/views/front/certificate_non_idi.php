
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }

        .position-relative{
            position: relative;
        }
        .name{
            position: absolute;
            left: 0;
            right: 0;
            text-align: center;
            top: 53%;
            font-size: 40px;
        }
    </style>
</head>

<div class="position-relative">
    <img src="<?= $img_certificate ?>" width="100%" alt="">
    <div class="name">
        <h2><?= $nama_peserta ?></h2>
    </div>
</div>
