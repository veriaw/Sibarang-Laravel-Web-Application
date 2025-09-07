<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan Peminjaman Barang Inventaris</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .text-center { text-align: center; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
    </style>
</head>
<body>
    <h3 class="text-center">
        SURAT PERNYATAAN PEMINJAMAN BARANG INVENTARIS
    </h3>

    <p class="mt-4">Saya yang bertanda tangan di bawah ini:</p>

    <p>Nama Peminjam : {{ $nama_peminjam ?? '.....................................................' }}</p>

    <p class="mt-4">Dengan ini menyatakan bahwa saya telah meminjam barang inventaris sebagai berikut:</p>

    <p>Nama Barang : {{ $nama_barang ?? '.....................................................' }}</p>
    <p>Jumlah Barang : {{ $jumlah_barang ?? '.....................................................' }}</p>
    <p>Lama Pinjam : {{ $lama_pinjam ?? '............' }} hari, mulai dari tanggal {{ $tanggal_pinjam ?? '.......' }}</p>

    <p class="mt-4">
        Saya berjanji akan menjaga barang tersebut dengan baik serta mengembalikannya dalam kondisi 
        semula sesuai dengan batas waktu yang telah ditentukan. Apabila terjadi kerusakan atau kehilangan, 
        saya bersedia mengganti sesuai dengan ketentuan yang berlaku.
    </p>

    <p class="mt-4">
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya untuk digunakan sebagaimana mestinya.
    </p>

    <p class="mt-6">{{ 'Yogyakarta' }}, {{ $tanggal_surat ?? '.............. 20....' }}</p>

    <p class="mt-6">Yang membuat pernyataan,</p>

    <br>

    <p>(tanda tangan & nama jelas)</p>
    <p>{{ $nama_peminjam ?? '....................................................' }}</p>
</body>
</html>