<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="refq" value="{{ __('Identificação do REFQ') }}" />
        <x-jet-input id="refq" class="form-control block mt-1 w-full" type="text" name="refq" maxlength="255" required autofocus autocomplete="refq" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="environmental_conditions" value="{{ __('Condições ambientais') }}" />
        <x-custom-select :options="$environmentalConditions" name="environmental_conditions" id="environmental_conditions" value="" class="mt-1" no-filter="no-filter" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="utm" value="{{ __('Coordenadas UTM') }}" />
        <x-jet-input id="utm" class="form-control block mt-1 w-full" type="text" name="utm" maxlength="255" required autofocus autocomplete="utm" data-type="campaign-fields"/>
    </div>
</div>
<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="total_depth" value="{{ __('Profundidade total (m)') }}" />
        <x-jet-input id="total_depth" class="form-control block mt-1 w-full" type="number" name="total_depth" maxlength="18" step="any" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="sample_depth" value="{{ __('Profundidade amostrada') }}" />
        <x-custom-select :options="$sampleDepths" name="sample_depth" id="sample_depth" value="" class="mt-1" no-filter="no-filter" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="sedimentary_layer" value="{{ __('Camada sedimentar (m DHN)') }}" />
        <x-jet-input id="sedimentary_layer" class="form-control block mt-1 w-full" type="text" name="sedimentary_layer" maxlength="255" required autofocus autocomplete="sedimentary_layer" data-type="campaign-fields"/>
    </div>
</div>
<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="environmental_regime" value="{{ __('Regime do ambiente') }}" />
        <x-custom-select :options="$environmentalRegimes" name="environmental_regime" id="environmental_regime" value="" class="mt-1" no-filter="no-filter" data-type="campaign-fields"/>
    </div>
</div>
