<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificate {{ Auth::user()->name }}</title>
    <link rel="stylesheet" type="text/css" href="{{ public_path() }}/pdf/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ public_path()  }}/pdf/pdf.css">
    <style>
        @font-face {
            font-family: 'Red Hat Display';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path() . '/fonts/RedHatDisplay-Regular.ttf' }}');
        }

        @font-face {
            font-family: 'Red Hat Display Medium';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path() . '/fonts/RedHatDisplay-Medium.ttf' }}');
        }

        @font-face {
            font-family: 'Red Hat Display Bold';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path() . '/fonts/RedHatDisplay-Bold.ttf' }}');
        }

        @font-face {
            font-family: 'Monotype';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path() . '/fonts/Monotype Corsiva.ttf' }}');
        }


        body {
            font-family: 'Red Hat Display', sans-serif;
        }

        @page {
            margin: 0px;
        }

        .red-hat-med {
            font-family: 'Red Hat Display Medium' !important;
        }

        .red-hat-bold {
            font-family: 'Red Hat Display Bold' !important;
        }

        .monotype {
            font-family: 'Monotype' !important;
        }

        .bg-certificate {
            padding-left: 95px !important;
            margin-top: -810px;
        }

        .text-title {
            color: #D7AE6A !important;
            letter-spacing: 14px;
            font-size: 56px;
            font-weight: bolder;
            margin-bottom: 0px !important;
            -webkit-background-clip: text;
            background-image: linear-gradient(to right, #1de9b6, #2979ff);
            -webkit-text-fill-color: transparent;
            -moz-background-clip: text;
            -moz-text-fill-color: transparent;
            font-family: 'Red Hat Display Medium', sans-serif !important;
        }

        .subtitle {
            font-size: 28px;
            margin-top: 0px !important;
            color: #60554f;
            margin-bottom: 10px !important;
        }

        .mt-2 {
            margin-top: 2rem;
        }

        .name {
            font-size: 35px !important;
            margin-top: {{ $name_top }}px !important;
        }

        .as {
            margin-top: {{ $as_top }}px !important;
            font-size: 28px !important;
        }

    </style>
</head>

<body>
    <div>
        <img src="{{ storage_path() . '/app/public/' . $image }}" alt="" srcset=""
            style="width: 297mm; height:210mm; {{ request()->get('print') ? 'visibility: hidden' : '' }}">
        <div class="bg-certificate" style="padding: 38px">
            <p class="name monotype">{{ $user->name }}</p>
            <p class="as monotype">Participant</p>
        </div>
    </div>
</body>

</html>
