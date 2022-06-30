<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass * {
            line-height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        p {
            display: block;
            margin: 13px 0;
        }
    </style>
    <style type="text/css">
        @media only screen and (max-width:480px) {
            @-ms-viewport {
                width: 320px;
            }

            @viewport {
                width: 320px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
    </style>
    <style type="text/css">
        @media only screen and (min-width:480px) {

            .mj-column-per-100,
            * [aria-labelledby="mj-column-per-100"] {
                width: 100% !important;
            }
        }
    </style>
</head>

<body style="background: #F9F9F9;">
    <div style="background-color:#F9F9F9;">
        <style type="text/css">
            html,
            body,
            * {
                -webkit-text-size-adjust: none;
                text-size-adjust: none;
            }

            a {
                color: #1EB0F4;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }

            table {
                border-collapse: collapse;
            }
        </style>
        <div style="max-width:640px;margin:100px auto ;box-shadow:0px 1px 5px rgba(0,0,0,0.1);border-radius:4px;overflow:hidden">
            <div style="margin:0px auto;max-width:640px;background:#ffffff;">
                <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#ffffff;" align="center" border="0">
                    <tbody>
                        <tr>
                            <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 70px;">
                                <div aria-labelledby="mj-column-per-100" class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;">
                                    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                        <tbody>
                                            <tr>
                                                <td style="word-break:break-word;font-size:0px;padding:0px 0px 20px;" align="left">
                                                    <div style="cursor:auto;color:#737F8D;font-family:Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;font-size:16px;line-height:24px;text-align:left;">
                                                        <p>
                                                            <center><img src="<?= base_url() ?>assets/front/images/logo-ascelpio.png" alt="Logo" title="None" width="200" style="height: auto;"></center>
                                                        </p>
                                                        <br><br>
                                                        <h2 style="font-family: Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;font-weight: 500;font-size: 20px;color: #4F545C;letter-spacing: 0.27px;">Hey <?= $fullname ?>,</h2>
                                                        
                                                        <p>No.Invoice <br>
                                                        <h3><b><?= $order_id ?> </b></h3>
                                                        </p>
                                                        </p>Harap lakukan pembayaran dengan total <br>
                                                        <h3>
                                                            <b>Rp <?= rupiah($transaksi->total) ?></b>
                                                        </h3>
                                                        <p>

                                                        <table style="width: 100%;" border="1" cellpadding="5" cellspacing="5">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Kelas</th>
                                                                    <th>Tgl Kelas</th>
                                                                    <th>Harga</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $no = 1;
                                                                foreach ($detail as $d) { ?>
                                                                    <tr>
                                                                        <td><?= $no++ ?></td>
                                                                        <td><?= $d->name ?></td>
                                                                        <td>Rp <?= rupiah($d->total_harga) ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table> <br>
                                                        <a href="<?= base_url() ?>payment/<?= $order_id ?>" style="text-decoration:none;line-height:100%;color:white;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;font-weight:normal;text-transform:none;margin:0px;padding:5px; background:#75B248" target="_blank">
                                                            Bayar Tagihan
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin:0px auto;max-width:640px;background:transparent;">
            <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:transparent;" align="center" border="0">
                <tbody>
                    <tr>
                        <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:0px;">
                            <div aria-labelledby="mj-column-per-100" class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;">
                                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tbody>
                                        <tr>
                                            <td style="word-break:break-word;font-size:0px;">
                                                <div style="font-size:1px;line-height:12px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>