
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cupom de Desconto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Criar Cupom de Desconto</h2>
        <form action="processar_formulario.php" method="POST">
            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo">
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome">
            </div>
            <div class="mb-3">
                <label for="codigo_cupom" class="form-label">Código do Cupom</label>
                <input type="text" class="form-control" id="codigo_cupom" name="codigo_cupom">
            </div>
            <div class="mb-3">
                <label for="nome_cupom" class="form-label">Nome do Cupom</label>
                <input type="text" class="form-control" id="nome_cupom" name="nome_cupom">
            </div>
            <div class="mb-3">
                <label for="max_usos" class="form-label">Máximo de Usos</label>
                <input type="number" class="form-control" id="max_usos" name="max_usos">
            </div>
            <div class="mb-3">
                <label for="max_usos_usuario" class="form-label">Máximo de Usos por Usuário</label>
                <input type="number" class="form-control" id="max_usos_usuario" name="max_usos_usuario">
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" name="tipo">
                    <option value="percent">Percentual</option>
                    <option value="fixed">Fixo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="valor_desconto" class="form-label">Valor do Desconto</label>
                <input type="number" step="0.01" class="form-control" id="valor_desconto" name="valor_desconto">
            </div>
            <div class="mb-3">
                <label for="valor_minimo" class="form-label">Valor Mínimo</label>
                <input type="number" step="0.01" class="form-control" id="valor_minimo" name="valor_minimo">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="data_inicio" class="form-label">Data de Início</label>
                <input type="datetime-local" class="form-control" id="data_inicio" name="data_inicio">
            </div>
            <div class="mb-3">
                <label for="data_fim" class="form-label">Data de Fim</label>
                <input type="datetime-local" class="form-control" id="data_fim" name="data_fim">
            </div>
            <button type="submit" class="btn btn-primary">Criar Cupom</button>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
