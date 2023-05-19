<script>
    document.querySelectorAll(`input[name='item_type']`).forEach(item => {
        item.addEventListener("change", function(e) {
            document.querySelectorAll(`.status`).forEach(item2 => {
                item2.classList.add("hidden");
                item2.querySelector("select").removeAttribute("required");
            });
            document.querySelector(`.${item.value}-status`).classList.remove("hidden");
            document.querySelector(`.${item.value}-status`).querySelector("select").setAttribute("required", "");

            toggleProspectsFiedls(false);
            toggleProposedFiedls(false);

            switch (item.value) {
                case "Prospect":
                    toggleProspectsFiedls(true);
                    break;
                case "Proposta":
                    toggleProposedFiedls(true);
                    break;
            }
        });
    });

    function toggleProspectsFiedls(show) {
        document.querySelectorAll(".prospects-fields").forEach(field => {
            if(show)field.classList.remove("hidden")
            if(!show)field.classList.add("hidden")
        });
    }

    function toggleProposedFiedls(show) {
        document.querySelectorAll(".proposed-fields").forEach(field => {
            if(show)field.classList.remove("hidden")
            if(!show)field.classList.add("hidden")
        });
    }

    document.querySelector("#schedule_type").addEventListener("change", function() {
        if(this.value == "internal") {
            document.querySelector("#addressees").disabled = true;
            document.querySelector("#addressees").value = "";
            document.querySelector("#optional_addressees").disabled = true;
            document.querySelector("#optional_addressees").value = "";
        } else {
            document.querySelector("#addressees").disabled = false;
            document.querySelector("#optional_addressees").disabled = false;
        }
    });

    if(document.querySelector("#additive")) {
        document.querySelector("#additive").addEventListener("change", function() {
            document.querySelector("#cpea_linked_id").value = "";
            if(this.value == "y") {
                document.querySelector("#cpea_linked_id").disabled = false;
            } else {
                document.querySelector("#cpea_linked_id").disabled = true;
            }
        });
    }

    function getEmployees(direction_id, department_id) {
        const dataForm = new FormData();
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const id = this.value;
        const employees = document.querySelector("#employee_id");

        dataForm.append("_method", "POST");
        dataForm.append("_token", token);
        dataForm.append("direction_id", direction_id);
        dataForm.append("department_id", department_id);

        fetch("{{ route('employees.get-by-params') }}".replace("#", id), {
            method: 'POST',
            body: dataForm
        })
        .then(res => res.text())
        .then(data => {
            const response = JSON.parse(data);

            var i, L = employees.options.length - 1;
            for(i = L; i >= 0; i--) {
                employees.remove(i);
            }

            for (let index = 0; index < response.length; index++) {
                const element = response[index];

                var option = document.createElement("option");
                option.text = element.name;
                option.value = element.id;

                employees.add(option);
           }

           window.customSelectArray["employee_id"].update();
        }).catch(err => {
            console.log(err);
        });
    }

    document.querySelector("#direction_id").addEventListener("change", function() {
        getEmployees(this.value, document.querySelector("#department_id").value);
    });

    document.querySelector("#department_id").addEventListener("change", function() {
        getEmployees(document.querySelector("#direction_id").value, this.value);
    });

    function showFieldsSchedule() {
        return {
            open: false,
            show() {
                this.open = true;
            },
            close() {
                this.open = false;
            },
            isOpen() {
                return this.open === true
            },
        }
    }

    function toggleAttachmentModal(show = false) {
        const modal = document.querySelector("#attachment_modal");
        if(show) modal.classList.remove("hidden");
        if(!show) modal.classList.add("hidden");
    }

    function toggleValueModal(show = false) {
        const modal = document.querySelector("#value_modal");
        if(show) modal.classList.remove("hidden");
        if(!show) modal.classList.add("hidden");
    }

    function addAttachment() {
        const dataForm = new FormData();
        const token = document.querySelector('meta[name="csrf-token"]').content;

        dataForm.append("conversation_item_id", document.querySelector("#conversation_item_id").value);
        dataForm.append("name", document.querySelector("#attachment_modal #name").value);
        dataForm.append("obs", document.querySelector("#attachment_modal #obs").value);
        dataForm.append("file", document.querySelector("#attachment_modal #file").files[0]);
        dataForm.append("_method", "POST");
        dataForm.append("_token", token);

        fetch("{{ route('customers.conversations.item.attachments.store') }}", {
            method: 'POST',
            body: dataForm
        })
        .then(res => res.text())
        .then(data => {
            const response = JSON.parse(data);

            console.log(response);

            toggleAttachmentModal(false);

            toastr.success(response.message);

            var table = document.querySelector(".table-attachments");

            var row = table.insertRow();
            row.innerHTML = response.attachment;

            deleteAttachmentModalHandle();

        }).catch(err => {
            console.log(err);
            toastr.error(err);
        });
    }

    function addValue() {
        const dataForm = new FormData();
        const token = document.querySelector('meta[name="csrf-token"]').content;

        dataForm.append("conversation_item_id", document.querySelector("#conversation_item_id").value);
        dataForm.append("value_type", document.querySelector("#value_modal #value_type").value);
        dataForm.append("description", document.querySelector("#value_modal #description").value);
        dataForm.append("value", document.querySelector("#value_modal #value").value);
        dataForm.append("obs", document.querySelector("#value_modal #obs").value);
        dataForm.append("_method", "POST");
        dataForm.append("_token", token);

        fetch("{{ route('customers.conversations.item.values.store') }}", {
            method: 'POST',
            body: dataForm
        })
        .then(res => res.text())
        .then(data => {
            const response = JSON.parse(data);

            console.log(response);

            toggleValueModal(false);

            toastr.success(response.message);

            var table = document.querySelector(".table-values");

            var row = table.insertRow();
            row.innerHTML = response.value;

            deleteValueModalHandle();

        }).catch(err => {
            console.log(err);
            toastr.error(err);
        });
    }

    if(document.querySelector("#confirm_attachment_modal")) {
        document.querySelector("#confirm_attachment_modal").addEventListener("click", function() {
            var table = document.querySelector(".table-attachments");
            var row = table.insertRow();
            const file = document.querySelector("#attachment_modal #file").files;
            const name = document.querySelector("#attachment_modal #name").value;
            const obs = document.querySelector("#attachment_modal #obs").value;
            const rowLength = table.rows.length;
            var index = rowLength - 2;
            row.innerHTML = `<tr data-row="${index}">
                                <td>
                                    ${name}
                                    <input type="hidden" name="files[${index}][name]" value="${name}">
                                    <input type="file" class="hidden" name="files[${index}][file]"  value="${file}">
                                </td>
                                <td>
                                    ${obs}
                                    <input type="hidden" name="files[${index}][obs]" value="${obs}">
                                </td>
                                <td>
                                    <button type="button" class="btn-transition-danger delete-attachment" data-row="${index}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>`;
            toggleAttachmentModal(false);
            document.querySelector(`input[type="file"][name="files[${index}][file]"]`).files = file;
            deleteAttachmentModalHandle();
        });
    }

    document.querySelector("#value_modal #value").addEventListener("keyup", function() {
        var value = this.value.replace('.', '').replace(',', '').replace(/\D/g, '');

        const options = { minimumFractionDigits: 2 }
        const result = new Intl.NumberFormat('pt-BR', options).format(
            parseFloat(value) / 100
        );

        this.value = result;
    });

    if(document.querySelector("#confirm_value_modal")) {
        document.querySelector("#confirm_value_modal").addEventListener("click", function() {
            var table = document.querySelector(".table-values");
            var row = table.insertRow();
            const value_type = document.querySelector("#value_modal #value_type").value;
            const value_type_text = document.querySelector("#value_modal #value_type").options[document.querySelector("#value_modal #value_type").selectedIndex].text;
            const value = document.querySelector("#value_modal #value").value.replace(".", "").replace(",", ".");
            const description = document.querySelector("#value_modal #description").value;
            const obs = document.querySelector("#value_modal #obs").value;
            const rowLength = table.rows.length;
            var index = rowLength - 2;
            var brl = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL',
            });

            row.innerHTML = `<tr data-row="${index}">
                                <td>
                                    ${value_type_text}
                                    <input type="hidden" name="values[${index}][value_type]" value="${value_type}">
                                </td>
                                <td>
                                    ${description}
                                    <input type="hidden" name="values[${index}][description]" value="${description}">
                                </td>
                                <td>
                                    ${brl.format(value)}
                                    <input type="hidden" name="values[${index}][value]" value="${value}">
                                </td>
                                <td>
                                    ${obs}
                                    <input type="hidden" name="values[${index}][obs]" value="${obs}">
                                </td>
                                <td>
                                    <button type="button" class="btn-transition-danger delete-value" data-row="${index}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>`;
            toggleValueModal(false);
            deleteValueModalHandle();
        });
    }

    if(document.querySelector("#add_attachment")) {
        document.querySelector("#add_attachment").addEventListener("click", function() {
            toggleAttachmentModal(true);
        });
    }

    if(document.querySelector("#add_value")) {
        document.querySelector("#add_value").addEventListener("click", function() {
            toggleValueModal(true);
        });
    }

    if(document.querySelector("#cancel_attachment_modal")) {
        document.querySelector("#cancel_attachment_modal").addEventListener("click", function() {
            toggleAttachmentModal(false);
        });
    }

    if(document.querySelector("#cancel_value_modal")) {
        document.querySelector("#cancel_value_modal").addEventListener("click", function() {
            toggleValueModal(false);
        });
    }

    function toggleDeleteAttachmentModal(show = false) {
        const modal = document.querySelector("#delete_attachment_modal");
        if(show) modal.classList.remove("hidden");
        if(!show) modal.classList.add("hidden");
    }

    function toggleDeleteValueModal(show = false) {
        const modal = document.querySelector("#delete_value_modal");
        if(show) modal.classList.remove("hidden");
        if(!show) modal.classList.add("hidden");
    }

    function deleteAttachmentModalHandle() {
        document.querySelectorAll(".delete-attachment").forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                var table = document.querySelector(".table-attachments");
                table.deleteRow(item.dataset.row + 1);

                /*toggleDeleteAttachmentModal(true);

                const modal = document.querySelector("#delete_attachment_modal");
                modal.dataset.url = this.dataset.url;
                modal.dataset.id = item.dataset.id;
                modal.dataset.row = item.parentElement.parentElement.rowIndex;*/
            });
        });
    }

    function deleteValueModalHandle() {
        document.querySelectorAll(".delete-value").forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                var table = document.querySelector(".table-valuets");
                table.deleteRow(item.dataset.row + 1);

                /*toggleDeleteValueModal(true);

                const modal = document.querySelector("#delete_value_modal");
                modal.dataset.url = this.dataset.url;
                modal.dataset.id = item.dataset.id;
                modal.dataset.row = item.parentElement.parentElement.rowIndex;*/
            });
        });
    }

    deleteAttachmentModalHandle();
    deleteValueModalHandle();

    if(document.querySelector("#cancel_attachment_delete")) {
        document.querySelector("#cancel_attachment_delete").addEventListener("click", function() {
            toggleDeleteAttachmentModal(false);
        });
    }

    if(document.querySelector("#cancel_value_delete")) {
        document.querySelector("#cancel_value_delete").addEventListener("click", function() {
            toggleDeleteValueModal(false);
        });
    }

    if(document.querySelector("#confirm_value_delete")) {
        document.querySelector("#confirm_value_delete").addEventListener("resp", function(e) {
            console.log(e);
        })
    }
</script>
