<div class="w-full px-3 mt-4 mb-6 md:mb-0 flex flex-wrap sample" id="sample_{{ isset($i) ? $i + 1 : 1 }}" data-index="1">
    <div class="flex w-full">
        <h3 class="w-full mt-4 mb-6 md:mb-0 title">AMOSTRA <span>{{ isset($i) ? $i + 1 : 1 }}</span></h3>
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 flex justify-end">
            <button class="add-sample btn-transition-primary" type="button" title="Adicionar Amostra" style="{{ !$formValue ? '' : 'display: none'}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-900" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            <button type="button" class="btn-transition-primary remove-sample" title="Remover Amostra" style="display: none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-red-900">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
    </div>
    <div class="flex flex-wrap mt-2 w-full">
        <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
            <x-jet-label for="equipment" value="{{ __('Equipamento') }}" />
            @if(isset($formValue))
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="equipment" class="form-control block mt-1 w-full"
                type="text" value="{{ isset($i) ? $formValue->values['samples']['row_' . $i + 1]['equipment'] : $formValue->values['samples']['row_1']['equipment'] }}"
                name="{{ isset($i) ? 'samples[row_' . $i + 1 . '][equipment]' : 'samples[row_1][equipment]' }}" maxlength="255" />
            @else
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="equipment" class="form-control block mt-1 w-full"
                type="text" value=""
                name="samples[row_1][equipment]" maxlength="255" />
            @endif
        </div>
        <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
            <x-jet-label for="point" value="{{ __('Ponto de Coleta') }}" />
            @if(isset($formValue))
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="point" class="form-control block mt-1 w-full"
                type="text" value="{{ isset($i) ? $formValue->values['samples']['row_' . $i + 1]['point'] : $formValue->values['samples']['row_1']['point'] }}"
                name="{{ isset($i) ? 'samples[row_' . $i + 1 . '][point]' : 'samples[row_1][point]' }}" maxlength="255" />
            @else
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="point" class="form-control block mt-1 w-full"
                type="text" value=""
                name="samples[row_1][point]" maxlength="255" />
            @endif
        </div>
    </div>
    <div class="flex flex-wrap mt-2 w-full">
        <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
            <x-jet-label for="environment" value="{{ __('Condições ambientais nas últimas 24 hs') }}" />
            @if(isset($formValue))
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="environment" class="form-control block mt-1 w-full"
                type="text" value="{{ isset($i) ? $formValue->values['samples']['row_' . $i + 1]['environment'] : $formValue->values['samples']['row_1']['environment'] }}"
                name="{{ isset($i) ? 'samples[row_' . $i + 1 . '][environment]' : 'samples[row_1][environment]' }}" maxlength="255" />
            @else
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="environment" class="form-control block mt-1 w-full"
                type="text" value=""
                name="samples[row_1][environment]" maxlength="255" />
            @endif
        </div>
        <div class="w-full md:w-1/2 pr-3 mb-6 md:mb-0">
            <x-jet-label for="collect" value="{{ __('DT/HR da Coleta') }}" />
            @if(isset($formValue))
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="collect" class="form-control block mt-1 w-full"
                type="datetime-local" value="{{ isset($i) ? $formValue->values['samples']['row_' . $i + 1]['collect'] : $formValue->values['samples']['row_1']['collect'] }}"
                name="{{ isset($i) ? 'samples[row_' . $i + 1 . '][collect]' : 'samples[row_1][collect]' }}" maxlength="255" />
            @else
                <x-jet-input disabled="{{ !$formValue ? false : true}}" id="collect" class="form-control block mt-1 w-full"
                type="text" value=""
                name="samples[row_1][collect]" maxlength="255" />
            @endif
        </div>
    </div>
</div>
