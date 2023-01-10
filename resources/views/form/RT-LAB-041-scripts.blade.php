<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<script>
    window.addEventListener("load", function() {
        var ctx = document.getElementById('myChart').getContext('2d');
        const data = {
            datasets: [{
                labels: [
                    @if (isset($formValue->values['samples'] ))
                        @foreach ($formValue->values['samples'] as $key => $sample)
                            "{{ isset($sample['point']) ? $sample['point'] : '' }} - pH {{ isset($svgs[$key]['ph']) ? number_format($svgs[$key]['ph'], 2, ',', '.') : '' }} e EH {{ isset($svgs[$key]['eh']) ? number_format($svgs[$key]['eh'], 1, ',', '.') : '' }}",
                        @endforeach
                    @endif
                ],
                label: '',
                data: [
                    @if (isset($formValue->values['samples'] ))
                        @foreach ($formValue->values['samples'] as $key => $sample)
                            {
                                x: {{ isset($svgs[$key]['eh']) ? $svgs[$key]['eh'] : 0 }},
                                y: {{ isset($svgs[$key]['ph']) ? $svgs[$key]['ph'] : 0 }}
                            },
                        @endforeach
                    @endif
                ],
                backgroundColor: [
                    '#ff6384'
                ]
            }],
        };
        const config = {
            type: 'scatter',
            data: data,
            options: {
                backgroundRules: [{
                        backgroundColor: "rgb(253, 234, 218)",
                        yAxisSegement: 0
                    },
                    {
                        backgroundColor: "rgb(198,217,241)",
                        yAxisSegement: 400
                    },
                    {
                        backgroundColor: "rgb(236,202,201)",
                        yAxisSegement: 800
                    }
                ],
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                        title: {
                            display: true,
                            text: "EV (mV)"
                        },
                        min: -600,
                        max: 800,
                        ticks: {
                            stepSize: 100
                        },

                    },
                    y: {
                        min: 0,
                        max: 14,
                        ticks: {
                            stepSize: .5,
                            autoSkip: true,
                        },
                        title: {
                            display: true,
                            text: "pH"
                        },
                        grid: {
                            drawBorder: false,
                            lineWidth: function(context) {
                                if (context.tick.value == 5 || context.tick.value == 8)
                                    return 2;
                                return 1;
                            },
                            color: function(context) {
                                if (context.tick.value == 5 || context.tick.value == 8)
                                    return '#000000';
                                return '#ccc';
                            },
                        },
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.labels[context.dataIndex];
                                return `${label}`;
                            }
                        }
                    },
                }
            }
        };

        Chart.register({
            id: 'customBg',
            beforeDraw: function(chart) {

                var ctx = chart.ctx;
                var ruleIndex = 0;
                var rules = chart.options.backgroundRules;
                var yaxis = chart.scales.y;
                var xaxis = chart.scales.x;
                var partPercentage = 1 / (yaxis.ticks.length - 1);

                ctx.fillStyle = rules[0].backgroundColor;
                ctx.fillRect(xaxis.left, yaxis.top, (xaxis.width * partPercentage) * 5, yaxis
                    .height);

                ctx.fillStyle = rules[1].backgroundColor;
                ctx.fillRect(xaxis.left + (xaxis.width * partPercentage) * 5, yaxis.top, (xaxis
                    .width * partPercentage) * 5, yaxis.height);

                ctx.fillStyle = rules[2].backgroundColor;
                ctx.fillRect(xaxis.left + (((xaxis.width * partPercentage) * 5) * 2), yaxis.top, (
                    xaxis.width * partPercentage) * 4, yaxis.height);

                ctx.save();

                ctx.textAlign = "center";
                ctx.fillStyle = "#000";
                ctx.font = "bolder 12pt Nunito";

                ctx.fillText("Redutor", (xaxis.width * partPercentage) * 4, yaxis.bottom - 10);
                ctx.fillText("Moderadamente Oxidante", (xaxis.width * partPercentage) * 8, yaxis
                    .bottom - 10);
                ctx.fillText("Oxidante", (xaxis.width * partPercentage) * 13, yaxis.bottom - 10);

                ctx.restore();

                ctx.save();

                var font, text, x, y;

                text = "Ácido";

                font = 20;
                ctx.textAlign = "center";
                ctx.fillStyle = "#000";
                ctx.font = "bolder 12pt Nunito";

                var metrics = ctx.measureText(text);
                ctx.height = metrics.width;
                x = font / 2;
                y = metrics.width / 2;
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = "bottom";
                ctx.save();
                ctx.translate(x, y);
                ctx.rotate(-Math.PI / 2);
                ctx.fillText("Ácido", yaxis.top - 260, (xaxis.width * partPercentage) + 10);
                ctx.fillText("Neutro", yaxis.top - 180, (xaxis.width * partPercentage) + 10);
                ctx.fillText("Alcalino", yaxis.top - 70, (xaxis.width * partPercentage) + 10);
                ctx.zindex = 99999999;
                ctx.restore();

            },
        });

        var myChart = new Chart(ctx, config);
    });
