<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporkan Bencana - SIPANTAU</title>
</head>
<body>
    <h2>Form Laporan Kejadian Bencana</h2>

    <form action="{{ route('kejadian-bencana.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <p>
            <label>Judul Kejadian:</label><br>
            <input type="text" name="judul" required>
        </p>

        <p>
            <label>Jenis Bencana:</label><br>
            <select name="jenis_bencana_id" required>
                <option value="">-- Pilih Jenis Bencana --</option>
                @foreach($jenisBencana as $jenis)
                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Lokasi Wilayah:</label><br>
            <select name="wilayah_id" required>
                <option value="">-- Pilih Wilayah --</option>
                @foreach($wilayah as $w)
                    <option value="{{ $w->id }}">{{ $w->nama_wilayah }}</option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Tanggal Kejadian:</label><br>
            <input type="date" name="tanggal_kejadian" required>
        </p>

        <p>
            <label>Deskripsi Kejadian:</label><br>
            <textarea name="deskripsi" rows="4" required></textarea>
        </p>

        <p>
            <label>Foto Kejadian:</label><br>
            <input type="file" name="gambar" accept="image/*">
        </p>

        <button type="submit">Kirim Laporan</button>
    </form>
</body>
</html>