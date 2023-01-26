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

    function calcFqParameters(elem) {
        const pumpDepthValue = document.querySelector(`#pump_depth_${elem.dataset.index}`).value;
        const flowRateValue = document.querySelector(`#flow_rate_${elem.dataset.index}`).value;
        document.querySelector(`#fq_parameters_${elem.dataset.index}`).value = ((180 + (12 * pumpDepthValue) + 85) / flowRateValue).toFixed(0);
        console.log(document.querySelector(`#fq_parameters_${elem.dataset.index}`));
    }

    function calcWaterColumn(elem) {
        const wellDepthValue = document.querySelector(`#well_depth_${elem.dataset.index}`).value;
        const waterLevelValue = document.querySelector(`#water_level_${elem.dataset.index}`).value;
        document.querySelector(`#water_column_${elem.dataset.index}`).value = (wellDepthValue - waterLevelValue).toFixed(2);
        console.log(document.querySelector(`#water_column_${elem.dataset.index}`));
    }

    document.querySelectorAll(".flow-rate").forEach(item => {
        item.addEventListener("change", function() {
            calcFqParameters(this);
        });
    });

    document.querySelectorAll(".pump-depth").forEach(item => {
        item.addEventListener("change", function() {
            calcFqParameters(this);
        });
    });

    document.querySelectorAll(".well-depth").forEach(item => {
        item.addEventListener("change", function() {
            calcWaterColumn(this);
        });
    });

    document.querySelectorAll(".water-level").forEach(item => {
        item.addEventListener("change", function() {
            calcWaterColumn(this);
        });
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

        document.querySelector(`#${id} .save-sample`).style.display = "inline-block";
        document.querySelector(`#${id} .edit-sample`).style.display = "none";

        document.querySelectorAll(`#${id} input:not(#form_value_id):not(#sample_index_${num}):not(.fq-parameters):not(.water-column)`).forEach(item => {
            item.value = "";
            item.readOnly = false;
        });

        document.querySelectorAll(`#${id} select:not(#form_value_id):not(#sample_index_${num}):not(.fq-parameters):not(.water-column)`).forEach(item => {
            item.value = "";
            item.disabled = false;
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
                document.querySelectorAll(`#${this.dataset.index} input:not(.fq-parameters):not(.water-column)`).forEach(item => {
                    item.readOnly = false;
                });
                document.querySelectorAll(`#${this.dataset.select} input:not(.fq-parameters):not(.water-column)`).forEach(item => {
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

<script>
    document.querySelectorAll(".edit-sample").forEach(item => {
        item.addEventListener("click", function() {
            item.nextElementSibling.style.display = "inline-block";
            item.style.display = "none";
            document.querySelectorAll(`#${this.dataset.index} input:not(.fq-parameters):not(.water-column)`).forEach(item => {
                item.readOnly = false;
                item.disabled = false;
            });
            document.querySelectorAll(`#${this.dataset.index} select:not(.fq-parameters):not(.water-column)`).forEach(item => {
                item.readOnly = false;
                item.disabled = false;
            });
        });
    });

    document.querySelectorAll(".save-sample").forEach(item => {
        item.addEventListener("click", function() {
            saveSample(this)
        });
    });

    function saveSample(that) {
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.form-values.save-sample-form-RTGPA047') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let sample_index = document.querySelector(`#${that.dataset.index} #sample_index_${that.dataset.row}`).value;

        const fields = [...document.querySelectorAll(`#${that.dataset.index} input, #${that.dataset.index} select`)];

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

        fields.forEach(element => {
            data.append(element.name, element.value);
        });

        ajax.send(data);
    }

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
