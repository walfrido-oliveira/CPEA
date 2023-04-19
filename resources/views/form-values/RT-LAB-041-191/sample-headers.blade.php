@if(isset($formValue->values["temperature_column"]))<th scope="col"  class="custom-th">{{ __('Temperatura [ºC]') }}</th> @endif
@if(isset($formValue->values["ph_column"]))<th scope="col"  class="custom-th">{{ __('pH') }}</th> @endif
@if(isset($formValue->values["orp_column"]))<th scope="col"  class="custom-th">{{ __('ORP [mV]') }}</th> @endif
@if(isset($formValue->values["conductivity_column"]))<th scope="col"  class="custom-th">{{ __('Condutividade [µS/cm]') }}</th> @endif
@if(isset($formValue->values["salinity_column"]))<th scope="col"  class="custom-th">{{ __('Salinidade [psu]') }}</th> @endif
@if(isset($formValue->values["psi_column"]))<th scope="col"  class="custom-th">{{ __('Press. [psi]') }}</th> @endif
@if(isset($formValue->values["sat_column"]))<th scope="col"  class="custom-th">{{ __('Oxigênio Dissolvido (SAT) [%]') }}</th> @endif
@if(isset($formValue->values["conc_column"]))<th scope="col"  class="custom-th">{{ __('Oxigênio Dissolvido (CONC) [mg/l]') }}</th> @endif
@if(isset($formValue->values["eh_column"]))<th scope="col"  class="custom-th">{{ __('EH [mV]') }}</th> @endif
@if(isset($formValue->values["ntu_column"]))<th scope="col"  class="custom-th">{{ __('Turbidez [NTU]') }}</th> @endif
