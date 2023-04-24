<!DOCTYPE html>
<html lang="en">

<head>
	@include('form-values.print.styles')
</head>

<body>
    <header>
        <table>
            <tr>
              <td style="text-align: left; vertical-align: middle;">
                <img src="data:image/png;base64, {{ $formPrint->logo }}" width="155" height="86">
              </td>
              <td colspan="2" style="text-align: center; vertical-align: middle;" id="text">
              </td>
              <td style="text-align: right; vertical-align: middle;">
                @if (isset($formPrint->formValue->values['accreditation'])) <img src="data:image/png;base64, {{ $formPrint->crl }}" width="74" height="112" > @endif
              </td>
            </tr>
        </table>
    </header>

    <footer>
    </footer>

     <main>
        <div class="report-title">
            <h1>Relatório de Ensaios de Campo</h1>
            <h2>{{ $formPrint->formValue->values["project_id"] }}</h2>
            <p>{{ $formPrint->formValue->form->identification }} Versão {{ $formPrint->formValue->form->version }}
                {{ $formPrint->formValue->form->published_at ? $formPrint->formValue->form->published_at->format("d/m/Y") : '' }}</p>
        </div>
        <div id="customer">
            <table>
                <tr>
                    <td style="padding-right: 40px;">Interessado: </td>
                    <td>{{ $formPrint->customer->name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>{!! $formPrint->customer->getFullAdress() !!}</td>
                </tr>
            </table>
        </div>
        <div id="refs">
            <h3>Referências Utilizadas</h3>
            <div class="refs-external-values">
                <p class="title"><b>Referências externas</b></p>
                @foreach ($formPrint->externalRefs as $ref)
                    <p class="content"><b>{{ $ref->name }}:</b> {{ $ref->desc }}</p>
                @endforeach
            </div>
            <div class="refs-values">
                <p class="title"><b>Referências</b></p>
                @foreach ($formPrint->refs as $ref)
                    <p class="content"><b>{{ $ref->name }}:</b> {{ $ref->desc }}</p>
                @endforeach
            </div>
        </div>
        <div class="footer">
           {!! $formPrint->footer !!}
        </div>
        <p style="page-break-after: always;"></p>
        @include('form-values.print.sub-header')
        <div id="results">
            @if (isset($formPrint->formValue->values['samples']))
                @foreach (array_chunk($formPrint->formValue->values['samples'], 5, true) as  $samples)
                    <div class="inner-results">
                        <h3>Resultados de Parâmetros Físico-Químicos</h3>
                        <h4>RELATÓRIO - {{ $formPrint->formValue->values["project_id"] }} </h4>
                        @foreach ($samples as $row => $sample)
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
                                                @if(isset($sample['collect'])) {{ Carbon\Carbon::parse($sample['collect'])->format("H:i") }} @endif
                                            </td>
                                            <td>
                                                @if(isset($sample['environment'])) {{ $sample['environment'] }} @endif
                                            </td>
                                            <td>
                                                @if(isset($formPrint->formValue->values['matrix']))
                                                    @php
                                                        $formType = App\Models\FieldType::find($formPrint->formValue->values['matrix']);
                                                    @endphp
                                                    {{  $formType->report_name ? $formType->report_name : $formType->name }}
                                                @endif
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
                                            @if(isset($formPrint->formValue->values['uncertainty']))
                                                <th style="text-align: center; border-top: 1px #000 solid; border-bottom: 1px #000 solid; border-right: 0px; border-left: 0px;">Incerteza</th>
                                            @endif
                                            <th style="text-align: center; border-top: 1px #000 solid; border-bottom: 1px #000 solid; border-right: 0px; border-left: 0px;">LQ</th>
                                            <th style="text-align: center; border-top: 1px #000 solid; border-bottom: 1px #000 solid; border-left: 0px;">Faixa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($formPrint->parameters as $key => $value)
                                            @if((isset($formPrint->formValue->values[$key . "_column"]) && $formPrint->formValue->form->name == "RT-LAB-041-191") ||
                                                ($formPrint->formValue->form->name != "RT-LAB-041-191"))
                                                @if((!isset($formPrint->formValue->values['turbidity']) && $key != "ntu") ||
                                                    (isset($formPrint->formValue->values['turbidity'])))
                                                    <tr>
                                                        <td style="text-align: left; border: 0px; border-left: 1px double grey;">
                                                            {{ $value }}
                                                        </td>
                                                        <td style="text-align: center; border: 0px;">
                                                            {{ $formPrint->unities[$key] }}
                                                        </td>
                                                        <td style="text-align: center; border: 0px;">
                                                            @if(isset($formPrint->formValue->svgs[$row][$key]))
                                                                @php
                                                                    if($key == "ntu" || $key == "eh") :
                                                                        $v = isset($sample[$key . "_footer"]) ? $sample[$key . "_footer"] : $formPrint->formValue->svgs[$row][$key];
                                                                    else :
                                                                        $v =  $formPrint->formValue->svgs[$row][$key];
                                                                    endif;
                                                                @endphp

                                                                @if((floatval($formPrint->LQ[$key]) > floatval($v) || !$v) && is_numeric($formPrint->LQ[$key]))
                                                                    {{'< ' . number_format(floatval($formPrint->LQ[$key]), $formPrint->places[$key], ",", ".") }}
                                                                @elseif($key == "conductivity"  && $v >= 200000)
                                                                    {{ "> 200000" }}
                                                                @elseif($key == "salinity"  && $v >= 70)
                                                                    {{ "> 70" }}
                                                                @else
                                                                    {{ is_numeric($v) ? number_format($v, $formPrint->places[$key], ",", ".") : $v }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        @if(isset($formPrint->formValue->values['uncertainty']))
                                                            <td style="text-align: center; border: 0px;">
                                                                {{ isset($sample[$key . "_uncertainty_footer"]) ? '± ' . $sample[$key . "_uncertainty_footer"] : '-'}}
                                                            </td>
                                                        @endif
                                                        <td style="text-align: center; border: 0px;">
                                                            {{ Str::replace(".", ",", $formPrint->LQ[$key]) }}
                                                        </td>
                                                        <td style="text-align: center; border: 0px; border-right: 1px double grey;">
                                                            {{ $formPrint->range[$key] }}
                                                        </td>
                                                    <tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                    <p style="page-break-after: always;"></p>
                    @include('form-values.print.sub-header')
                @endforeach
            @endif
        </div>
        <div id="coordinates">
            @if (isset($formPrint->formValue->values['coordinates']))
                @foreach (array_chunk($formPrint->formValue->values['coordinates'], 40, true) as $coordinates)
                    <div class="inner-coordinates">
                        <h3>Localização dos pontos de amostragem - Tabela de coordenadas</h3>
                        <h4>RELATÓRIO - {{ $formPrint->formValue->values["project_id"] }} </h4>
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
                                    @foreach ($coordinates as $row => $coordinate)
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
                    </div>
                    <p style="page-break-after: always;">
                    @include('form-values.print.sub-header')
                @endforeach
            @endif
        </div>

        <div id="infos">
            <h3>Informações Adicionais</h3>
            <h4>RELATÓRIO - {{ $formPrint->formValue->values["project_id"] }} </h4>
            <div class="additional-info">
                @if(isset($formPrint->formValue->values["additional_info"])) {!! $formPrint->formValue->values["additional_info"] !!} @endif
            </div>
            @if(isset($formPrint->formValue->values['uncertainty']))
                <div class="uncertainty-text">
                    {!! $formPrint->uncertaintyText !!}
                </div>
            @endif
            <div class="approval-text-container">
                <p><b>Aprovação do Relatório</b></p>
                <div class="additional-info">
                    @if(isset($formPrint->formValue->values["approval_text"])) {!! $formPrint->formValue->values["approval_text"] !!} @endif
                </div>
            </div>
        </div>

        <div id="signer">
            @if ( $formPrint->signerFile)
                <img src="data:image/png;base64, {{ $formPrint->signer }}" width="70" height="70">
            @endif
            @if($formPrint->user)
                <p class="user">Responsável(a) Técnico(a)</p>
                <p class="user-name">{{ $formPrint->user->full_name }}</p>
                <p class="user-crq">CRQ IV: {{ $formPrint->user->crq }}</p>
                <p class="user-crq">{{ $formPrint->user->department ? $formPrint->user->department->name : null }}</p>
            @endif
        </div>

        <p class="report-date">Relatório de ensaio emitido na data de {{ Carbon\Carbon::now()->format("d/m/Y")}}</p>
        @if ($formPrint->lastRev)
            <p class="revs">O atual relatório substitui a versão {{ $formPrint->lastRev->created_at->format("d/m/Y") }} </p>
            <p class="revs">Motivo da Revisão: {{ $formPrint->lastRev->reason }}</p>
        @endif
        <!-- <p style="page-break-after: always;">
        </p>
        <p style="page-break-after: never;">
        </p> -->
    </main>
</body>

</html>
