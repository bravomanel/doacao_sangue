</main> 
<footer class="bg-light text-center text-lg-start mt-5">
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2025 - CSS – Clínica de Sangue Solidária
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cepInput = document.getElementById('cep');
        const cpfInput = document.getElementById('cpf');
        const form = document.querySelector('form');

        function maskCEP(value) {
            const numbers = value.replace(/\D/g, '').slice(0, 8);
            if (numbers.length > 5) {
                return numbers.slice(0, 5) + '-' + numbers.slice(5);
            }
            return numbers;
        }

        function maskCPF(value) {
            const numbers = value.replace(/\D/g, '').slice(0, 11);
            let masked = '';
            if (numbers.length > 0) masked = numbers.slice(0, 3);
            if (numbers.length >= 4) masked += '.' + numbers.slice(3, 6);
            if (numbers.length >= 7) masked += '.' + numbers.slice(6, 9);
            if (numbers.length >= 10) masked += '-' + numbers.slice(9, 11);
            return masked;
        }

        function setCursorToEnd(el) {
            const len = el.value.length;
            setTimeout(() => el.setSelectionRange(len, len), 0);
        }

        if (cepInput) {
            cepInput.value = maskCEP(cepInput.value);
            cepInput.addEventListener('input', function () {
                const originalPosition = this.selectionStart;
                const beforeLength = this.value.length;
                this.value = maskCEP(this.value);
                const afterLength = this.value.length;
                const diff = afterLength - beforeLength;
                this.setSelectionRange(originalPosition + diff, originalPosition + diff);
            });
        }

        if (cpfInput) {
            cpfInput.value = maskCPF(cpfInput.value);
            cpfInput.addEventListener('input', function () {
                const originalPosition = this.selectionStart;
                const beforeLength = this.value.length;
                this.value = maskCPF(this.value);
                const afterLength = this.value.length;
                const diff = afterLength - beforeLength;
                this.setSelectionRange(originalPosition + diff, originalPosition + diff);
            });
        }

        if (form) {
            form.addEventListener('submit', function () {
                if (cepInput) {
                    cepInput.value = cepInput.value.replace(/\D/g, '');
                }
                if (cpfInput) {
                    cpfInput.value = cpfInput.value.replace(/\D/g, '');
                }
            });
        }
    });

    // Atualizar triagem automaticamente ao selecionar doador
    document.getElementById('doador_id')?.addEventListener('change', function () {
        const doadorId = this.value;
        if (!doadorId) return;

        fetch('backend/pega_triagem_doador.php?doador_id=' + doadorId)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert(data.erro);
                } else {
                    document.getElementById('peso_sim').checked = data.pesa_mais_50kg == '1';
                    document.getElementById('peso_nao').checked = data.pesa_mais_50kg == '0';

                    document.getElementById('febre_sim').checked = data.teve_febre_7dias == '1';
                    document.getElementById('febre_nao').checked = data.teve_febre_7dias == '0';

                    document.getElementById('tatuagem_sim').checked = data.fez_tatuagem_12meses == '1';
                    document.getElementById('tatuagem_nao').checked = data.fez_tatuagem_12meses == '0';
                }
            })
            .catch(() => alert('Erro ao buscar dados do doador.'));
    });

    // Bloquear envio do formulário se triagem estiver inapta
    document.querySelector('form').addEventListener('submit', function (e) {
        const pesaMais50kg = document.querySelector('input[name="pesa_mais_50kg"]:checked')?.value;
        const teveFebre7dias = document.querySelector('input[name="teve_febre_7dias"]:checked')?.value;
        const fezTatuagem12meses = document.querySelector('input[name="fez_tatuagem_12meses"]:checked')?.value;

        let mensagem = '';

        if (pesaMais50kg === '0') mensagem += "- Doador pesa menos de 50kg\n";
        if (teveFebre7dias === '1') mensagem += "- Doador teve febre nos últimos 7 dias\n";
        if (fezTatuagem12meses === '1') mensagem += "- Doador fez tatuagem/piercing nos últimos 12 meses\n";

        if (mensagem !== '') {
            e.preventDefault();
            alert("A doação não pode ser registrada devido aos seguintes motivos:\n\n" + mensagem);
        }
    });
</script>

</body>
</html>