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
	<style>
		@page {
			margin: 2cm 1.3cm 2cm 1.3cm;
		}

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            background-color: #fff;
            color: #000;
            text-align: center;
            font-size: 10px;
        }

        footer p {
            margin: 0px;
        }

        main {
            top: 60px;
            margin-top: 10px;
            position: relative;
        }

        h1, h2, h3, h4, p, td, th {
            font-family: 'Helvertica', Tahoma, Geneva, Verdana, sans-serif !important;
            margin: 0px;
        }

        #results table,
        #results td,
        #results th,
        #results tr {
            border: 1px double  grey;
            border-spacing: 0;
        }

        #coordinates table,
        #coordinates td,
        #coordinates th,
        #coordinates tr {
            border: 1px solid #000;
            border-spacing: 0;
            border-collapse: collapse;
        }

        #results th,
        #results td,
        #coordinates th,
        #coordinates td {
            font-size: 6.5pt;
        }

        .additional-info p {
            font-size: 6.5pt ;
            line-height: 20px;
        }
	</style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        <table style="width:100%; table-layout: fixed;">
            <tr>
              <td style="text-align: left; vertical-align: middle;">
                <img src="data:image/png;base64, {{ $logo }}" width="155" height="86">
              </td>
              <td colspan="2" style="text-align: center; vertical-align: middle;" id="text">
                <p style="font-size: 6.5pt; color: #6EBC6E"><b>Consultoria, Planejamento e Estudos Ambientais</b></p>
                <p style="font-size: 6.5pt;">Rua Henrique Monteiro, 90 - 13º andar - Pinheiros - São Paulo / SP - CEP: 05423-020</p>
                <p style="font-size: 6.5pt;">Rua Enguaguaçu, 99 - Ponta da Praia - Santos / SP - CEP: 11035-071</p>
              </td>
              <td style="text-align: right; vertical-align: middle;">
                <img src="data:image/png;base64, {{ $crl }}" width="74" height="112" >
              </td>
            </tr>
        </table>
    </header>

    <footer>
        <p style="font-size: 6.5pt;">Rua Henrique Monteiro, 90 - 13º andar - Pinheiros - São Paulo / SP - CEP: 05423-020 - Tel: (11) 4082-3200</p>
        <p style="font-size: 6.5pt;"> Rua Enguaguaçu, 99 - Ponta da Praia - Santos / SP - CEP: 11035-071 - Tel: (13) 3035-6002</p>
        <p style="font-size: 6.5pt;">cpea@cpeanet.com</p>
        <p style="font-size: 6.5pt;"> www.cpeanet.com.br</p>
    </footer>

     <!-- Wrap the content of your PDF inside a main tag -->
     <main>
        <div style="text-align: center; margin-top: 100px;">
            <h1 style="font-size: 12.5pt;">Relatório de Ensaios de Campo</h1>
            <h2 style="font-size: 12.5pts;">{{ $formValue->values["project_id"] }}</h2>
            <p style="font-size: 6.5pt; line-height: 20px">{{ $formValue->form->name }} Versão {{ $formValue->values["doc_version"] }}</p>
        </div>
        <div style="margin-top: 100px;">
            <table>
                <tr>
                    <td style="font-size: 6.5pt; padding-right: 40px;">Interessado: </td>
                    <td style="font-size: 6.5pt;">{{ $customer->name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-size: 6.5pt;">{!! $customer->getFullAdress() !!}</td>
                </tr>
            </table>
        </div>
        <div style="margin-top: 100px;">
            <h3 style="font-size: 6.5pt; text-align: center;">Referências Utilizadas</h3>
            <div style="margin-top: 10px;">
                <p style="font-size: 6.5pt; text-align: left;"><b>Referências externas</b></p>
                @foreach (App\Models\Ref::where('field_type_id',
                App\Models\FieldType::where('name', 'Água Subterrânea por Baixa Vazão')->first()->id)->where("type", "Referência Externa")->get() as $ref)
                    <p style="font-size: 6.5pt; text-align: left; line-height: 30px;"><b>{{ $ref->name }}:</b> {{ $ref->desc }}</p>
                @endforeach
            </div>
            <div style="margin-top: 30px;">
                <p style="font-size: 6.5pt; text-align: left;"><b>Referências</b></p>
                @foreach (App\Models\Ref::where('field_type_id',
                App\Models\FieldType::where('name', 'Água Subterrânea por Baixa Vazão')->first()->id)->where("type", "Referências")->get() as $ref)
                    <p style="font-size: 6.5pt; text-align: left; line-height: 30px;"><b>{{ $ref->name }}:</b> {{ $ref->desc }}</p>
                @endforeach
            </div>
        </div>
        <p style="page-break-after: always;"></p>
        <div id="results">
            @foreach (array_chunk($formValue->values['samples'], 4, true) as $samples)
                <h3 style="font-size: 7.5pt; text-align: center;">Resultados de Parâmetros Físico-Químicos</h3>
                <h4 style="color:#808080; font-size: 7.5pt; text-align: center; margin-bottom: 40px;">RELATÓRIO - {{ $formValue->values["project_id"] }} </h4>
                @foreach ($samples as $key => $sample)
                    <div style="margin-bottom: 20px; margin: auto; width: 80%;">
                        <table style="width:100%; border-bottom: 0px;">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Amostra</th>
                                    <th style="text-align: center">Data de Coleta</th>
                                    <th style="text-align: center">Hora</th>
                                    <th style="text-align: center">Condições Ambientais</th>
                                    <th style="text-align: center">Matriz</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center">
                                        @if(isset($sample['point'])) {{ $sample['point'] }} @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if(isset($sample['collect']))  {{ Carbon\Carbon::parse($sample['collect'])->format("d/m/Y") }} @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if(isset($sample['collect'])) {{ Carbon\Carbon::parse($sample['collect'])->format("h:i") }} @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if(isset($sample['environment'])) {{ $sample['environment'] }} @endif
                                    </td>
                                    <td style="text-align: center">
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
                        <table style="width:100%; border-top: 0px;">
                            <thead>
                                <tr style="">
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
            @endforeach
        </div>
        <div id="coordinates">
            @foreach (array_chunk($formValue->values['coordinates'], 40, true) as $coordinates)
                <h3 style="font-size: 7.5pt; text-align: center;">Localização dos pontos de amostragem - Tabela de coordenadas</h3>
                <h4 style="color:#808080; font-size: 7.5pt; text-align: center; margin-bottom: 40px;">RELATÓRIO - {{ $formValue->values["project_id"] }} </h4>
                <div style="margin-bottom: 20px; margin: auto; width: 80%;">
                    <table style="width:100%;">
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
                    <p style="margin: auto; width: 80%; font-size: 6.5pt; margin-top: 5px;">Coordenadas referenciadas ao datum horizontal SIRGAS-2000</p>
                @endif
                <p style="page-break-after: always;">
            @endforeach
        </div>

        <div id="infos">
            <h3 style="font-size: 7.5pt; text-align: center;">Informações Adicionais</h3>
            <h4 style="color:#808080; font-size: 7.5pt; text-align: center; margin-bottom: 40px;">RELATÓRIO - {{ $formValue->values["project_id"] }} </h4>
            <div class="additional-info" style="margin: auto; width: 80%; font-size: 6.5pt; margin-top: 5px;">
                {!! $formValue->values["additional_info"] !!}
            </div>
            <div style="margin-top: 100px;">
                <p style="font-size: 6.5pt; text-align: left;"><b>Aprovação do Relatório</b></p>
                <div class="additional-info" style="margin: auto; width: 80%; font-size: 6.5pt; margin-top: 5px;">
                    {!! $formValue->values["approval_text"] !!}
                </div>
            </div>
        </div>

        <div id="siger" style="margin-top: 200px; width: 150px; margin-left: auto; margn-right: 20%;">
            <p style="font-size: 6.5pt; text-align: center; border-top: 3px solid #000;">Responsável(a) Técnico(a)</p>
            <p style="font-size: 6.5pt; text-align: center;">{{ $user->full_name }}</p>
            <p style="font-size: 6.5pt; text-align: center;">CRQ IV: {{ $user->crq }}</p>
        </div>

        <p style="text-align: center; font-size: 6.5pt; margin-top: 200px; margin-bottom: 50px;">Relatório de ensaio emitido na data de {{ Carbon\Carbon::now()->format("d/m/Y")}}</p>
        <!-- <p style="page-break-after: always;">
        </p>
        <p style="page-break-after: never;">
        </p> -->
    </main>
</body>

</html>
