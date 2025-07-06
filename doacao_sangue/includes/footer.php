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
        value = value.replace(/\D/g, '');
        if (value.length > 5) {
            value = value.slice(0, 5) + '-' + value.slice(5, 8);
        }
        return value.slice(0, 9);
    }

    function maskCPF(value) {
        value = value.replace(/\D/g, '');
        if (value.length > 3 && value.length <= 6) {
            value = value.slice(0, 3) + '.' + value.slice(3);
        } else if (value.length > 6 && value.length <= 9) {
            value = value.slice(0, 3) + '.' + value.slice(3, 6) + '.' + value.slice(6);
        } else if (value.length > 9) {
            value = value.slice(0, 3) + '.' + value.slice(3, 6) + '.' + value.slice(6, 9) + '-' + value.slice(9, 11);
        }
        return value.slice(0, 14);
    }

    if (cepInput && cepInput.value) {
        cepInput.value = maskCEP(cepInput.value);
    }
    if (cpfInput && cpfInput.value) {
        cpfInput.value = maskCPF(cpfInput.value);
    }

    if (cepInput) {
        cepInput.addEventListener('input', function () {
            const cursor = this.selectionStart;
            this.value = maskCEP(this.value);
            this.setSelectionRange(cursor, cursor);
        });
    }

    if (cpfInput) {
        cpfInput.addEventListener('input', function () {
            const cursor = this.selectionStart;
            this.value = maskCPF(this.value);
            this.setSelectionRange(cursor, cursor);
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
</script>


</body>
</html>