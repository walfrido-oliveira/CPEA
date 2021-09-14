<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="identification_pm" value="{{ __('Identificação do PM') }}" />
        <x-jet-input id="identification_pm" class="form-control block mt-1 w-full" type="text" name="identification_pm" maxlength="255"  autofocus autocomplete="identification_pm" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="pm_depth" value="{{ __('Profundidade do PM') }}" />
        <x-jet-input id="pm_depth" class="form-control block mt-1 w-full" type="number" name="pm_depth" maxlength="18" step="any" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="pm_diameter" value="{{ __('Diâmetro do PM') }}" />
        <x-jet-input id="pm_diameter" class="form-control block mt-1 w-full" type="number" name="pm_diameter" maxlength="18" step="any" data-type="campaign-fields"/>
    </div>
</div>
<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="water_level" value="{{ __('Nível dágua') }}" />
        <x-jet-input id="water_level" class="form-control block mt-1 w-full" type="number" name="water_level" maxlength="18" step="any" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="oil_level" value="{{ __('Nível de óleo') }}" />
        <x-jet-input id="oil_level" class="form-control block mt-1 w-full" type="number" name="oil_level" maxlength="18" step="any" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="environmental_conditions" value="{{ __('Condições ambientais') }}" />
        <x-custom-select :options="$environmentalConditions" name="environmental_conditions" id="environmental_conditions" value="" class="mt-1" no-filter="no-filter" data-type="campaign-fields"/>
    </div>
</div>
<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="utm" value="{{ __('Coordenadas UTM') }}" />
        <x-jet-input id="utm" class="form-control block mt-1 w-full" type="text" name="utm" maxlength="255"  autofocus autocomplete="utm" data-type="campaign-fields"/>
    </div>
</div>
