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

    document.querySelector("#additive").addEventListener("change", function() {
        document.querySelector("#cpea_linked_id").value = "";
        window.customSelectArray["cpea_linked_id"].update();
        if(this.value == "y") {
            document.querySelector("#cpea_linked_id").disabled = false;
        } else {
            document.querySelector("#cpea_linked_id").disabled = true;
        }
    });

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
</script>
