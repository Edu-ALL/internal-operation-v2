<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt : {{ $receiptSch->receipt_id }} - PDF</title>
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
            font-size: 30px !important;
            font-weight: 800;
            font-family: 'Archivo Black', sans-serif;
            letter-spacing: 5px !important;
            color: #9d9c9c;
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

<body style="padding: 0; margin:0">
    <div style="width: 100%; height:1059px; padding:0; margin:0;">
        <img src="{{ public_path('img/pdf/header.png') }}" width="100%">
        <img src="{{ public_path('img/pdf/confidential.webp') }}" width="85%"
            style="position:absolute; left:8%; top:25%; z-index:-999; opacity:0.04;">
        <div class="" style="height: 840px; padding:0 30px; margin-top:-40px;">
            <h4 style="">
                <b>PAYMENT RECEIPT</b>
            </h4>

            <table border="0" width="100%">
                <tr>
                    <td width="60%">
                        <table width="100%" style="padding:0px; margin-left:-10px;">
                            <tr>
                                <td width="15%" valign="top">From : </td>
                                <td width="85%"><b>PT. Jawara Edukasih Indonesia</b><br>
                                    Jl Jeruk Kembar Blok Q9 No. 15 <br>
                                    Srengseng, Kembangan <br>
                                    DKI Jakarta
                                    <br><br>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td valign="top" width="45%">
                        <table border=0>
                            <tr>
                                <td valign="top">
                                    Received from :
                                </td>
                                <td>
                                    {{ $receiptSch->invoiceB2b->sch_prog->school->sch_name }}
                                    <br>
                                    {{ $receiptSch->invoiceB2b->sch_prog->school->sch_city }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <br>
            <table>
                <tr>
                    <td>
                        Receipt No. {{ $receiptSch->receipt_id }}
                    </td>
                </tr>
            </table>

            <table width="100%" class="table-detail" style="padding:8px 5px;">
                <tr align="center">
                    <th width="35%">Payment Method</th>
                    @if($receiptSch->receipt_method == 'Cheque')
                        <th width="35%">Cheque No.</th>
                    @endif
                    <th width="30%">Amount</th>
                </tr>
                <tr align="center">
                    <td>{{ $receiptSch->receipt_method }}</td>
                    @if($receiptSch->receipt_method == 'Cheque')
                        <td>{{ $receiptSch->receipt_cheque }}</td>
                    @endif
                    <td>{{ $currency == 'other' ? $receiptSch->receipt_amount : $receiptSch->receipt_amount_idr }}</td>
                </tr>
            </table>
            <br>

            <table width="100%" class="table-detail" style="padding:8px 5px;">
                <tr align="center">
                    <th width="5%">No</th>
                    <th width="50%">Description</th>
                    <th width="25%">Price</th>
                    {{-- <th width="10%">Participants</th> --}}
                    <th width="20%">Total</th>
                </tr>
                <tr>
                    <td valign="top" align="center">1</td>
                    <td valign="top" style="padding-bottom:10px;">
                        <div style="height:80px;">
                            <p>
                                <strong> {{ (($receiptSch->invoiceB2b->sch_prog->program->prog_sub != '-')) ? $receiptSch->invoiceB2b->sch_prog->program->prog_sub . ': ' . $receiptSch->invoiceB2b->sch_prog->program->prog_program : $receiptSch->invoiceB2b->sch_prog->program->prog_program }} </strong>
                            </p>
                            @if ($receiptSch->invoiceB2b->invb2b_pm == "Installment")
                                <p>
                                    {{ $receiptSch->invoiceInstallment->invdtl_installment }} ( {{ $receiptSch->invoiceInstallment->invdtl_percentage }}% )
                                </p>
                            @endif
                        </div>

                    </td>
                    <td valign="top" align="center">
                        <div style="height:80px;">
                            <p>
                                <strong>
                                    @if ($receiptSch->invoiceB2b->invb2b_pm == "Installment")
                                        {{ $currency == 'other' ? $receiptSch->invoiceInstallment->invoicedtl_amount :  $receiptSch->invoiceInstallment->invoicedtl_amountidr }}
                                    @else
                                        {{ $currency == 'other' ? $receiptSch->invoiceB2b->invoiceSubTotalprice : $receiptSch->invoiceB2b->invoiceSubTotalpriceIdr }}
                                    @endif
                                </strong>
                            </p>
                        </div>
                    </td>
                    <td valign="top" align="center">
                        <div style="height:80px;">
                            <p>
                                <strong>
                                    @if ($receiptSch->invoiceB2b->invb2b_pm == "Installment")
                                        {{ $currency == 'other' ? $receiptSch->invoiceInstallment->invoicedtl_amount :  $receiptSch->invoiceInstallment->invoicedtl_amountidr }}
                                    @else
                                        {{ $currency == 'other' ? $receiptSch->invoiceB2b->invoiceSubTotalprice : $receiptSch->invoiceB2b->invoiceSubTotalpriceIdr }}
                                    @endif
                                </strong>
                            </p>
                        </div>
                    </td>
                </tr>
                @if(isset($receiptSch->invoiceB2b->invb2b_discidr))
                    <tr>
                        <td colspan="3" align="right"><b>Discount</b></td>
                        <td valign="middle" align="center">
                            <b> 
                                <strong> - {{ $currency == 'other' ? $receiptSch->invoiceB2b->invoiceDiscount : $receiptSch->invoiceB2b->invoiceDiscountIdr }}</strong>
                            </b>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" align="right"><b>Total</b></td>
                    <td valign="middle" align="center">
                        <b> 
                            {{ $currency == 'other' ? $receiptSch->receipt_amount : $receiptSch->receipt_amount_idr }}
                        </b>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td>
                        <b style="letter-spacing:0.7px;"><i>Total Amount : {{ $currency == 'other' ? $receiptSch->receipt_words : $receiptSch->receipt_words_idr }}</i></b>
                    </td>
                </tr>
            </table>

            <table border=0 width="100%">
                <tr>
                    <td width="60%" valign="top">
                    </td>
                    <td width="40%" align="center" valign="top">
                        PT. Jawara Edukasih Indonesia
                        <br><br><br><br><br><br>
                        Nicholas Hendra Soepriatna <br>
                        Director
                    </td>
                </tr>
            </table>
            <br><br>

            <table width="100%">
                <tr>
                    <td align="center">
                        Thank You for Your Business
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <img src="{{ public_path('img/pdf/footer.webp') }}" style="position:relative;" width="100%">
</body>

</html>