</script>

<x-spin-load />
<x-back-to-top element="mode_table" />

<script>
    document.getElementById("filter_default").addEventListener("click", function(e) {
        e.preventDefault();
        this.classList.add("border-green-900");
        document.getElementById("filter_duplicate").classList.remove("border-green-900");

        document.querySelectorAll(".default-table, .duplicates-table").forEach(item => {
            item.classList.remove("fade");
        });

        document.querySelectorAll(".duplicate").forEach(item => {
            item.classList.add("fade");
        });
    });

    document.getElementById("filter_duplicate").addEventListener("click", function(e) {
        e.preventDefault();
        this.classList.add("border-green-900");
        document.getElementById("filter_default").classList.remove("border-green-900");

        document.querySelectorAll(".duplicates-table, .duplicate").forEach(item => {
            item.classList.remove("fade");
        });

        document.querySelectorAll(".default-table").forEach(item => {
            item.classList.add("fade");
        });
    });
</script>

<script>
    window.addEventListener("load", function() {
        const view_table = localStorage.getItem("view_mode");
        document.getElementById(view_table).click();
    });

    document.getElementById("view_table").addEventListener("click", function() {
        document.querySelectorAll("#mode_table").forEach(item => {
            item.style.display = "block";
        });

        document.querySelectorAll("#mode_sample_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_list").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#chart").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_coordinates_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_considerations").forEach(item => {
            item.style.display = "none";
        });

        localStorage.setItem("view_mode", "view_table");
    });

    document.getElementById("view_list").addEventListener("click", function() {
        document.querySelectorAll("#mode_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_sample_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_list").forEach(item => {
            item.style.display = "block";
        });

        document.querySelectorAll("#chart").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_coordinates_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_considerations").forEach(item => {
            item.style.display = "none";
        });

        localStorage.setItem("view_mode", "view_list");
    });

    document.getElementById("view_sample_table").addEventListener("click", function() {
        document.querySelectorAll("#mode_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_sample_table").forEach(item => {
            item.style.display = "block";
        });

        document.querySelectorAll("#mode_list").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#chart").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_coordinates_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_considerations").forEach(item => {
            item.style.display = "none";
        });

        localStorage.setItem("view_mode", "view_sample_table");
    });

    document.getElementById("view_chart").addEventListener("click", function() {
        document.querySelectorAll("#mode_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_sample_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_list").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#chart").forEach(item => {
            item.style.display = "block";
        });

        document.querySelectorAll("#mode_coordinates_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_considerations").forEach(item => {
            item.style.display = "none";
        });

        localStorage.setItem("view_mode", "view_chart");

    });

    document.getElementById("view_coordinates").addEventListener("click", function() {
        document.querySelectorAll("#mode_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_sample_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_list").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#chart").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_coordinates_table").forEach(item => {
            item.style.display = "block";
        });

        document.querySelectorAll("#mode_considerations").forEach(item => {
            item.style.display = "none";
        });

        localStorage.setItem("view_mode", "view_coordinates");

    });

    document.getElementById("view_considerations").addEventListener("click", function() {
        document.querySelectorAll("#mode_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_sample_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_list").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#chart").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_coordinates_table").forEach(item => {
            item.style.display = "none";
        });

        document.querySelectorAll("#mode_considerations").forEach(item => {
            item.style.display = "block";
        });

        localStorage.setItem("view_mode", "view_considerations");

    });
