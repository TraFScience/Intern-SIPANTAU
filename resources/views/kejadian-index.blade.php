<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Bencana - SIPANTAU</title>
</head>
<body>

    <h2>Daftar Kejadian Bencana</h2>

    <a href="{{ route('kejadian-bencana.create') }}">+ Buat Laporan Baru</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8" cellspacing="0" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Judul</th>
                <th>Jenis</th>
                <th>Wilayah</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($kejadian as $item)
                <tr>
                    <td>
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" width="80">
                        @else
                            Tidak Ada Foto
                        @endif
                    </td>

                    <td>{{ $item->judul }}</td>

                    <td>
                        {{ $item->jenisBencana->nama_jenis ?? '-' }}
                    </td>

                    <td>
                        {{ $item->wilayah->nama_wilayah ?? '-' }}
                    </td>

                    <td>{{ $item->tanggal_kejadian }}</td>

                    <td>{{ $item->status_verifikasi }}</td>

                    <td>
                        @if($item->status_verifikasi === 'menunggu')
                            <form action="{{ route('kejadian-bencana.verifikasi', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <button type="submit">
                                    Verifikasi
                                </button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7">Belum ada data laporan bencana.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>