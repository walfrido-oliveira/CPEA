<!-- Modal -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<div class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="guiding_parameter_order_modal" data-url="">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 sm:ml-4 " id="modal-title">
                {{ __('Ordem do Param. Orientador Ambiental') }}
              </h3>
              <div class="mt-2">
                <form method="POST" id="guiding_parameter_order_form" action="{{ route('project.update-order', ['project' => $project->id]) }}">
                    <input type="hidden" name="order" id="order">
                    @csrf
                    @method("POST")

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                          <tr>
                            <th scope="col">
                            </th>
                          </tr>
                        </thead>
                        <tbody class="bg-white cursor-move" id="list_item" style="border:0px">

                        </tbody>
                    </table>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="guiding_parameter_order_confirm_modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Confirmar') }}
          </button>
          <button type="button" id="guiding_parameter_order_cancel_modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Cancelar') }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const listItem = document.getElementById('list_item');

    new Sortable(listItem, {
        animation: 350,
        chosenClass: "sortable-chosen",
        dragClass: "sortable-drag"
    });
  </script>

  <script>
    document.getElementById("guiding_parameter_order").addEventListener("click", function() {
        var modal = document.getElementById("guiding_parameter_order_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
        getGuidingParamets();
    });

    function close() {
        var modal = document.getElementById("guiding_parameter_order_modal");
        modal.classList.add("hidden");
        modal.classList.remove("block");
    }

    document.getElementById("guiding_parameter_order_cancel_modal").addEventListener("click", function(e) {
        close();
    });

    document.getElementById("guiding_parameter_order").addEventListener("click", function() {
        var modal = document.getElementById("guiding_parameter_order_modal");
        modal.classList.remove("hidden");
        modal.classList.add("block");
    });

    function getGuidingParamets() {
        var url = "{{ route('project.get-order', ['project' => $project->id]) }}";
        var token = document.querySelector('meta[name="csrf-token"]').content;
        var method = "POST";
        var ajax = new XMLHttpRequest();

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                document.getElementById("list_item").innerHTML = resp.guiding_parameters;
            } else if (this.readyState == 4 && this.status != 200) {
                var resp = JSON.parse(ajax.response);
                var obj = resp;
                for (var key in obj){
                    var value = obj[key];
                    toastr.error("<br>" + value);
                }
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('id', "{{ $project->id }}")

        ajax.send(data);
    }

    document.getElementById("guiding_parameter_order_confirm_modal").addEventListener("click", function() {
        var url = document.querySelector("#guiding_parameter_order_form").action;
        var token = document.querySelector('meta[name="csrf-token"]').content;
        var method = document.querySelector("#guiding_parameter_order_form").method;
        var ajax = new XMLHttpRequest();
        var order = [];

        var nodes = Array.prototype.slice.call( document.getElementById('list_item').children);
        nodes.forEach(element => {
            order.push(element.dataset.id);
        });

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resp = JSON.parse(ajax.response);
                toastr.success(resp.message);
                close();
            } else if (this.readyState == 4 && this.status != 200) {
                var resp = JSON.parse(ajax.response);
                var obj = resp;
                for (var key in obj){
                    var value = obj[key];
                    toastr.error("<br>" + value);
                }
            }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        data.append('order', order)

        ajax.send(data);

    });
  </script>
