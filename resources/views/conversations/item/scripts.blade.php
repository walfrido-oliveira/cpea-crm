<script>
    document.querySelectorAll(`input[name='item_type']`).forEach(item => {
        item.addEventListener("change", function(e) {
            document.querySelectorAll(`.status`).forEach(item2 => {
                item2.classList.add("hidden");
            });
            document.querySelector(`.${item.value}-status`).classList.remove("hidden");
        });
    });

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
