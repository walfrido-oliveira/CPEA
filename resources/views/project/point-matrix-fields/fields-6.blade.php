<div class="flex flex-wrap py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="sample_horizon" value="{{ __('Horizonte amostrado') }}" />
        <x-jet-input id="sample_horizon" class="form-control block mt-1 w-full" type="text" name="sample_horizon" maxlength="255"  autofocus autocomplete="sample_horizon" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="field_measurements" value="{{ __('Medições realizadas em campo') }}" />
        <x-jet-input id="field_measurements" class="form-control block mt-1 w-full" type="text" name="field_measurements" maxlength="255"  autofocus autocomplete="field_measurements" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="environmental_conditions" value="{{ __('Condições ambientais') }}" />
        <x-custom-select :options="$environmentalConditions" name="environmental_conditions" id="environmental_conditions" value="" class="mt-1" no-filter="no-filter" data-type="campaign-fields"/>
    </div>
</div>
<div class="flex flex-wrap py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="utm" value="{{ __('Coordenadas UTM') }}" />
        <x-jet-input id="utm" class="form-control block mt-1 w-full" type="text" name="utm" maxlength="255"  autofocus autocomplete="utm" data-type="campaign-fields"/>
    </div>
</div>
