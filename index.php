<?php include'layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descubra seu Signo</title>
</head>
<body class="container">
    <h1 class="text-center my-4">Descubra seu Signo Zodiacal</h1>
    <form id="signo-form" method="POST" action="show_zodiac_sign.php" class="p-4 border rounded">
        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
        </div>
        <button type="submit" class="btn btn-primary">Descobrir</button>
    </form>
</body>
</html>
