@php $customer = App\Models\Customer::find($formValue->values['client']); @endphp

<!DOCTYPE html>
<html lang="en">

<head>
	<style>
		@page {
			margin: 100px 25px;
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
            bottom: -60px;
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

        h1, h2, h3, p, td {
            font-family: 'Helvertica', Tahoma, Geneva, Verdana, sans-serif !important;
            margin: 0px;
        }
	</style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        <table style="width:100%;">
            <tr>
              <td style="text-align: left">
                <img src="data:image/png;base64, {{ $logo }}" width="155" height="86">
              </td>
              <td colspan="4" style="text-align: center">
                <p style="font-size: 12px; color: #6EBC6E"><b>Consultoria, Planejamento e Estudos Ambientais</b></p>
                <p style="font-size: 12px;">Rua Henrique Monteiro, 90 - 13º andar - Pinheiros - São Paulo / SP - CEP: 05423-020</p>
                <p style="font-size: 12px;">Rua Enguaguaçu, 99 - Ponta da Praia - Santos / SP - CEP: 11035-071</p>
              </td>
              <td style="text-align: right">
                <img src="data:image/png;base64, {{ $crl }}" width="74" height="112" >
              </td>
            </tr>
        </table>
    </header>

    <footer>
        <p>Rua Henrique Monteiro, 90 - 13º andar - Pinheiros - São Paulo / SP - CEP: 05423-020 - Tel: (11) 4082-3200</p>
        <p> Rua Enguaguaçu, 99 - Ponta da Praia - Santos / SP - CEP: 11035-071 - Tel: (13) 3035-6002</p>
        <p>cpea@cpeanet.com</p>
        <p> www.cpeanet.com.br</p>
    </footer>

     <!-- Wrap the content of your PDF inside a main tag -->
     <main>
        <div style="text-align: center; margin-top: 100px;">
            <h1 style="font-size: 24px; font-weight: 100">Relatório de Ensaios de Campo</h1>
            <h2 style="font-size: 24px;">IDCPEA47480322PM_DIQUE_MONITORAMENTO</h2>
            <p style="font-size: 12px; line-height: 20px">RT-GGQ-020 Versão 22.0 12/03/2021</p>
        </div>
        <div style="margin-top: 100px;">
            <table>
                <tr>
                    <td style="font-size: 12px; padding-right: 40px;">Interessado: </td>
                    <td style="font-size: 12px;">{{ $customer->name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-size: 12px;">{!! $customer->getFullAdress() !!}</td>
                </tr>
            </table>
        </div>
        <div style="margin-top: 100px;">
            <h3 style="font-size: 12px; text-align: center;">Referências Utilizadas</h3>
            <div style="margin-top: 10px;">
                <p style="font-size: 12px; text-align: left;"><b>Referências externas</b></p>
                @foreach (App\Models\Ref::where('field_type_id',
                App\Models\FieldType::where('name', 'Água Subterrânea por Baixa Vazão')->first()->id)->where("type", "Referência Externa")->get() as $ref)
                    <p style="font-size: 12px; text-align: left; line-height: 30px;"><b>{{ $ref->name }}:</b> {{ $ref->desc }}</p>
                @endforeach
            </div>
            <div style="margin-top: 30px;">
                <p style="font-size: 12px; text-align: left;"><b>Referências</b></p>
                @foreach (App\Models\Ref::where('field_type_id',
                App\Models\FieldType::where('name', 'Água Subterrânea por Baixa Vazão')->first()->id)->where("type", "Referências")->get() as $ref)
                    <p style="font-size: 12px; text-align: left; line-height: 30px;"><b>{{ $ref->name }}:</b> {{ $ref->desc }}</p>
                @endforeach
            </div>
        </div>
        <p style="page-break-after: always;">
        </p>
        <p style="page-break-after: never;">
        </p>
    </main>
</body>

</html>
