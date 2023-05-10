<script>
    document.querySelectorAll(`input[name='item_type']`).forEach(item => {
        item.addEventListener("change", function(e) {
            document.querySelectorAll(`.status`).forEach(item2 => {
                item2.classList.add("hidden");
            });
            document.querySelector(`.${item.value}-status`).classList.remove("hidden");

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

    document.querySelector("#direction_id").addEventListener("change", function() {
        const dataForm = new FormData();
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const id = this.value;
        const employees = document.querySelector("#employee_id");

        dataForm.append("_method", "POST");
        dataForm.append("_token", token);

        fetch("{{ route('employees.get-by-direction', ['direction' => '#']) }}".replace("#", id), {
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
            addAttachment();
        });
    }

    if(document.querySelector("#confirm_value_modal")) {
        document.querySelector("#confirm_value_modal").addEventListener("click", function() {
            addValue();
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
                toggleDeleteAttachmentModal(true);

                const modal = document.querySelector("#delete_attachment_modal");
                modal.dataset.url = this.dataset.url;
                modal.dataset.id = item.dataset.id;
                modal.dataset.row = item.parentElement.parentElement.rowIndex;
            });
        });
    }

    function deleteValueModalHandle() {
        document.querySelectorAll(".delete-value").forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                toggleDeleteValueModal(true);

                const modal = document.querySelector("#delete_value_modal");
                modal.dataset.url = this.dataset.url;
                modal.dataset.id = item.dataset.id;
                modal.dataset.row = item.parentElement.parentElement.rowIndex;
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
