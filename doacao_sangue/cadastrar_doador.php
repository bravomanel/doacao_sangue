<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3 class="mb-0">Formulário de Cadastro de Doador</h3>
            </div>
            <div class="card-body">
                <p class="card-text">Preencha os campos abaixo para se juntar à nossa causa. Todos os campos são obrigatórios.</p>
                
                <form action="backend/processa_cadastro.php" method="POST">
                    <h5 class="mt-4">Informações Pessoais</h5>
                    <hr>
                    <div class="mb-3">
                        <label for="nome_completo" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome_completo" name="nome_completo" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                             <label for="cep" class="form-label">CEP</label>
                             <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipo_sanguineo" class="form-label">Tipo Sanguíneo</label>
                            <select class="form-select" id="tipo_sanguineo" name="tipo_sanguineo" required>
                                <option value="" selected disabled>Selecione...</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div>
                     <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@exemplo.com" required>
                    </div>

                    <h5 class="mt-4">Questionário de Triagem</h5>
                    <hr>
                    <fieldset class="mb-3">
                        <legend class="form-label fs-6">1. Você pesa mais de 50kg?</legend>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pesa_mais_50kg" id="peso_sim" value="1" required>
                            <label class="form-check-label" for="peso_sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pesa_mais_50kg" id="peso_nao" value="0">
                            <label class="form-check-label" for="peso_nao">Não</label>
                        </div>
                    </fieldset>

                     <fieldset class="mb-3">
                        <legend class="form-label fs-6">2. Teve febre nos últimos 7 dias?</legend>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="teve_febre_7dias" id="febre_sim" value="1" required>
                            <label class="form-check-label" for="febre_sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="teve_febre_7dias" id="febre_nao" value="0">
                            <label class="form-check-label" for="febre_nao">Não</label>
                        </div>
                    </fieldset>

                     <fieldset class="mb-3">
                        <legend class="form-label fs-6">3. Fez tatuagem ou piercing nos últimos 12 meses?</legend>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="fez_tatuagem_12meses" id="tatuagem_sim" value="1" required>
                            <label class="form-check-label" for="tatuagem_sim">Sim</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="fez_tatuagem_12meses" id="tatuagem_nao" value="0">
                            <label class="form-check-label" for="tatuagem_nao">Não</label>
                        </div>
                    </fieldset>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger btn-lg">Finalizar Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>