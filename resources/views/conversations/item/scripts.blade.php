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
