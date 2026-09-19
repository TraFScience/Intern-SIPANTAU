<!DOCTYPE html>
<html>
<head>
    <title>Kelola User</title>
</head>
<body>

    <h1>Kelola User</h1>

    <a href="{{ route('user.create') }}">+ Tambah User</a>

    <br><br>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <<td>
                <a href="{{ route('user.edit', $user->id) }}">
                    Edit
                </a>

                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')

                <button type="submit" onclick="return confirm('Yakin ingin menghapus user ini?')">
                Hapus
                </button>
                </form>
                </td>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada data user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>