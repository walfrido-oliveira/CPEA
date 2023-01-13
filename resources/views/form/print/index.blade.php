@php $customer = App\Models\Customer::find($formValue->values['client']); @endphp
@php $user = App\Models\User::find($formValue->values["responsible"]); @endphp
@php $d = 0; @endphp

@php
    $parameters = [
        "conc" => "OD",
        "orp" => "ORP",
        "ph" => "pH",
        "conductivity" => "Condutividade",
        "salinity" => "Salinidade",
        "temperature" => "Temperatura",
    ];

    $unities = [
        "temperature" => "°C",
        "ph" => "-",
        "orp" => "mV",
        "conductivity" => "µS/cm",
        "salinity" => "-",
        "conc" => "mg/L"
    ];

    $LQ = [
        "temperature" => "-",
        "ph" => "-",
        "orp" => "-",
        "conductivity" => "20",
        "salinity" => "0,01",
        "conc" => "0,3"
    ];

    $places = [
        "temperature" => 2,
        "ph" => 2,
        "orp" => 1,
        "conductivity" => 3,
        "salinity" => 3,
        "conc" => 3
    ];

    $range = [
        "temperature" => "4 a 40",
        "ph" => "1 a 13",
        "orp" => "-1400 a +1400",
        "conductivity" => "-",
        "salinity" => "-",
        "conc" => "-"
    ];
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
	@include('form.print.styles')
</head>

