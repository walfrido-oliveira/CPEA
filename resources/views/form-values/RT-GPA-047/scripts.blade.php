<script>
    function showDetails() {
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

<script>
    document.getElementById("help").addEventListener("click", function() {
        var modal = document.getElementById("modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

    document.getElementById("confirm_modal").addEventListener("click", function(e) {
        var modal = document.getElementById("modal");
        modal.classList.add("hidden");
    });
</script>

<script>
    var wellDepth = document.getElementById("well_depth");
    var waterLevel = document.getElementById("water_level");
    var waterColumn = document.getElementById("water_column");

    var fqParameters =document.getElementById("fq_parameters");
    var pumpDepth = document.getElementById("pump_depth");
    var flowRate = document.getElementById("flow_rate");

    var fieldTeam = document.getElementById("field_team");
    var technician = document.getElementById("technician");

    function calcFqParameters() {
        const pumpDepthValue = pumpDepth.value;
        const flowRateValue = flowRate.value;
        fqParameters.value = ((180 + (12 * pumpDepthValue) + 85) / flowRateValue).toFixed(0);
    }

    function calcWaterColumn() {
        const wellDepthValue = wellDepth.value;
        const waterLevelValue = waterLevel.value;
        waterColumn.value = (wellDepthValue - waterLevelValue).toFixed(2);
    }

    fieldTeam.addEventListener("change", function() {
        technician.value = fieldTeam.value;
    });

    flowRate.addEventListener("change", function() {
        calcFqParameters();
    });

    pumpDepth.addEventListener("change", function() {
        calcFqParameters();
    });

    wellDepth.addEventListener("change", function() {
        calcWaterColumn();
    });

    waterLevel.addEventListener("change", function() {
        calcWaterColumn();
    });
</script>

<script>
    document.querySelectorAll(`.add-sample`).forEach(item => {
        item.addEventListener("click", function() {
            addInput();
        })
    });

    function addInput() {
        const nodes = document.querySelectorAll(".sample");
        const node = nodes[nodes.length - 1];
        const clone = node.cloneNode(true);
        const num = parseInt(clone.id.match(/\d+/g), 10) + 1;
        const id = `sample_${num}`;
        clone.id = id;

        clone.innerHTML = clone.innerHTML.replaceAll(`row_${num-1}`, `row_${num}`);
        clone.innerHTML = clone.innerHTML.replaceAll(`sample_${num-1}`, `sample_${num}`);
        clone.innerHTML = clone.innerHTML.replaceAll(`AMOSTRA <span>${nodes.length}</span>`, `AMOSTRA <span>${nodes.length + 1}</span>`);
        clone.innerHTML = clone.innerHTML.replaceAll(`data-row="${num-1}"`, `data-row="${num}"`);
        clone.innerHTML = clone.innerHTML.replaceAll(`_${num-1}`, `_${num}`);
        clone.innerHTML = clone.innerHTML.replaceAll(`readonly="1"`, ``);

        clone.querySelectorAll("#table_result tr").forEach(item => {
            item.remove();
        });

        document.getElementById("samples_items").appendChild(clone);

        document.querySelectorAll(`#${id} input:not(#form_value_id):not(#sample_index_${num})`).forEach(item => {
            item.value = "";
            item.disabled = false;
            document.querySelector(`#${id} .save-sample`).style.display = "inline-block";
            document.querySelector(`#${id} .edit-sample`).style.display = "none";
        });

        document.querySelectorAll(`#${id} tfoot td`).forEach(item => {
            item.innerHTML = "";
        });

        document.querySelector(`#${id} .remove-sample`).style.display = "block";

        document.querySelector(`#${id} .remove-sample`).addEventListener("click", function() {
            var modal = document.getElementById("delete_modal");
            modal.classList.remove("hidden");
            modal.classList.add("block");
            document.querySelector("#confirm_delete_modal").dataset.index = this.dataset.index;
            document.querySelector("#confirm_delete_modal").dataset.row = this.dataset.row;
        });

        document.querySelector(`#${id} .add-sample`).addEventListener("click", function() {
            addInput();
        });

        document.querySelectorAll(`#${id} .edit-sample`).forEach(item => {
            item.addEventListener("click", function() {
                item.nextElementSibling.style.display = "inline-block";
                item.style.display = "none";
                document.querySelectorAll(`#${this.dataset.index} input`).forEach(item => {
                    item.disabled = false;
                });
            });
        });

        document.querySelectorAll(`#${id} .save-sample`).forEach(item => {
            item.addEventListener("click", function() {
                saveSample(this)
            });
        });

        document.getElementById(id).scrollIntoView();

    }

    document.getElementById("cancel_delete_modal").addEventListener("click", function() {
        var modal = document.getElementById("delete_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
    });


    document.querySelectorAll(".remove-sample").forEach(item => {
        item.addEventListener("click", function() {
            var modal = document.getElementById("delete_modal");
            modal.classList.remove("hidden");
            modal.classList.add("block");
            document.querySelector("#confirm_delete_modal").dataset.index = this.dataset.index;
            document.querySelector("#confirm_delete_modal").dataset.row = this.dataset.row;
        });
    });

    document.querySelector("#confirm_delete_modal").addEventListener("click", function() {
        deleteSample(this);
    });

    function deleteSample(that) {
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.form-values.delete-sample') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let sample_index = document.querySelector(`#${that.dataset.index} #sample_index_${that.dataset.row}`).value;

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                toastr.success(resp.message);
                location.reload();
            } else if (this.readyState == 4 && this.status != 200) {
                document.getElementById("spin_load").classList.add("hidden");
                toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
                that.value = '';
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('form_value_id', form_value_id);
        data.append('sample_index', sample_index);

        ajax.send(data);
    }
</script>