</script>

<script>
    document.getElementById("mode_list_count").addEventListener("change", function() {
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let count = this.value;
        let url = "{!! route('fields.forms.get-sample-list', ['form_value' => '#', 'count' => '?']) !!}".replace('#', form_value_id).replace('?', count);

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                document.getElementById("sample_list_container").innerHTML = resp.viwer;
                document.getElementById("spin_load").classList.add("hidden");

            } else if (this.readyState == 4 && this.status != 200) {
                document.getElementById("spin_load").classList.add("hidden");
                toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
                that.value = '';
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('id', form_value_id);
        data.append('count', count);

        ajax.send(data);
    });
</script>

<script>
    document.querySelectorAll(".edit-coordinate").forEach(item => {
        item.addEventListener("click", function() {
            item.nextElementSibling.style.display = "inline-block";
            item.style.display = "none";
            document.querySelectorAll(`#table_coordinates input`).forEach(item => {
                item.readOnly = false;
            });
        });
    });

    document.querySelectorAll(".save-coordinate").forEach(item => {
        item.addEventListener("click", function() {
            saveCoordinate(this)
        });
    });

    function saveCoordinate(that) {
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.forms.save-coordinate') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;

        const results = [...document.querySelectorAll(`#table_coordinates input`)];

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

        results.forEach(element => {
            data.append(element.name, element.value);
        });

        ajax.send(data);
    }
</script>

