<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>

    <h1>Edit User</h1>

    @if ($errors->any())
        <div>
            <strong>Terjadi kesalahan:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama</label><br>
        <input type="text" name="name" value="{{ $user->name }}">
        <br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ $user->email }}">
        <br><br>

        <label>Password Baru</label><br>
        <input type="password" name="password">
        <br>
        <small>Kosongkan jika password tidak ingin diubah.</small>

        <br><br>

        <label>Role</label><br>

        <select name="role">
            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                User
            </option>

            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                Admin
            </option>
        </select>

        <br><br>

        <button type="submit">Simpan Perubahan</button>

        <a href="{{ route('user.index') }}">
            Kembali
        </a>
    </form>

</body>
</html>