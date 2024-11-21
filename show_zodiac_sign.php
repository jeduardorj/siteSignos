<?php include 'layouts/header.php'; ?>

<?php
// Captura a data de nascimento enviada pelo formulário
$data_nascimento = $_POST['data_nascimento'] ?? null;

// Define o caminho absoluto para o arquivo signos.xml
$arquivoSignos = __DIR__ . '/signos.xml';

// Verifica se o arquivo XML existe antes de tentar carregá-lo
if (!file_exists($arquivoSignos)) {
    die("<div class='alert alert-danger'>Erro: O arquivo signos.xml não foi encontrado no caminho: $arquivoSignos</div>");
}

// Tenta carregar o arquivo XML
$signos = simplexml_load_file($arquivoSignos);
if ($signos === false) {
    die("<div class='alert alert-danger'>Erro: Não foi possível carregar o arquivo signos.xml.</div>");
}

// Função para verificar o signo com base na data de nascimento
function verificarSigno($data_nascimento, $signos) {
    // Extrai dia e mês da data de nascimento
    $diaNascimento = (int) date('d', strtotime($data_nascimento));
    $mesNascimento = (int) date('m', strtotime($data_nascimento));

    foreach ($signos->signo as $signo) {
        // Extrai dia e mês das datas de início e fim do signo
        $diaInicio = (int) substr($signo->dataInicio, 0, 2);
        $mesInicio = (int) substr($signo->dataInicio, 3, 2);
        $diaFim = (int) substr($signo->dataFim, 0, 2);
        $mesFim = (int) substr($signo->dataFim, 3, 2);

        // Verifica se a data de nascimento está dentro do intervalo do signo
        if (
            ($mesNascimento == $mesInicio && $diaNascimento >= $diaInicio) || // Dentro do mês de início
            ($mesNascimento == $mesFim && $diaNascimento <= $diaFim) ||       // Dentro do mês de fim
            ($mesNascimento > $mesInicio && $mesNascimento < $mesFim) ||      // Entre os meses de início e fim
            ($mesInicio > $mesFim && ($mesNascimento > $mesInicio || $mesNascimento < $mesFim)) // Signos que atravessam o ano novo
        ) {
            return $signo;
        }
    }
    return null;
}

// Verifica o signo baseado na data de nascimento
$signoEncontrado = $data_nascimento ? verificarSigno($data_nascimento, $signos) : null;
?>

<body class="container">
    <h1 class="text-center my-4">Resultado</h1>
    <?php if ($signoEncontrado): ?>
        <div class="alert alert-info">
            <h2><?php echo htmlspecialchars($signoEncontrado->signoNome); ?></h2>
            <p><?php echo htmlspecialchars($signoEncontrado->descricao); ?></p>
        </div>
    <?php elseif ($data_nascimento): ?>
        <div class="alert alert-danger">Signo não encontrado.</div>
    <?php else: ?>
        <div class="alert alert-warning">Nenhuma data de nascimento foi fornecida.</div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-secondary">Voltar</a>
</body>
