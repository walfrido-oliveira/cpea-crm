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

        if(response.resultado != "0") {
            if(response.resultado != "2")  document.querySelector("#district").value = response.bairro;
            document.querySelector("#city").value = response.cidade;
            if(response.resultado != "2") document.querySelector("#address").value = `${response.tipo_logradouro} ${response.logradouro}`;
            document.querySelector("#state").value = response.uf;
            window.customSelectArray['state'].update();
        }

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

    function toggleContactModal(show = false) {
        const modal = document.querySelector("#contact_modal");
        if(show) modal.classList.remove("hidden");
        if(!show) modal.classList.add("hidden");
    }

    function toggleDeleteContactModal(show = false) {
        const modal = document.querySelector("#delete_contact_modal");
        if(show) modal.classList.remove("hidden");
        if(!show) modal.classList.add("hidden");
    }

    function deleteModalHandle() {
        document.querySelectorAll(".delete-contact").forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                toggleDeleteContactModal(true);

                const modal = document.querySelector("#delete_contact_modal");
                modal.dataset.id = item.dataset.id;
                modal.dataset.row = item.parentElement.parentElement.rowIndex;
            });
        });
    }

    deleteModalHandle();

    function editModalHandle() {
        document.querySelectorAll(".edit-contact").forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                toggleContactModal(true);
                const modal = document.querySelector("#contact_modal");
                const id = item.dataset.id;
                const row = item.parentElement.parentElement.rowIndex;

                modal.dataset.id = id;
                modal.dataset.row = row;

                document.querySelector("#contact_modal #general_contact_type_id").value = document.querySelector(`.general-contact-type-id[data-id='${id}']`).value;
                window.customSelectArray['general_contact_type_id'].update()
                document.querySelector("#contact_modal #description").value = document.querySelector(`.contact-description[data-id='${id}']`).value;
                document.querySelector("#contact_modal #obs").value = document.querySelector(`.contact-obs[data-id='${id}']`).value;
            });
        });
    }

    editModalHandle();

    document.querySelector("#delect_contact_modal_cancel").addEventListener("click", function() {
        toggleDeleteContactModal(false);
    });

    document.querySelector(".add-contact").addEventListener("click", function() {
        toggleContactModal(true);

        document.querySelector("#contact_modal").dataset.id = 0;
        document.querySelector("#contact_modal #general_contact_type_id").value = "";
        window.customSelectArray['general_contact_type_id'].update()
        document.querySelector("#contact_modal #description").value = "";
        document.querySelector("#contact_modal #obs").value = "";
    });

    document.querySelector("#cancel_contact_modal").addEventListener("click", function() {
        toggleContactModal(false);
    });

    function addContact() {
        const dataForm = new FormData();
        dataForm.append("general_contact_type_id", document.querySelector("#contact_modal #general_contact_type_id").value);
        dataForm.append("description", document.querySelector("#contact_modal #description").value);
        dataForm.append("obs", document.querySelector("#contact_modal #obs").value);
        dataForm.append("customer_id", document.querySelector("#customer_id").value);
        dataForm.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        dataForm.append('_method', 'PUT');

        fetch("{{ route('customers.contact.store') }}", {
            method: 'POST',
            body: dataForm
        })
        .then(res => res.text())
        .then(data => {
            const response = JSON.parse(data);

            toggleContactModal(false);

            toastr.success(response.message);

            var table = document.querySelector(".table-contacts");
            const size = table.querySelectorAll("tbody tr").length;

            var row = table.insertRow();
            row.innerHTML = response.contact;

            deleteModalHandle();
            editModalHandle();

        }).catch(err => {
            console.log(err);
            toastr.error(err);
        });
    }

    function editContact() {
        const dataForm = new FormData();
        const id = document.querySelector("#contact_modal").dataset.id;
        const row = document.querySelector("#contact_modal").dataset.row;

        dataForm.append("general_contact_type_id", document.querySelector("#contact_modal #general_contact_type_id").value);
        dataForm.append("description", document.querySelector("#contact_modal #description").value);
        dataForm.append("obs", document.querySelector("#contact_modal #obs").value);
        dataForm.append("customer_id", document.querySelector("#customer_id").value);
        dataForm.append('id', id);
        dataForm.append('key', row);
        dataForm.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        dataForm.append('_method', 'POST');

        fetch("{{ route('customers.contact.update', ['contact' => '#']) }}".replace("#", id), {
            method: 'POST',
            body: dataForm
        })
        .then(res => res.text())
        .then(data => {
            const response = JSON.parse(data);

            toggleContactModal(false);

            toastr.success(response.message);

            var table = document.querySelector(".table-contacts");
            const cells = table.rows[row].innerHTML = response.contact;

        }).catch(err => {
            console.log(err);
            toastr.error(err);
        });
    }

    document.querySelector("#confirm_contact_modal").addEventListener("click", function() {
        const modal = document.querySelector("#contact_modal");
       if(modal.dataset.id == 0) addContact();
       if(modal.dataset.id != 0)  editContact();
    });

    document.querySelector("#delect_contact_modal_confirm").addEventListener("click", function() {
        const dataForm = new FormData();
        const id = document.querySelector("#delete_contact_modal").dataset.id;
        const row = document.querySelector("#delete_contact_modal").dataset.row;

        dataForm.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        dataForm.append('_method', 'DELETE');
        dataForm.append('id', id);

        fetch("{{ route('customers.contact.delete', ['contact' => '#']) }}".replace("#", id), {
            method: 'POST',
            body: dataForm
        })
        .then(res => res.text())
        .then(data => {
            const response = JSON.parse(data);

            toggleDeleteContactModal(false);

            toastr.success(response.message);

            var table = document.querySelector(".table-contacts");
            table.deleteRow(row);

        }).catch(err => {
            console.log(err);
            toastr.error(err);
        });
    });

    function showContacts() {
        return {
            open: false,
            show() {
                this.open = true;
                setTimeout(() => document.getElementById("show_all_contacts").scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                }), 100);
            },
            close() {
                this.open = false;
                setTimeout(() => document.getElementById("show_all_contacts").scrollIntoView({
                    behavior: 'smooth',
                    block: 'end'
                }), 100);
            },
            isOpen() {
                return this.open === true
            },
        }
    }

</script>
