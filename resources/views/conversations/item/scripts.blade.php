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

        window.addEventListener("load", function() {
            const additive = document.querySelector("#additive");
            const cpeaLinkedId = document.querySelector("#cpea_linked_id");
            if(additive.value == "y") {
                cpeaLinkedId.disabled = false;
            } else {
                cpeaLinkedId.disabled = true;
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

    function toggleAddressModal(show = false) {
        const modal = document.querySelector("#address_modal");
        if(show) modal.classList.remove("hidden");
        if(!show) modal.classList.add("hidden");
    }

    function addAttachment() {
        var form = document.querySelector("#attachment_modal_form");
        form.reportValidity();

        if (!form.checkValidity()) {
            event.preventDefault();
            return;
        }

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

    function checkValidityValue() {
        var form = document.querySelector("#value_modal_form");
        const proposed = document.querySelectorAll(".value-type[value='proposed']").length
        var valueType = document.querySelector("#value_modal #value_type");

        if(valueType.value == 'proposed' && proposed > 0) {
            valueType.setCustomValidity(`Não é permitido adicionar mais de um valor do tipo "Proposta", só pode existir apenas um valor do tipo "Proposta"`)
        } else {
            valueType.setCustomValidity('');
        }

        form.reportValidity();

        return form.checkValidity() && !(valueType.value == 'proposed' && proposed > 0);
    }

    function addValue() {
        if (!checkValidityValue()) {
            event.preventDefault();
            return;
        }

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

    function addAddress() {
        var form = document.querySelector("#address_modal_form");
        form.reportValidity();

        if (!form.checkValidity()) {
            event.preventDefault();
            return;
        }

        const dataForm = new FormData();
        const token = document.querySelector('meta[name="csrf-token"]').content;

        dataForm.append("conversation_item_id", document.querySelector("#conversation_item_id").value);
        dataForm.append("address_name", document.querySelector("#address_modal #address_name").value);
        dataForm.append("address", document.querySelector("#address_modal #address").value);
        dataForm.append("obs", document.querySelector("#address_modal #obs").value);
        dataForm.append("_method", "POST");
        dataForm.append("_token", token);

        fetch("{{ route('customers.conversations.item.address.store') }}", {
            method: 'POST',
            body: dataForm
        })
        .then(res => res.text())
        .then(data => {
            const response = JSON.parse(data);

            toggleAddressModal(false);

            toastr.success(response.message);

            var table = document.querySelector(".table-address");

            var row = table.insertRow();
            row.innerHTML = response.address;

            deleteAddressModalHandle();

        }).catch(err => {
            console.log(err);
            toastr.error(err);
        });
    }

    function addLocalAttachment() {
        var form = document.querySelector("#attachment_modal_form");
        form.reportValidity();

        if (!form.checkValidity()) {
            event.preventDefault();
            return;
        }

        var table = document.querySelector(".table-attachments");
        var row = table.insertRow();
        const file = document.querySelector("#attachment_modal #file").files;
        const name = document.querySelector("#attachment_modal #name").value;
        const obs = document.querySelector("#attachment_modal #obs").value;
        const rowLength = table.rows.length;
        const index = rowLength - 2;

        row.innerHTML = `<tr>
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
                                <button type="button" class="btn-transition-danger delete-attachment">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>`;
        toggleAttachmentModal(false);
        document.querySelector(`input[type="file"][name="files[${index}][file]"]`).files = file;
        deleteAttachmentModalHandle(row.querySelector(".delete-attachment"));
    }

    function addLocalValue() {
        if (!checkValidityValue()) {
            event.preventDefault();
            return;
        }

        var table = document.querySelector(".table-values");
        var row = table.insertRow();
        const value_type = document.querySelector("#value_modal #value_type").value;
        const value_type_text = document.querySelector("#value_modal #value_type").options[document.querySelector("#value_modal #value_type").selectedIndex].text;
        const value = document.querySelector("#value_modal #value").value.replace(".", "").replace(",", ".");
        const description = document.querySelector("#value_modal #description").value;
        const obs = document.querySelector("#value_modal #obs").value;
        const rowLength = table.rows.length;
        var brl = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        });
        const index = rowLength - 2;

        row.innerHTML = `<tr>
                            <td>
                                ${value_type_text}
                                <input type="hidden" name="values[${index}][value_type]" value="${value_type}" class="value-type">
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
                                <button type="button" class="btn-transition-danger delete-value">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>`;
        toggleValueModal(false);
        deleteValueModalHandle(row.querySelector(".delete-value"));
    }

    function addLocalAddress() {
        var form = document.querySelector("#address_modal_form");
        form.reportValidity();

        if (!form.checkValidity()) {
            event.preventDefault();
            return;
        }

        var table = document.querySelector(".table-address");
        var row = table.insertRow();
        const address_name = document.querySelector("#address_modal #address_name").value;
        const address = document.querySelector("#address_modal #address").value;
        const obs = document.querySelector("#address_modal #obs").value;
        const rowLength = table.rows.length;
        const index = rowLength - 2;

        row.innerHTML = `<tr>
                            <td>
                                ${address_name}
                                <input type="hidden" name="address[${index}][address_name]" value="${address_name}">
                            </td>
                            <td>
                                ${address}
                                <input type="hidden" name="address[${index}][address]" value="${address}">
                            </td>
                            <td>
                                ${obs}
                                <input type="hidden" name="address[${index}][obs]" value="${obs}">
                            </td>
                            <td>
                                <button type="button" class="btn-transition-danger delete-address">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>`;
        toggleAddressModal(false);
        deleteAddressModalHandle(row.querySelector(".delete-address"));
    }

    if(document.querySelector(".create #confirm_attachment_modal")) {
        document.querySelector(".create #confirm_attachment_modal").addEventListener("click", function() {
            addLocalAttachment();
        });
    }

    if(document.querySelector(".edit #confirm_attachment_modal")) {
        document.querySelector(".edit #confirm_attachment_modal").addEventListener("click", function() {
            addAttachment();
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

    if(document.querySelector(".create #confirm_value_modal")) {
        document.querySelector(".create #confirm_value_modal").addEventListener("click", function() {
            addLocalValue();
        });
    }

    if(document.querySelector(".edit #confirm_value_modal")) {
        document.querySelector(".edit #confirm_value_modal").addEventListener("click", function() {
            addValue();
        });
    }

    if(document.querySelector(".create #confirm_address_modal")) {
        document.querySelector(".create #confirm_address_modal").addEventListener("click", function() {
            addLocalAddress();
        });
    }

    if(document.querySelector(".edit #confirm_address_modal")) {
        document.querySelector(".edit #confirm_address_modal").addEventListener("click", function() {
            addAddress();
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

    if(document.querySelector("#add_address")) {
        document.querySelector("#add_address").addEventListener("click", function() {
            toggleAddressModal(true);
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

    if(document.querySelector("#cancel_address_modal")) {
        document.querySelector("#cancel_address_modal").addEventListener("click", function() {
            toggleAddressModal(false);
        });
    }

    function toggleDeleteAttachmentModal(show = false, elem = null) {
        const modal = document.querySelector("#delete_attachment_modal");
        if(show) {
            modal.classList.remove("hidden");
            var url = elem.dataset.url;
            modal.dataset.url = url;
        }
        if(!show) modal.classList.add("hidden");
    }

    function toggleDeleteValueModal(show = false, elem = null) {
        const modal = document.querySelector("#delete_value_modal");
        if(show) {
            modal.classList.remove("hidden");
            var url = elem.dataset.url;
            modal.dataset.url = url;
        }
        if(!show) modal.classList.add("hidden");
    }

    function toggleDeleteAddressModal(show = false, elem = null) {
        const modal = document.querySelector("#delete_address_modal");
        if(show) {
            modal.classList.remove("hidden");
            var url = elem.dataset.url;
            modal.dataset.url = url;
        }
        if(!show) modal.classList.add("hidden");
    }

    function deleteAttachmentModalHandle(elem = null) {
        if(elem) {
            elem.addEventListener("click", function(e) {
                e.preventDefault();
                var table = document.querySelector(".table-attachments");
                var i = elem.parentNode.parentNode.rowIndex;
                table.deleteRow(i);
                console.log(i);
            });
        } else {
            document.querySelectorAll(".delete-attachment.edit").forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                    toggleDeleteAttachmentModal(true, this);
                });
            });
        }
    }

    function deleteValueModalHandle(elem = null) {
        if(elem) {
            elem.addEventListener("click", function(e) {
                e.preventDefault();
                var table = document.querySelector(".table-values");
                var i = elem.parentNode.parentNode.rowIndex;
                table.deleteRow(i);
                console.log(i);
            });
        } else {
            document.querySelectorAll(".delete-value.edit").forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                    toggleDeleteAttachmentModal(true, this);
                });
            });
        }
    }

    function deleteAddressModalHandle(elem = null) {
        if(elem) {
            elem.addEventListener("click", function(e) {
                e.preventDefault();
                var table = document.querySelector(".table-address");
                var i = elem.parentNode.parentNode.rowIndex;
                table.deleteRow(i);
                console.log(i);
            });
        } else {
            document.querySelectorAll(".delete-address.edit").forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                    toggleDeleteAttachmentModal(true, this);
                });
            });
        }
    }

    deleteAttachmentModalHandle();
    deleteValueModalHandle();
    deleteAddressModalHandle();

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

    if(document.querySelector("#cancel_address_delete")) {
        document.querySelector("#cancel_address_delete").addEventListener("click", function() {
            toggleDeleteAddressModal(false);
        });
    }

    document.querySelector("#meeting_form").addEventListener("change", function() {
        if(this.value == 'online') {
            document.querySelector(".meeting-place").classList.add("hidden");
            document.querySelector(".teams-url").classList.remove("hidden");
        }

        if(this.value == 'presential') {
            document.querySelector(".meeting-place").classList.remove("hidden");
            document.querySelector(".teams-url").classList.add("hidden");
        }
    });

</script>