<script>
    document.querySelectorAll(".edit-sample").forEach(item => {
        item.addEventListener("click", function() {
            item.nextElementSibling.style.display = "inline-block";
            item.style.display = "none";
            document.querySelectorAll(`#${this.dataset.index} input`).forEach(item => {
                item.readOnly = false;
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
        let url = "{!! route('fields.forms.save-sample') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let sample_index = document.querySelector(`#${that.dataset.index} #sample_index_${that.dataset.row}`).value;
        let equipment = document.querySelector(`#${that.dataset.index} #equipment_${that.dataset.row}`).value;
        let point = document.querySelector(`#${that.dataset.index} #point_${that.dataset.row}`).value;
        let environment = document.querySelector(`#${that.dataset.index} #environment_${that.dataset.row}`).value;
        let collect = document.querySelector(`#${that.dataset.index} #collect_${that.dataset.row}`).value;

        const results = [...document.querySelectorAll(`#${that.dataset.index} #table_result input`)];

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
        data.append('equipment', equipment);
        data.append('point', point);
        data.append('environment', environment);
        data.append('collect', collect);

        results.forEach(element => {
            data.append(element.name, element.value);
        });

        ajax.send(data);
    }

    function deleteSample(that) {
        console.log(`#${that.dataset.index} #sample_index_${that.dataset.row}`);
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.forms.delete-sample') !!}";
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
    document.getElementById("confirm_environment_modal").addEventListener("click", function() {
        document.querySelectorAll("input.collect").forEach(item => {
            var date1 = new Date(item.value);
            var date2 = new Date(document.getElementById("date_start").value);
            var date3 = new Date(document.getElementById("date_end").value);
            var environmentValue = document.getElementById("environment_value");
            var environment = document.getElementById(`environment_${item.dataset.index}`);

            console.log(date1.getTime() >= date2.getTime() && date1.getTime() <= date3.getTime());
            console.log(date1.getTime() >= date2.getTime());
            console.log(date1.getTime() <= date3.getTime());

            if(date1.getTime() >= date2.getTime() && date1.getTime() <= date3.getTime()) {
                environment.value = environmentValue.value;
                console.log(environment.value);
            }
        });

        var modal = document.getElementById("environment_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
    });

    document.getElementById("cancel_environment_modal").addEventListener("click", function() {
        var modal = document.getElementById("environment_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
    });

    document.getElementById("environment_edit").addEventListener("click", function() {
        var modal = document.getElementById("environment_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

    document.getElementById("help").addEventListener("click", function() {
        var modal = document.getElementById("modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

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

    document.getElementById("confirm_modal").addEventListener("click", function(e) {
        var modal = document.getElementById("modal");
        modal.classList.add("hidden");
    });

    document.querySelectorAll(".import-sample-result").forEach(item => {
        item.addEventListener("click", function() {
            document.querySelector(`#${this.dataset.index} #file`).click();
        });
    });

    document.querySelectorAll(".import-samples").forEach(item => {
        item.addEventListener("click", function() {
            document.querySelector(`#files`).click();
        });
    });

    document.querySelectorAll(".sample #file").forEach(item => {
        item.addEventListener("change", function(e) {
            uploadResults(this);
        });
    });

    document.querySelectorAll("#files").forEach(item => {
        item.addEventListener("change", function(e) {
            uploadSamples(this);
        });
    });

    document.querySelectorAll(".import-sample-coordinates").forEach(item => {
        item.addEventListener("click", function() {
            document.querySelector(`#file_coordinates`).click();
        });
    });

    document.querySelectorAll("#file_coordinates").forEach(item => {
        item.addEventListener("change", function(e) {
            uploadCoordinates(this);
        });
    });

    function uploadCoordinates(that) {
        document.getElementById("spin_load").classList.remove("hidden");

        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.forms.import-coordinates') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let files = that.files;
        let form_value_id = document.querySelector(`#form_value_id`).value;

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
        data.append('_method', method);
        data.append('file', files[0]);
        data.append('form_value_id', form_value_id);

        ajax.send(data);
    }

    function uploadResults(that) {
        document.getElementById("spin_load").classList.remove("hidden");

        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.forms.import') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let files = that.files;
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
        data.append('_method', method);
        data.append('file', files[0]);
        data.append('form_value_id', form_value_id);
        data.append('sample_index', sample_index);

        ajax.send(data);
    }

    function uploadSamples(that) {
        document.getElementById("spin_load").classList.remove("hidden");

        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.forms.import-samples') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let files = that.files;
        let form_value_id = document.querySelector(`#form_value_id`).value;

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
        data.append('_method', method);
        for (let index = 0; index < files.length; index++) {
            const file = files[index];
            data.append('file[]', file);
        }
        data.append('form_value_id', form_value_id);

        ajax.send(data);
    }
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
        clone.innerHTML = clone.innerHTML.replaceAll(`AMOSTRA <span>${nodes.length}</span>`,
            `AMOSTRA <span>${nodes.length + 1}</span>`);
        clone.innerHTML = clone.innerHTML.replaceAll(`data-row="${num-1}"`, `data-row="${num}"`);
        clone.innerHTML = clone.innerHTML.replaceAll(`_${num-1}`, `_${num}`);
        clone.innerHTML = clone.innerHTML.replaceAll(`readonly="1"`, ``);

        clone.querySelectorAll("#table_result tr").forEach(item => {
            item.remove();
        });

        document.getElementById("mode_table").appendChild(clone);

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
        });

        document.querySelector(`#${id} .add-sample`).addEventListener("click", function() {
            addInput();
        });

        document.querySelectorAll(`#${id} .import-sample-result`).forEach(item => {
            item.addEventListener("click", function() {
                document.querySelector(`#${this.dataset.index} #file`).click();
            });
        });

        document.querySelector(`#${id} #file`).addEventListener("click", function() {
            uploadResults(this);
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
</script>

<script>
    document.getElementById("form_form").addEventListener("submit", function(e) {
        document.querySelectorAll("#mode_table input").forEach(item => {
            item.disabled = true;
        });
        document.querySelectorAll("#table_coordinates input").forEach(item => {
            item.disabled = true;
            console.log(item);
        });
    });
</script>
