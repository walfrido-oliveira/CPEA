<!-- Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto block" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="analysis_result_file_modal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 sm:ml-4" id="modal-title">
                {{ __("Lista de importação.") }}
              </h3>
              <div class="flex flex-col mt-4">
                <table id="import_result_table" class="table table-responsive md:table w-full">
                    <thead>
                        <tr class="thead-light">
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Arquivo') }}</th>
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Data') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($analysisResultsFiles as $file)
                            <tr>
                                <td>
                                    <a class="text-item-table inline font-bold text-green-700 underline" href="{{ route('analysis-result-file.download', ['analysis_result_file' => $file->id]) }}" target="_blank">
                                        {{ $file->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $file->created_at->format("d/m/Y H:i") }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="analysis_result_file_confirm_modal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
            {{ __('Fechar') }}
          </button>
        </div>
      </div>
    </div>
</div>

<script>

</script>
