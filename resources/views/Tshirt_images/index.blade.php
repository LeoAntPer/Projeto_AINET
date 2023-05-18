<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0,
 maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catálogo</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Imagem</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tshirt_images as $image)
        <tr>
            <td>{{ $image->name }}</td>
            <td>{{ $image->description }}</td>
            <td><img src="{{ $image->image_url }}" alt="Imagem"></td>

        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
<!--</head>
<body>
@dump($tshirt_images)
</body>
</html>
