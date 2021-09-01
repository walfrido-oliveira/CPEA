<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="utm" value="{{ __('Coordenadas UTM') }}" />
        <x-jet-input id="utm" class="form-control block mt-1 w-full" type="text" name="utm" maxlength="255" required autofocus autocomplete="utm" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="temperature" value="{{ __('Temperatura') }}" />
        <x-jet-input id="temperature" class="form-control block mt-1 w-full" type="number" name="temperature" maxlength="18" step="any" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="humidity" value="{{ __('Umidade') }}" />
        <x-jet-input id="humidity" class="form-control block mt-1 w-full" type="number" name="humidity" maxlength="18" step="any" data-type="campaign-fields"/>
    </div>
</div>
<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="pressure" value="{{ __('Pressão') }}" />
        <x-jet-input id="pressure" class="form-control block mt-1 w-full" type="number" name="pressure" maxlength="18" step="any" data-type="campaign-fields"/>
    </div>
</div>
