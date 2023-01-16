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

    header table {
        width:100%;
        table-layout: fixed;
    }

    .report-title {
        text-align: center;
        margin-top: 100px;
    }

    .report-title h1 {
        font-size: 12.5pt;
    }

    .report-title h2 {
        font-size: 12.5pt;
    }

    .report-title p {
        font-size: 6.5pt;
        line-height: 20px
    }

    .sub-header {
        position: fixed;
        top: -60px;
        left: 0px;
        right: 0px;
        height: 50px;
        width: 100%;
    }

    .sub-header p {
        text-align: center;
        font-size: 6.5pt;
    }

    .sub-header p strong,
    .sub-header p b {
        color: #6EBC6E;
    }

    .footer {
        position: absolute;
        bottom: 0px;
        left: 0px;
        right: 0px;
        width: 100%;
        text-align: center;
        font-size: 6.5pt;
    }

    .footer p {
        text-align: center;
        font-size: 6.5pt;
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

    #customer, #refs {
        margin-top: 100px;
    }

    #customer td {
        font-size: 6.5pt;
    }

    #refs h3 {
        font-size: 6.5pt;
        text-align: center;
    }

    #refs .refs-external-values {
        margin-top: 10px;
    }

    #refs .refs-external-values .title,
    #refs .refs-values .title {
        font-size: 6.5pt;
        text-align: left;
    }

    #refs .refs-values .content,
    #refs .refs-external-values .content {
        font-size: 6.5pt;
        text-align: left;
        line-height: 30px;
    }

    #refs .refs-values {
        margin-top: 100px;
    }

    #infos,
    #results .inner-results,
    #coordinates .inner-coordinates {
        margin-top: 20px;
    }

    #results table,
    #results td,
    #results th,
    #results tr {
        border: 1px double  grey;
        border-spacing: 0;
    }

    #results .table-container {
        margin-bottom: 20px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 15px;
        width: 80%;
    }

    #results .table-container .first {
        width:100%;
        border-bottom: 0px;
    }

    #results .table-container .second {
        width:100%;
        border-top: 0px;
    }

    #results .table-container .first th,
    #results .table-container .first td {
        text-align: center;
    }

    #results h3 {
        font-size: 7.5pt;
        text-align: center;
    }

    #results h4 {
        color:#808080;
        font-size: 7.5pt;
        text-align: center;
        margin-bottom: 20px;
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

    #coordinates h3 {
        font-size: 7.5pt;
        text-align: center;
    }

    #coordinates h4 {
        color:#808080;
        font-size: 7.5pt;
        text-align: center;
        margin-bottom: 20px;
    }

    #coordinates .table-container {
        margin-bottom: 20px;
        margin: auto;
        width: 80%;
    }

    #coordinates .table-container table {
        width: 100%;
    }

    .coordinates-footer {
        margin: auto;
        width: 80%;
        font-size: 6.5pt;
        margin-top: 5px;
    }

    .additional-info p {
        font-size: 6.5pt ;
        line-height: 20px;
    }

    #signer {
        width: 150px;
        margin-top: 120px;
        margin-left: auto;
        margin-right: 20%;
        text-align: center;
    }

    #signer .user {
        font-size: 6.5pt;
        text-align: center;
        border-top: 3px solid #000;
    }

    #signer .user-name,
    #signer .user-crq {
        font-size: 6.5pt;
        text-align: center;
    }

    .report-date {
        text-align: center;
        font-size: 6.5pt;
        margin-top: 200px;
        margin-bottom: 50px;
    }

    #infos h3 {
        font-size: 7.5pt;
        text-align: center;
    }

    #infos h4 {
        color:#808080;
        font-size: 7.5pt;
        text-align: center;
        margin-bottom: 40px;
    }

    #infos .additional-info {
        margin: auto;
        width: 80%;
        font-size: 6.5pt;
        margin-top: 5px;
    }

    #infos .approval-text-container {
        margin-top: 100px;
    }

    #infos .approval-text-container p {
        font-size: 6.5pt;
        text-align: left;
    }
</style>
