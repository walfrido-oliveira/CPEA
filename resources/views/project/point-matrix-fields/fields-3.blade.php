<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="report_identification" value="{{ __(' Identificação do laudo') }}" />
        <x-jet-input id="report_identification" class="form-control block mt-1 w-full" type="text" name="report_identification" maxlength="255" required autofocus autocomplete="report_identification" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="sampling_area" value="{{ __('Área de amostragem') }}" />
        <x-jet-input id="sampling_area" class="form-control block mt-1 w-full" type="text" name="sampling_area" maxlength="255" required autofocus autocomplete="sampling_area" data-type="campaign-fields"/>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="organism_type" value="{{ __('Tipo de organismo') }}" />
        <x-jet-input id="organism_type" class="form-control block mt-1 w-full" type="text" name="organism_type" maxlength="255" required autofocus autocomplete="organism_type" data-type="campaign-fields"/>
    </div>
</div>
<div class="flex flex-wrap mx-4 px-3 py-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <x-jet-label for="popular_name" value="{{ __('Nome popular') }}" />
        <x-jet-input id="popular_name" class="form-control block mt-1 w-full" type="text" name="popular_name" maxlength="255" required autofocus autocomplete="popular_name" data-type="campaign-fields"/>
    </div>
</div>
