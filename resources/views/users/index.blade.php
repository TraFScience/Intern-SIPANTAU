<!DOCTYPE html>
<html>
<head>
    <title>ASSALAMUALIKUM</title>
</head>
<body>

    <h1>ADAKAH 100?
    </h1>

    @foreach ($users as $user)
        <p>
            {{ $user->name }} -
            {{ $user->email }} -
            {{ $user->role }}
        </p>
    @endforeach

</body>
</html>