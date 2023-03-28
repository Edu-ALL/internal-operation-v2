<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice : {{ $clientProg->invoice->inv_id }} - PDF</title>
    {{-- <link rel="icon" href="#" type="image/gif" sizes="16x16"> --}}
    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap'); */
        @import url('{{ public_path("library/dashboard/css/googleapisfont.css") }}');
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        body {
            font-family: 'Poppins', sans-serif;
        }

        h4 {
            font-size: 25px !important;
            font-family: 'Archivo Black', sans-serif;
            letter-spacing: 10px !important;
        }

        p {
            margin: 0;
            line-height: 1.2;
        }

        table {
            border-collapse: collapse;
        }

        table tr td,
        th {
            padding: 8px 7px;
            line-height: 16px;
        }

        .table-detail th {
            background: #EEA953;
            color: #fff;
            border: 1px solid #ce8e40;
        }

        .table-detail td,
        th {
            border: 1px solid #dedede;
        }
    </style>
</head>

<body style="padding: 0; margin:0; height: 100vh">
    <div style="width: 100%; height:1059px; padding:0; margin:0;">

        <img src="{{ public_path('img/pdf/header.webp') }}" width="100%">
        <img src="{{ public_path('img/pdf/confidential.webp') }}" width="85%"
            style="position:absolute; left:8%; top:25%; z-index:-999; opacity:0.04;">
        <div class="" style="height: 840px; padding:0 30px; margin-top:-40px;">
            <h4
                style="line-height:1.6; letter-spacing:3px; font-weight:bold; text-align:center; color:#247df2; font-size:18px; margin-bottom:10px; ">
                <u><b>INVOICE</b></u>
            </h4>
            <br><br>
            <div style="height:150px;">
                <table border="0" width="100%">
                    <tr>
                        <td width="60%">
                            <table width="100%" style="padding:0px; margin-left:-10px;">
                                <tr>
                                    <td width="15%" valign="top">From: </td>
                                    <td width="85%"><b>{{ $companyDetail['name'] }}</b><br>
                                        {{ $companyDetail['address'] }} <br>
                                        {{ $companyDetail['address_dtl'] }} <br>
                                        {{ $companyDetail['city'] }}
                                        <br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">To : </td>
                                    <td><b>
                                        @if ($clientProg->client->parents()->count() > 0)
                                            {{ $clientProg->client->parents[0]->full_name }}
                                        </b><br>
                                        {{ strip_tags($clientProg->client->parents[0]->address) }}
                                        @else
                                            {{ $clientProg->client->full_name }}
                                        @endif
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td valign="top" width="45%">
                            <table border=0>
                                <tr>
                                    <td>
                                        Invoice No<br>
                                        Date<br>
                                        Due Date<br>
                                    </td>
                                    <td>
                                        : &nbsp; {{ $clientProg->invoice->inv_id }}<br>
                                        : &nbsp; {{ $clientProg->invoice->created_at }} <br>
                                        : &nbsp; {{ $clientProg->invoice->inv_duedate }} <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <br>
            <table>
                <tr>
                    <td>
                        Please process payment to {{ $companyDetail['name'] }} for the following services rendered :
                    </td>
                </tr>
            </table>

            @if ($clientProg->invoice->inv_category == "session")
                {{-- SESSION  --}}
                <table width="100%" class="table-detail" style="padding:8px 5px;">
                    <tr align="center">
                        <th width="5%">No</th>
                        <th width="50%">Description</th>
                        <th width="10%">Price/Hours</th>
                        <th width="10%">Session</th>
                        <th width="10%">Duration</th>
                        <th width="15%">Total</th>
                    </tr>
                    <tr>
                        <td valign="top" align="center">1</td>
                        <td valign="top" style="padding-bottom:10px;">
                            <div style="height:80px;">
                                <p>
                                    <strong> {{ $clientProg->invoice_program_name }} </strong>
                                </p>
                                <p>
                                    {{ strip_tags($clientProg->invoice->inv_notes) }}
                                </p>
                            </div>

                            <div style="margin-top:5px;">
                                <p>
                                    <strong> Discount</strong>
                                </p>
                            </div>
                        </td>
                        <td valign="top" align="center">
                            <div style="height:80px;">
                                <p>
                                    <strong>
                                        {{ $clientProg->invoice->invoice_price_idr }}
                                    </strong>
                                </p>
                            </div>
                        </td>
                        <td valign="top" align="center">
                            <p>{{ $clientProg->invoice->session }}x</p>
                        </td>
                        <td valign="top" align="center">
                            <p>{{ $clientProg->invoice->duration }} Min/Session</p>
                        </td>
                        <td valign="top" align="center">
                            <div style="height:80px;">
                                <p>
                                    <strong>
                                        @php
                                            $session = $clientProg->invoice->session;
                                            $duration = $clientProg->invoice->duration;
                                            $total_session = ($duration * $session) / 60 # hours;
                                        @endphp
                                        Rp. {{ number_format($clientProg->invoice->inv_totalprice_idr * $total_session, '2', ',', '.') }}
                                    </strong>
                                </p>
                            </div>
                            <div style="margin-top:5px;">
                                <p>
                                    <strong> - {{ $clientProg->invoice->invoice_discount_idr }}</strong>
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right"><b>Total</b></td>
                        <td valign="middle" align="center">
                            <b>Rp. {{ number_format(($clientProg->invoice->inv_totalprice_idr * $total_session) - $clientProg->invoice->inv_discount_idr, '2', ',','.') }}</b>
                        </td>
                    </tr>
                </table>
            @else
                {{-- NOT SESSION  --}}
                <table width="100%" class="table-detail" style="padding:8px 5px;">
                    <tr align="center">
                        <th width="5%">No</th>
                        <th width="55%">Description</th>
                        <th width="20%">Price</th>
                        <th width="20%">Total</th>
                    </tr>
                    <tr>
                        <td valign="top" align="center">1</td>
                        <td valign="top" style="padding-bottom:10px;">
                            <div style="height:80px;">
                                <p>
                                    <strong> {{ $clientProg->invoice_program_name }} </strong>
                                </p>
                                <p>
                                    {{-- USD 5,400 (IDR 80,460,000) for Yeriel Abinawa Handoyo. <br>
                                    USD 2,750 (IDR 40,975,000) for Nemuell Jatinarendra Handoyo. --}}
                                    {{ strip_tags($clientProg->invoice->inv_notes) }}
                                </p>
                            </div>

                            <div style="margin-top:5px;">
                                @if ($clientProg->invoice->invoice_earlybird_idr > 0)
                                <p>
                                    <strong> Early Bird</strong>
                                </p>
                                @endif
                                @if ($clientProg->invoice->invoice_discount_idr > 0)
                                <p>
                                    <strong> Discount</strong>
                                </p>
                                @endif
                            </div>
                        </td>
                        <td valign="top" align="center">
                            <div style="height:80px;">
                                <p>
                                    <strong>
                                        {{ $clientProg->invoice->invoice_price_idr }}
                                    </strong>
                                </p>
                            </div>
                        </td>
                        <td valign="top" align="center">
                            <div style="height:80px;">
                                <p>
                                    <strong>
                                        {{ $clientProg->invoice->invoice_price_idr }}
                                    </strong>
                                </p>
                            </div>
                            <div style="margin-top:5px;">
                                @if ($clientProg->invoice->invoice_earlybird_idr > 0)
                                <p>
                                    <strong> - {{ $clientProg->invoice->invoice_earlybird_idr }}</strong>
                                </p>
                                @endif
                                @if ($clientProg->invoice->invoice_discount_idr > 0)
                                <p>
                                    <strong> - {{ $clientProg->invoice->invoice_discount_idr }}</strong>
                                </p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><b>Total</b></td>
                        <td valign="middle" align="center">
                            <b>{{ $clientProg->invoice->invoice_totalprice_idr }}</b>
                        </td>
                    </tr>
                </table>
            @endif

            <table>
                <tr>
                    <td>
                        <b style="letter-spacing:0.7px;"><i>Total Amount : {{ $clientProg->invoice->inv_words_idr }}</i></b>
                        <br><br>

                        {{-- IF INSTALLMENT EXIST --}}
                        @if ($clientProg->invoice()->has('invoiceDetail'))
                            Terms of Payment :
                            <div style="margin-left:2px;">
                                @foreach ($clientProg->invoice->invoiceDetail as $detail)
                                    {{ $detail->invdtl_installment.' '.$detail->invdtl_percentage.'% on '.date('d F Y', strtotime($detail->invdtl_duedate)).' : '.$detail->invoicedtl_amountidr }}
                                    <br>
                                {{-- - Installment 1 40% on 05 December 2022 : $3,260 <br>
                                - Installment 2 20% on 05 February 2023 : $1,630 <br>
                                - Installment 3 20% on 05 April 2023 : $1,630 --}}
                                @endforeach
                            </div>
                        @endif


                        {{-- IF TERMS & CONDITION EXIST  --}}
                        <br>
                        Terms & Conditions :
                        <div style="margin-left:2px;">
                            {!! $clientProg->invoice->inv_tnc !!}
                        </div>
                    </td>
                </tr>
            </table>

            {{-- BANK TRANSFER  --}}
            <br>
            <table border=0 width="100%">
                <tr>
                    <td width="60%" valign="top">
                        <b>Bank transfer details :</b>
                        <table border="0" style="padding:0px; margin-left:-6px;">
                            <tr>
                                <td>
                                    Beneficiary <br>
                                    Bank <br>
                                    A/C No. <br>
                                    Branch <br>
                                </td>
                                <td width="78%">
                                    : PT. Jawara Edukasih Indonesia <br>
                                    : BCA <br>
                                    : 2483016611 <br>
                                    : KCP Pasar Kebayoran Lama Jakarta Selatan
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="40%" align="center" valign="top">
                        {{ $companyDetail['name'] }}
                        <br><br><br><br><br><br>
                        Nicholas Hendra Soepriatna <br>
                        Director
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <img src="{{ public_path('img/pdf/footer.webp') }}" style="position:relative;" width="100%">
</body>

</html>
