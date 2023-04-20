<x-app-layout>
    <div class="py-6 edit-users">
        <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
            <form method="POST" action="{{ route('fields.config.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="flex md:flex-row flex-col">
                    <div class="w-full flex items-center">
                        <h1>{{ __('Configurações de Formulário') }}</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <div class="m-2 ">
                            <button type="submit" class="btn-outline-success">{{ __('Confirmar') }}</button>
                        </div>
                        <div class="m-2">
                            <a href="{{ route('users.index')}}" class="btn-outline-danger">{{ __('Cancelar') }}</a>
                        </div>
                    </div>
                </div>

                <div class="py-2 my-2 bg-white rounded-lg min-h-screen">
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <img src="{{ asset($logo) }}" alt="Logo formulário">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 mt-2">
                            <x-jet-label :value="__('Logo')" for="logo"/>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}"  autocomplete="logo">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <img src="{{ asset($cert) }}" alt="Acreditação formulário">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 mt-2">
                            <x-jet-label :value="__('Selo Acreditação')" for="cert"/>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="cert" type="file" class="form-control @error('cert') is-invalid @enderror" name="cert" value="{{ old('cert') }}"  autocomplete="cert">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Cabeçalho')" for="form_header" required/>
                            <textarea class="form-input w-full ckeditor" name="form_header" id="form_header" cols="30" rows="10" required >{{ $header ? $header : old('form_header')  }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Rodapé Capa')" for="form_footer" required/>
                            <textarea class="form-input w-full ckeditor" name="form_footer" id="form_footer" cols="30" rows="10" required >{{ $footer ? $footer : old('form_footer')  }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Informações adicionais')" for="form_additional_info" required/>
                            <textarea class="form-input w-full ckeditor" name="form_additional_info" id="form_additional_info" cols="30" rows="10" required >{{ $additionalInfo ? $additionalInfo : old('form_additional_info')  }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Aprovação do Relatório')" for="form_approval_text" required/>
                            <textarea class="form-input w-full ckeditor" name="form_approval_text" id="form_approval_text" cols="30" rows="10" required >{{ $approvalText ? $approvalText : old('form_approval_text')  }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Incerteza')" for="form_uncertainty_text" required/>
                            <textarea class="form-input w-full ckeditor" name="form_uncertainty_text" id="form_uncertainty_text" cols="30" rows="10" required >{{ $uncertaintyText ? $uncertaintyText : old('form_uncertainty_text')  }}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Casas Decimais')" class="font-bold"/>
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Temperatura')" for="form_temperature_places" required/>
                            <x-jet-input id="form_temperature_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_temperature_places') }}"
                                         name="form_temperature_places" step="any" />
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('pH')" for="form_ph_places" required/>
                            <x-jet-input id="form_ph_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_ph_places') }}"
                                         name="form_ph_places" step="any" />
                        </div>

                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('ORP')" for="form_orp_places" required/>
                            <x-jet-input id="form_orp_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_orp_places') }}"
                                         name="form_orp_places" step="any" />
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Condutividade')" for="form_conductivity_places" required/>
                            <x-jet-input id="form_conductivity_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_conductivity_places') }}"
                                         name="form_conductivity_places" step="any" />
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Salinidade')" for="form_salinity_places" required/>
                            <x-jet-input id="form_salinity_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_salinity_places') }}"
                                         name="form_salinity_places" step="any" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Press.')" for="form_psi_places" required/>
                            <x-jet-input id="form_psi_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_psi_places') }}"
                                         name="form_psi_places" step="any" />
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Oxigênio Dissolvido (SAT)')" for="form_sat_places" required/>
                            <x-jet-input id="form_sat_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_sat_places') }}"
                                         name="form_sat_places" step="any" />
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Oxigênio Dissolvido (CONC)')" for="form_conc_places" required/>
                            <x-jet-input id="form_conc_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_conc_places') }}"
                                         name="form_conc_places" step="any" />
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('EH')" for="form_eh_places" required/>
                            <x-jet-input id="form_eh_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_eh_places') }}"
                                         name="form_eh_places" step="any" />
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Turbidez')" for="form_ntu_places" required/>
                            <x-jet-input id="form_ntu_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_ntu_places') }}"
                                         name="form_ntu_places" step="any" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Cloro Total')" for="form_chlorine_places" required/>
                            <x-jet-input id="form_chlorine_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_chlorine_places') }}"
                                         name="form_chlorine_places" step="any" />
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Cloro Livre Residual')" for="form_residualchlorine_places" required/>
                            <x-jet-input id="form_residualchlorine_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_residualchlorine_places') }}"
                                         name="form_residualchlorine_places" step="any" />
                        </div>
                        <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('VOC')" for="form_voc_places" required/>
                            <x-jet-input id="form_voc_places" class="form-control block mt-1 w-full" type="number"
                                         value="{{  App\Models\Config::get('form_voc_places') }}"
                                         name="form_voc_places" step="any" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Faixas')" class="font-bold"/>
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Temperatura')" for="form_temperature_range" required/>
                            <x-jet-input id="form_temperature_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_temperature_range') }}"
                                         name="form_temperature_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('pH')" for="form_ph_range" required/>
                            <x-jet-input id="form_ph_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_ph_range') }}"
                                         name="form_ph_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('ORP')" for="form_orp_range" required/>
                            <x-jet-input id="form_orp_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_orp_range') }}"
                                         name="form_orp_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Condutividade')" for="form_conductivity_range" required/>
                            <x-jet-input id="form_conductivity_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_conductivity_range') }}"
                                         name="form_conductivity_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Salinidade')" for="form_salinity_range" required/>
                            <x-jet-input id="form_salinity_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_salinity_range') }}"
                                         name="form_salinity_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Oxigênio Dissolvido')" for="form_conc_range" required/>
                            <x-jet-input id="form_conc_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_conc_range') }}"
                                         name="form_conc_range" step="any" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Turbidez')" for="form_ntu_range" required/>
                            <x-jet-input id="form_ntu_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_ntu_range') }}"
                                         name="form_ntu_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Cloro Total')" for="form_chlorine_range" required/>
                            <x-jet-input id="form_chlorine_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_chlorine_range') }}"
                                         name="form_chlorine_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Cloro Livre Residual')" for="form_residualchlorine_range" required/>
                            <x-jet-input id="form_residualchlorine_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_residualchlorine_range') }}"
                                         name="form_residualchlorine_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Aspecto')" for="form_aspect_range" required/>
                            <x-jet-input id="form_aspect_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_aspect_range') }}"
                                         name="form_aspect_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Corantes Artificiais')" for="form_artificialdyes_range" required/>
                            <x-jet-input id="form_artificialdyes_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_artificialdyes_range') }}"
                                         name="form_artificialdyes_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Materiais Flutuantes')" for="form_floatingmaterials_range" required/>
                            <x-jet-input id="form_floatingmaterials_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_floatingmaterials_range') }}"
                                         name="form_floatingmaterials_range" step="any" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Resíduos Sólidos Objetáveis')" for="form_objectablesolidwaste_range" required/>
                            <x-jet-input id="form_objectablesolidwaste_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_objectablesolidwaste_range') }}"
                                         name="form_objectablesolidwaste_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Óleos e Graxas Visíveis')" for="form_visibleoilsandgreases_range" required/>
                            <x-jet-input id="form_visibleoilsandgreases_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_visibleoilsandgreases_range') }}"
                                         name="form_visibleoilsandgreases_range" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('VOC [ppm]')" for="form_voc_range" required/>
                            <x-jet-input id="form_voc_range" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_voc_range') }}"
                                         name="form_voc_range" step="any" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('LQ')" class="font-bold"/>
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Temperatura')" for="form_temperature_lq" required/>
                            <x-jet-input id="form_temperature_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_temperature_lq') }}"
                                         name="form_temperature_lq" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('pH')" for="form_ph_lq" required/>
                            <x-jet-input id="form_ph_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_ph_lq') }}"
                                         name="form_ph_lq" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('ORP')" for="form_orp_lq" required/>
                            <x-jet-input id="form_orp_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_orp_lq') }}"
                                         name="form_orp_lq" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Condutividade')" for="form_conductivity_lq" required/>
                            <x-jet-input id="form_conductivity_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_conductivity_lq') }}"
                                         name="form_conductivity_lq" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Salinidade')" for="form_salinity_lq" required/>
                            <x-jet-input id="form_salinity_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_salinity_lq') }}"
                                         name="form_salinity_lq" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Oxigênio Dissolvido')" for="form_conc_lq" required/>
                            <x-jet-input id="form_conc_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_conc_lq') }}"
                                         name="form_conc_lq" step="any" />
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-4 px-3 py-2 mt-4">
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Turbidez')" for="form_ntu_lq" required/>
                            <x-jet-input id="form_ntu_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_ntu_lq') }}"
                                         name="form_ntu_lq" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Cloro Total')" for="form_chlorine_lq" required/>
                            <x-jet-input id="form_chlorine_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_chlorine_lq') }}"
                                         name="form_chlorine_lq" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('Cloro Livre Residual')" for="form_residualchlorine_lq" required/>
                            <x-jet-input id="form_residualchlorine_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_residualchlorine_lq') }}"
                                         name="form_residualchlorine_lq" step="any" />
                        </div>
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <x-jet-label :value="__('VOC')" for="form_voc_lq" required/>
                            <x-jet-input id="form_voc_lq" class="form-control block mt-1 w-full" type="text"
                                         value="{{  App\Models\Config::get('form_voc_lq') }}"
                                         name="form_voc_lq" step="any" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
