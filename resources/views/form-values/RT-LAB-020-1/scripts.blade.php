<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<x-spin-load />
<x-back-to-top element="mode_table" />

<script>
    window.addEventListener("load", function() {
        setChart("myChart");
        setChart("myChart2");
    });

    function setChart(id) {
            var ctx = document.getElementById(id).getContext('2d');
            const data = {
                datasets: [{
                    labels: [
                        @if (isset($formValue->values['samples'] ))
                            @foreach ($formValue->values['samples'] as $key => $sample)
                                "{{ isset($sample['point']) ? $sample['point'] : '' }} - pH {{ isset($formValue->svgs[$key]['ph']) ? number_format($formValue->svgs[$key]['ph'], $formPrint->places['ph'], ',', '.') : '' }} e EH {{ isset($formValue->svgs[$key]['eh']) ? number_format($formValue->svgs[$key]['eh'], $formPrint->places['eh'], ',', '.') : '' }}",
                            @endforeach
                        @endif
                    ],
                    label: '',
                    data: [
                        @if (isset($formValue->values['samples'] ))
                            @foreach ($formValue->values['samples'] as $key => $sample)
                                {
                                    x: {{ isset($formValue->svgs[$key]['eh']) ? $formValue->svgs[$key]['eh'] : 0 }},
                                    y: {{ isset($formValue->svgs[$key]['ph']) ? $formValue->svgs[$key]['ph'] : 0 }}
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
                        customCanvasBackgroundColor: {
                            color: 'lightGreen',
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

                    ctx.fillStyle = '#ffff';
                    ctx.fillRect(0, 0, chart.width, chart.height);

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
            window.myChart = myChart;

        }

</script>

<script>
    document.getElementById("filter_default").addEventListener("click", function(e) {
        e.preventDefault();
        this.classList.add("border-green-900");
        this.classList.add("active");
        document.getElementById("filter_duplicate").classList.remove("border-green-900");
        document.getElementById("filter_duplicate").classList.remove("active");

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
        this.classList.add("active");
        document.getElementById("filter_default").classList.remove("border-green-900");
        document.getElementById("filter_default").classList.remove("active");

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

        document.querySelectorAll("#mode_sample_char").forEach(item => {
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

        document.querySelectorAll("#mode_sample_char").forEach(item => {
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

        document.querySelectorAll("#mode_sample_char").forEach(item => {
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

        document.querySelectorAll("#mode_sample_char").forEach(item => {
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

        document.querySelectorAll("#mode_sample_char").forEach(item => {
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

        document.querySelectorAll("#mode_sample_char").forEach(item => {
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
    document.querySelectorAll("#mode_list_count, #mode_list_filter").forEach( item => {
        item.addEventListener("change", function(e) {
            filterModeList(this.value);
        });
    });

    function filterModeList() {
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let count = document.querySelector("#mode_list_count").value;
        let url = "{!! route('fields.form-values.get-sample-list', ['form_value' => '#', 'count' => '?']) !!}".replace('#', form_value_id).replace('?', count);
        let type = document.querySelector("#filter_samples .active").dataset.status;
        let mode_list_filter = document.querySelector("#mode_list_filter").value;

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                document.getElementById("sample_list_container").innerHTML = resp.viwer;
                document.getElementById("spin_load").classList.add("hidden");

            } else if (this.readyState == 4 && this.status != 200) {
                document.getElementById("spin_load").classList.add("hidden");
                toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('id', form_value_id);
        data.append('count', count);
        data.append('type', type);
        data.append('mode_list_filter', mode_list_filter);

        ajax.send(data);
    }

    document.getElementById("mode_chart_count").addEventListener("change", function() {
        filterModeChart(this.value);
    });

    document.getElementById("filter_duplicate").addEventListener("click", function() {
        filterModeChart(document.getElementById("mode_chart_count").value);
        filterModeList(document.getElementById("mode_list_count").value);
    });

    document.getElementById("filter_default").addEventListener("click", function() {
        filterModeChart(document.getElementById("mode_chart_count").value);
        filterModeList(document.getElementById("mode_list_count").value);
    });

    function filterModeChart(count) {
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let type = document.querySelector("#filter_samples .active").dataset.status;
        let url = "{!! route('fields.form-values.get-sample-chart', ['form_value' => '#', 'count' => '?']) !!}".replace('#', form_value_id).replace('?', count);

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                document.getElementById("sample_chart_list").innerHTML = resp.viwer;
                document.getElementById("spin_load").classList.add("hidden");

                window.myChart.data.labels.splice(0,  window.myChart.data.labels.length);
                window.myChart.data.datasets.forEach((dataset) => {
                    dataset.data.splice(0,  dataset.data.length);
                    dataset.labels.splice(0,  dataset.labels.length);
                });

                window.myChart.update();

                const samples = resp.samples;
                const svgs = resp.svgs;
                Object.keys(samples).forEach(key => {
                    window.myChart.data.datasets.forEach((dataset) => {
                        dataset.data.push(
                        {
                            x: svgs[key]['eh'],
                            y: svgs[key]['ph'],
                        },);
                        dataset.labels.push(`${samples[key]['point']} - pH ${svgs[key]['ph_formatted']} e EH ${svgs[key]['eh_formatted']}`);
                    });

                });

                window.myChart.update();

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
        data.append('type', type);

        ajax.send(data);
    }
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
        let url = "{!! route('fields.form-values.save-coordinate') !!}";
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
            document.querySelectorAll(`#${this.dataset.index} input, #${this.dataset.index} select`).forEach(item => {
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

    function saveSample(that, noReaload = false) {
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.form-values.save-sample') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let sample_index = document.querySelector(`#${that.dataset.index} #sample_index_${that.dataset.row}`).value;
        let equipment = document.querySelector(`#${that.dataset.index} #equipment_${that.dataset.row}`).value;
        let turbidity_equipment = document.querySelector(`#${that.dataset.index} #turbidity_equipment_${that.dataset.row}`).value;
        let chlorine_equipment = document.querySelector(`#${that.dataset.index} #chlorine_equipment_${that.dataset.row}`).value;
        let voc_equipment = document.querySelector(`#${that.dataset.index} #voc_equipment_${that.dataset.row}`).value;
        let orp_equipment = document.querySelector(`#${that.dataset.index} #orp_equipment_${that.dataset.row}`).value;
        let point = document.querySelector(`#${that.dataset.index} #point_${that.dataset.row}`).value;
        let environment = document.querySelector(`#${that.dataset.index} #environment_${that.dataset.row}`).value;
        let collect = document.querySelector(`#${that.dataset.index} #collect_${that.dataset.row}`).value;

        const results = [...document.querySelectorAll(`#${that.dataset.index} #table_result input, #${that.dataset.index} #table_result select`)];
        const footer = [...document.querySelectorAll(`#${that.dataset.index} #table_result_footer input, #${that.dataset.index} #table_result_footer select`)];

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                document.getElementById("spin_load").classList.add("hidden");

                toastr.success(resp.message);

                const status = document.querySelector("#filter_samples a.active").dataset.status;
                const url = new URL(window.location.href);

                if(status == 'duplicates'){
                    url.searchParams.set('filter_duplicate', 1);
                    if (!noReaload) window.location.href = `${url.href}`;
                } else {
                    if (!noReaload) location.reload();
                }

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
        data.append('turbidity_equipment', turbidity_equipment);
        data.append('chlorine_equipment', chlorine_equipment);
        data.append('voc_equipment', voc_equipment);
        data.append('orp_equipment', orp_equipment);
        data.append('point', point);
        data.append('environment', environment);
        data.append('collect', collect);

        results.forEach(element => {
            data.append(element.name, element.value);
        });

        footer.forEach(element => {
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

    function deleteResult(that) {
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.form-values.delete-result') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let sample_index = that.dataset.index;
        let index = that.dataset.row;

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
        data.append('index', index);

        ajax.send(data);
    }

    function deleteCoordinate(that) {
        document.getElementById("spin_load").classList.remove("hidden");
        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.form-values.delete-coordinate') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let coordinate_index = that.dataset.row;

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                toastr.success(resp.message);
                document.getElementById("spin_load").classList.add("hidden");
                document.querySelector(`#table_coordinates tr[data-row='${coordinate_index}']`).remove();
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
        data.append('coordinate_index', coordinate_index);

        ajax.send(data);
    }

</script>

<script>
    document.getElementById("confirm_environment_modal").addEventListener("click", function() {
        var countSamples = 0;
        var samples = "";

        document.querySelectorAll("input.collect").forEach(item => {
            var date = new Date(item.value);
            date = new Date(date.getFullYear(), date.getMonth(), date.getDate())

            const  [yearStart, monthStart, dayStart] = document.getElementById("date_start").value.split("-");
            const  [yearEnd, monthEnd, dayEnd] = document.getElementById("date_end").value.split("-");

            const start = new Date(yearStart, monthStart - 1, dayStart);
            const end = new Date(yearEnd, monthEnd - 1, dayEnd);

            const environmentValue = document.getElementById("environment_value");
            const environment = document.getElementById(`environment_${item.dataset.index}`);

            console.log(date);
            console.log(start);
            console.log(end);

            if(date >= start && date <= end) {
                environment.value = environmentValue.value;
                saveSample(document.querySelector(`.save-sample[data-index='sample_${item.dataset.index}']`), true);
                countSamples++;
                samples += `<p>Amostra ${item.dataset.index + 1}</p>`;
            }
        });

        if(countSamples == 0) {
            toastr.error("Nenhuma amostra encontrada com as datas informadas.");
        } else {
            samples += countSamples > 1 ? "<p>Foram atualizadas</p>" : "<p>Foi atualizada</p>";
            toastr.success(samples);
        }

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

    document.querySelectorAll(".add-results, .add-coordinates").forEach(item => {
        item.addEventListener("click", function() {
            var modal = document.getElementById("add_results_modal");
            modal.classList.remove("hidden");
            modal.classList.add("block");
            document.querySelector("#confirm_add_results_modal").dataset.index = item.dataset.index;
            document.querySelector("#confirm_add_results_modal").dataset.row = item.dataset.row;
        });
    });

    document.querySelector("#confirm_add_results_modal").addEventListener("click", function() {
        document.getElementById("spin_load").classList.remove("hidden");

        let that = this;
        let ajax = new XMLHttpRequest();
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;
        let sample_index = document.querySelector(`#${that.dataset.index} #sample_index_${that.dataset.row}`) ?
        document.querySelector(`#${that.dataset.index} #sample_index_${that.dataset.row}`).value : null;
        let amount = document.querySelector(`#add_results_modal #amount`).value;
        let url = sample_index ? "{!! route('fields.form-values.import.add-results') !!}" : "{!! route('fields.form-values.import.add-coordinates') !!}";

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                toastr.success(resp.message);
                location.reload();
            } else if (this.readyState == 4 && this.status != 200) {
                toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('form_value_id', form_value_id);
        data.append('sample_index', sample_index);
        data.append('amount', amount);

        ajax.send(data);
    });

    document.getElementById("help").addEventListener("click", function() {
        var modal = document.getElementById("modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

    document.getElementById("signer_document").addEventListener("click", function(e) {
        e.preventDefault();
        var modal = document.getElementById("signer_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");

        document.getElementById("confirm_signer_modal").addEventListener("click", function() {
            let that = this;
            let ajax = new XMLHttpRequest();
            let url = "{!! route('fields.form-values.signed') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let form_value_id = document.querySelector(`#form_value_id`).value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);
                   if(resp.signed) {
                    var modalSigner = document.getElementById("signer_modal");
                    modalSigner.classList.add("hidden");
                    modalSigner.classList.remove("block");

                    var modalRev = document.getElementById("rev_modal");
                    modalRev.classList.remove("hidden");
                    modalRev.classList.add("block");
                   } else {
                    var url = `@if($formValue) {{ route('fields.form-values.signer', ['form_value' => $formValue->id, 'project_id' => isset($formValue) ? $formValue->values['project_id'] : '' . ".pdf"]) }} @endif`;
                    window.open(url, '_blank').focus();
                   }
                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('form_value_id', form_value_id);

            ajax.send(data);
        });

        document.getElementById("confirm_rev_modal").addEventListener("click", function() {
            let ajax = new XMLHttpRequest();
            let url = "{!! route('fields.form-values.rev') !!}";
            let token = document.querySelector('meta[name="csrf-token"]').content;
            let method = 'POST';
            let form_value_id = document.querySelector(`#form_value_id`).value;
            let reason = document.getElementById("reason").value;

            ajax.open(method, url);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var resp = JSON.parse(ajax.response);

                    var modalRev = document.getElementById("rev_modal");
                    modalRev.classList.add("hidden");
                    modalRev.classList.remove("block");

                    var url = `@if($formValue) {{ route('fields.form-values.signer', ['form_value' => $formValue->id, 'project_id' => isset($formValue) ? $formValue->values['project_id'] : '' . ".pdf"]) }} @endif`;
                    url = url + `?rev_id=${resp.form_rev.id}`;
                    window.open(url, '_blank').focus();
                } else if (this.readyState == 4 && this.status != 200) {
                    toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
                }
            }

            var data = new FormData();
            data.append('_token', token);
            data.append('_method', method);
            data.append('form_value_id', form_value_id);
            data.append('reason', reason);

            ajax.send(data);
        });
    });

    document.getElementById("cancel_rev_modal").addEventListener("click", function() {
        var modal = document.getElementById("rev_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
    });

    document.getElementById("cancel_add_results_modal").addEventListener("click", function() {
        var modal = document.getElementById("add_results_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
    });

    document.getElementById("cancel_signer_modal").addEventListener("click", function() {
        var modal = document.getElementById("signer_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
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
            document.querySelector("#confirm_delete_modal").dataset.type = "sample";
        });
    });

    document.querySelectorAll(".remove-result").forEach(item => {
        item.addEventListener("click", function() {
            var modal = document.getElementById("delete_modal");
            modal.classList.remove("hidden");
            modal.classList.add("block");
            document.querySelector("#confirm_delete_modal").dataset.index = this.dataset.index;
            document.querySelector("#confirm_delete_modal").dataset.row = this.dataset.row;
            document.querySelector("#confirm_delete_modal").dataset.type = "result";
        });
    });

    document.querySelectorAll(".remove-coordinate").forEach(item => {
        item.addEventListener("click", function() {
            var modal = document.getElementById("delete_modal");
            modal.classList.remove("hidden");
            modal.classList.add("block");
            document.querySelector("#confirm_delete_modal").dataset.row = this.dataset.row;
            document.querySelector("#confirm_delete_modal").dataset.type = "coordinate";
        });
    });

    document.querySelector("#confirm_delete_modal").addEventListener("click", function() {
        if(this.dataset.type == "sample") deleteSample(this);
        if(this.dataset.type == "result") deleteResult(this);
        if(this.dataset.type == "coordinate") {
            deleteCoordinate(this);
            var modal = document.getElementById("delete_modal");
            modal.classList.add("hidden");
            modal.classList.remove("block");
        }
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

    document.getElementById("create_sheet").addEventListener("click", function(e) {
        e.preventDefault();
        uploadChartImage();
    });

    function uploadCoordinates(that) {
        document.getElementById("spin_load").classList.remove("hidden");

        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.form-values.import.coordinates') !!}";
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
        let url = "{!! route('fields.form-values.import.results') !!}";
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
                var resp = JSON.parse(ajax.response);
                document.getElementById("spin_load").classList.add("hidden");
                toastr.error(resp.message);
                that.value = '';
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('file', files[0]);
        data.append('form_value_id', form_value_id);
        data.append('sample_index', sample_index);

        ajax.send(data);
    }

    function uploadSamples(that) {
        document.getElementById("spin_load").classList.remove("hidden");

        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.form-values.import.samples') !!}";
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
        for (let index = 0; index < files.length; index++) {
            const file = files[index];
            data.append('file[]', file);
        }
        data.append('form_value_id', form_value_id);

        ajax.send(data);
    }

    function uploadChartImage() {
        document.getElementById("spin_load").classList.remove("hidden");

        let image = document.querySelector("#myChart2").toDataURL('image/png');

        let ajax = new XMLHttpRequest();
        let url = "{!! route('fields.form-values.upload-chart-image') !!}";
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let form_value_id = document.querySelector(`#form_value_id`).value;

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("spin_load").classList.add("hidden");
                window.open("@if($formValue){{ route('fields.form-values.create-sheet', ['form_value' => $formValue->id]) }}@endif", '_blank').focus();

            } else if (this.readyState == 4 && this.status != 200) {
                document.getElementById("spin_load").classList.add("hidden");
                toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('image', image);
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
            document.querySelector("#confirm_delete_modal").dataset.row = this.dataset.row;
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

<script>
    document.getElementById("search_sample").addEventListener("click", function(e) {
        e.preventDefault();
        seachSample();
    });

    function seachSample() {
        $q = document.querySelector("#search_container #q").value;

        document.querySelectorAll("#mode_table .sample").forEach(item => {
            if(!item.querySelector(".point").value.toUpperCase().includes($q.toUpperCase())) item.style.display = "none";
            if(item.querySelector(".point").value.toUpperCase().includes($q.toUpperCase())) item.style.display = "flex";
            if($q == '') item.style.display = "flex";
        });
    }

    document.querySelector("#search_container #q").addEventListener("keypress", function(e) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search_sample").click();
        }
    });

    document.querySelector("#search_container #q").addEventListener("keyup", function(e) {
        seachSample();
    });


    function setTurbidity() {
        if(document.getElementById("turbidity")) {
            const checked = document.getElementById("turbidity").checked;
            if(checked) {
                document.querySelectorAll(".turbidity-equipment").forEach(item => {
                    item.classList.remove("hidden");
                });
            }else {
                document.querySelectorAll(".turbidity-equipment").forEach(item => {
                    item.classList.add("hidden");
                });
            }
        }
    }

    setTurbidity();
    if(document.getElementById("turbidity")) {
        document.querySelector("#turbidity").addEventListener("click", function() {
            setTurbidity();
        });
    }
</script>
