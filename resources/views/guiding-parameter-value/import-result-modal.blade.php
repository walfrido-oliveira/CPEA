<!-- Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto block" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="import_result_modal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
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
                {{ __('Resultado da Importação') }}
              </h3>
              <div class="flex flex-col mt-4">
                <table id="import_result_table" class="table table-responsive md:table w-full">
                    <thead>
                        <tr class="thead-light">
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Param. Orietador Ambiental') }}</th>
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Matriz') }}</th>
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Param. Análise') }}</th>
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Ref. Param. Valor Orientador') }}</th>
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tipo Valor Orientador') }} </th>
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Unidade Legislação') }} </th>
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Unidade LegisAnáliselação') }} </th>
                            <th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($imports as $item)
                            <tr>
                                <td>{{ $item->gruidingParameter }}</td>
                                <td>{{ $item->analysisMatrix }}</td>
                                <td>{{ $item->parameterAnalysis }}</td>
                                <td>{{ $item->guidingParameterRefValue }}</td>
                                <td>{{ $item->guidingValue }}</td>
                                <td>{{ $item->unityLegislation }}</td>
                                <td>{{ $item->unityAnalysis }}</td>
                                <td>
                                    @switch($item->status)
                                        @case('found')
                                            <svg xmlns="http://www.w3.org/2000/svg" title="{{ __('Importado') }}" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            @break
                                        @case('not_found')
                                            <svg xmlns="http://www.w3.org/2000/svg" title="{{ __('Não importado') }}" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                                            </svg>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                <button type="button" id="import_result_confirm_modal" class="w-full inline-flex justify-center btn-transition-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        </div>
      </div>
    </div>
</div>

<script>

</script>
