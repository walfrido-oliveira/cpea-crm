<script>
    document.querySelector("#cep").addEventListener("change", function() {
        const dataForm = new FormData();
        dataForm.append("cep", this.value);
        dataForm.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        dataForm.append('_method', 'POST');

        fetch("{{ route('customers.address.cep', ['cep' => '#']) }}".replace("#", this.value), {
            method: 'POST',
            body: dataForm
        })
        .then(res => res.text())
        .then(data => {
        const response = JSON.parse(data);

        if(response.resultado != "2")  document.querySelector("#district").value = response.bairro;
        document.querySelector("#city").value = response.cidade;
        if(response.resultado != "2") document.querySelector("#address").value = `${response.tipo_logradouro} ${response.logradouro}`;
        document.querySelector("#state").value = response.uf;
        window.customSelectArray['state'].update()

        }).catch(err => {
            console.log(err);
        });
    });

    document.querySelector("#cnpj").addEventListener("change", function() {
        const dataForm = new FormData();
        dataForm.append("cnpj", this.value);
        dataForm.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        dataForm.append('_method', 'POST');

        fetch("{{ route('customers.cnpj', ['cnpj' => '#']) }}".replace("#", this.value.replaceAll('/', '').replaceAll('.', '').replaceAll("-", "")), {
            method: 'POST',
            body: dataForm
        })
        .then(res => res.text())
        .then(data => {
        const response = JSON.parse(data);

        document.querySelector("#corporate_name").value = response.nome;
        document.querySelector("#cep").value = formatCEP(response.cep);
        document.querySelector("#address").value = response.logradouro;
        document.querySelector("#number").value = response.numero;
        document.querySelector("#district").value = response.bairro;
        document.querySelector("#city").value = response.municipio;
        document.querySelector("#state").value = response.uf;
        window.customSelectArray['state'].update()

        }).catch(err => {
            console.log(err);
        });
    });

    document.querySelector("#cnpj").addEventListener("keyup", function() {
        this.value = formatCNPJ(this.value);
    });

    document.querySelector("#cep").addEventListener("keyup", function() {
        this.value = formatCEP(this.value);
    });

    function formatCEP(value) {
        return value.replace(/\D/g, '').replace(/^(\d{5})(\d{3})?/, "$1-$2");
    }

    function formatCNPJ(value) {
        return value.replace(/\D/g, '').replace(/^(\d{2})(\d{3})?(\d{3})?(\d{4})?(\d{2})?/, "$1.$2.$3/$4-$5");
    }

</script>