<body>
    <header>
        <table>
            <tr>
              <td style="text-align: left; vertical-align: middle;">
                <img src="data:image/png;base64, {{ $logo }}" width="155" height="86">
              </td>
              <td colspan="2" style="text-align: center; vertical-align: middle;" id="text">
              </td>
              <td style="text-align: right; vertical-align: middle;">
                <img src="data:image/png;base64, {{ $crl }}" width="74" height="112" >
              </td>
            </tr>
        </table>
    </header>

    <footer>
    </footer>

     <main>
        <div class="report-title">
            <h1>Relatório de Ensaios de Campo</h1>
            <h2>{{ $formValue->values["project_id"] }}</h2>
            <p>{{ $formValue->form->name }} Versão {{ $formValue->values["doc_version"] }}</p>
        </div>
        <div id="customer">
            <table>
                <tr>
                    <td style="padding-right: 40px;">Interessado: </td>
                    <td>{{ $customer->name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>{!! $customer->getFullAdress() !!}</td>
                </tr>
            </table>
        </div>
        <div id="refs">
            <h3>Referências Utilizadas</h3>
            <div class="refs-external-values">
                <p class="title"><b>Referências externas</b></p>
                @foreach (App\Models\Ref::where('field_type_id',
                App\Models\FieldType::where('name', 'Água Subterrânea por Baixa Vazão')->first()->id)->where("type", "Referência Externa")->get() as $ref)
                    <p class="content"><b>{{ $ref->name }}:</b> {{ $ref->desc }}</p>
                @endforeach
            </div>
            <div class="refs-values">
                <p class="title"><b>Referências</b></p>
                @foreach (App\Models\Ref::where('field_type_id',
                App\Models\FieldType::where('name', 'Água Subterrânea por Baixa Vazão')->first()->id)->where("type", "Referências")->get() as $ref)
                    <p class="content"><b>{{ $ref->name }}:</b> {{ $ref->desc }}</p>
                @endforeach
            </div>
        </div>
        <div class="footer">
           {!! $footer !!}
        </div>
        <p style="page-break-after: always;"></p>
        @include('form.print.sub-header')
        <div id="results">
            @foreach (array_chunk($formValue->values['samples'], 4, true) as $samples)
                <h3>Resultados de Parâmetros Físico-Químicos</h3>
                <h4>RELATÓRIO - {{ $formValue->values["project_id"] }} </h4>
                @foreach ($samples as $key => $sample)
                    <div class="table-container">
                        <table class="first">
                            <thead>
                                <tr>
                                    <th>Amostra</th>
                                    <th>Data de Coleta</th>
                                    <th>Hora</th>
                                    <th>Condições Ambientais</th>
                                    <th>Matriz</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @if(isset($sample['point'])) {{ $sample['point'] }} @endif
                                    </td>
                                    <td>
                                        @if(isset($sample['collect']))  {{ Carbon\Carbon::parse($sample['collect'])->format("d/m/Y") }} @endif
                                    </td>
                                    <td>
                                        @if(isset($sample['collect'])) {{ Carbon\Carbon::parse($sample['collect'])->format("h:i") }} @endif
                                    </td>
                                    <td>
                                        @if(isset($sample['environment'])) {{ $sample['environment'] }} @endif
                                    </td>
                                    <td>
                                        {{ $formValue->form->fieldType->name }}
                                    </td>
                                <tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="border-bottom: 0px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="border-top: 0px; border-bottom: 0px;">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                        <table class="second">
                            <thead>
                                <tr>
                                    <th style="text-align: center; border-top: 1px #000 solid; border-bottom: 1px #000 solid; border-right: 0px;">Parâmetro</th>
                                    <th style="text-align: center; border-top: 1px #000 solid; border-bottom: 1px #000 solid; border-right: 0px; border-left: 0px;">Unidade</th>
                                    <th style="text-align: center; border-top: 1px #000 solid; border-bottom: 1px #000 solid; border-right: 0px; border-left: 0px;">Resultado</th>
                                    <th style="text-align: center; border-top: 1px #000 solid; border-bottom: 1px #000 solid; border-right: 0px; border-left: 0px;">LQ</th>
                                    <th style="text-align: center; border-top: 1px #000 solid; border-bottom: 1px #000 solid; border-left: 0px;">Faixa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parameters as $key2 => $value)
                                    <tr>
                                        <td style="text-align: left; border: 0px; border-left: 1px double grey;">
                                            {{ $value }}
                                        </td>
                                        <td style="text-align: center; border: 0px;">
                                            {{ $unities[$key2] }}
                                        </td>
                                        <td style="text-align: center; border: 0px;">
                                            {{ number_format($svgs[$key][$key2], $places[$key2], ",", ".") }}
                                        </td>
                                        <td style="text-align: center; border: 0px;">
                                            {{ $LQ[$key2] }}
                                        </td>
                                        <td style="text-align: center; border: 0px; border-right: 1px double grey;">
                                            {{ $range[$key2] }}
                                        </td>
                                    <tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
                <p style="page-break-after: always;"></p>
                @include('form.print.sub-header')
            @endforeach
        </div>
        <div id="coordinates">
            @foreach (array_chunk($formValue->values['coordinates'], 40, true) as $coordinates)
                <h3>Localização dos pontos de amostragem - Tabela de coordenadas</h3>
                <h4>RELATÓRIO - {{ $formValue->values["project_id"] }} </h4>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th rowspan="2" style="vertical-align: middle; background-color: #D9D9D9; border-color: #000;">
                                    {{ __('identificação do Ponto') }}
                                </th>
                                <th rowspan="2" style="vertical-align: middle; background-color: #D9D9D9; border-color: #000;">
                                    {{ __('Zona') }}
                                </th>
                                <th colspan="2" style="text-align: center; background-color: #D9D9D9; border-color: #000;">
                                    {{ __('Coordenadas UTM') }}
                                </th>
                            </tr>
                            <tr>
                                <th style="background-color: #D9D9D9; border-color: #000;">
                                    {{ __('Eastings (mE)') }}
                                </th>
                                <th style="background-color: #D9D9D9; border-color: #000;">
                                    {{ __('Northings (mN)') }}
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($coordinates as $key => $coordinate)
                                <tr>
                                    <td>
                                        {{ isset($coordinate['point']) ? $coordinate['point'] : '' }}
                                    </td>
                                    <td>
                                        {{ isset($coordinate['zone']) ? $coordinate['zone'] : '' }}
                                    </td>
                                    <td>
                                        {{ isset($coordinate['me']) ? $coordinate['me'] : '' }}
                                    </td>
                                    <td>
                                        {{ isset($coordinate['mn']) ? $coordinate['mn'] : '' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($loop->last)
                    <p class="coordinates-footer">Coordenadas referenciadas ao datum horizontal SIRGAS-2000</p>
                @endif
                <p style="page-break-after: always;">
                @include('form.print.sub-header')
            @endforeach
        </div>

        <div id="infos">
            <h3>Informações Adicionais</h3>
            <h4>RELATÓRIO - {{ $formValue->values["project_id"] }} </h4>
            <div class="additional-info">
                {!! $formValue->values["additional_info"] !!}
            </div>
            <div class="approval-text-container">
                <p><b>Aprovação do Relatório</b></p>
                <div class="additional-info">
                    {!! $formValue->values["approval_text"] !!}
                </div>
            </div>
        </div>

        <div id="signer">
            <img src="data:image/png;base64, {{ $signer }}" width="70" height="70">
            <p class="user">Responsável(a) Técnico(a)</p>
            <p class="user-name">{{ $user->full_name }}</p>
            <p class="user-crq">CRQ IV: {{ $user->crq }}</p>
        </div>

        <p class="report-date">Relatório de ensaio emitido na data de {{ Carbon\Carbon::now()->format("d/m/Y")}}</p>
        <!-- <p style="page-break-after: always;">
        </p>
        <p style="page-break-after: never;">
        </p> -->
    </main>
</body>

</html>
