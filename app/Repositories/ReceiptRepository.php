<?php

namespace App\Repositories;

use App\Interfaces\ReceiptRepositoryInterface;
use App\Models\Invb2b;
use App\Models\Receipt;
use App\Models\v1\Receipt as V1Receipt;
use App\Models\Refund;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;

class ReceiptRepository implements ReceiptRepositoryInterface
{

    public function getAllReceiptSchDataTables()
    {
        return Datatables::eloquent(
            Receipt::leftJoin('tbl_invdtl', 'tbl_invdtl.invdtl_id', '=', 'tbl_receipt.invdtl_id')
                ->leftJoin('tbl_invb2b', 'tbl_invb2b.invb2b_id', '=', DB::raw('(CASE WHEN tbl_receipt.invdtl_id is not null THEN tbl_invdtl.invb2b_id ELSE tbl_receipt.invb2b_id END)'))
                ->rightJoin('tbl_sch_prog', 'tbl_sch_prog.id', '=', 'tbl_invb2b.schprog_id')
                ->leftJoin('tbl_sch', 'tbl_sch_prog.sch_id', '=', 'tbl_sch.sch_id')
                ->leftJoin('tbl_prog', 'tbl_prog.prog_id', '=', 'tbl_sch_prog.prog_id')
                ->leftJoin('tbl_sub_prog', 'tbl_sub_prog.id', '=', 'tbl_prog.sub_prog_id')
                ->select(
                    'tbl_receipt.id as increment_receipt',
                    'tbl_sch.sch_name as school_name',
                    // 'tbl_prog.prog_program as program_name',
                    DB::raw('(CASE
                        WHEN tbl_prog.sub_prog_id > 0 THEN CONCAT(tbl_sub_prog.sub_prog_name," - ",tbl_prog.prog_program)
                        ELSE tbl_prog.prog_program
                    END) AS program_name'),
                    'tbl_receipt.receipt_id',
                    'tbl_invb2b.invb2b_id',
                    'tbl_receipt.receipt_method',
                    'tbl_receipt.created_at',
                    'tbl_invb2b.invb2b_num',
                    'tbl_invb2b.currency',
                    'tbl_receipt.receipt_amount as total_price_other',
                    'tbl_receipt.receipt_amount_idr as total_price_idr',
                )
                ->where('tbl_receipt.receipt_status', 1)
                ->orderBy('tbl_receipt.created_at', 'DESC')
        )->make(true);
    }

    public function getAllReceiptCorpDataTables()
    {
        return Datatables::eloquent(
            Receipt::leftJoin('tbl_invdtl', 'tbl_invdtl.invdtl_id', '=', 'tbl_receipt.invdtl_id')
                ->leftJoin('tbl_invb2b', 'tbl_invb2b.invb2b_id', '=', DB::raw('(CASE WHEN tbl_receipt.invdtl_id is not null THEN tbl_invdtl.invb2b_id ELSE tbl_receipt.invb2b_id END)'))
                ->rightJoin('tbl_partner_prog', 'tbl_partner_prog.id', '=', 'tbl_invb2b.partnerprog_id')
                ->leftJoin('tbl_corp', 'tbl_corp.corp_id', '=', 'tbl_partner_prog.corp_id')
                ->leftJoin('tbl_prog', 'tbl_prog.prog_id', '=', 'tbl_partner_prog.prog_id')
                ->leftJoin('tbl_sub_prog', 'tbl_sub_prog.id', '=', 'tbl_prog.sub_prog_id')
                ->select(
                    'tbl_receipt.id as increment_receipt',
                    'tbl_corp.corp_name',
                    // 'tbl_prog.prog_program as program_name',
                    DB::raw('(CASE
                        WHEN tbl_prog.sub_prog_id > 0 THEN CONCAT(tbl_sub_prog.sub_prog_name," - ",tbl_prog.prog_program)
                        ELSE tbl_prog.prog_program
                    END) AS program_name'),
                    'tbl_receipt.receipt_id',
                    'tbl_invb2b.invb2b_id',
                    'tbl_receipt.receipt_method',
                    'tbl_receipt.created_at',
                    'tbl_invb2b.invb2b_num',
                    'tbl_invb2b.currency',
                    'tbl_receipt.receipt_amount as total_price_other',
                    'tbl_receipt.receipt_amount_idr as total_price_idr',
                )
                ->where('tbl_receipt.receipt_status', 1)
                ->orderBy('tbl_receipt.created_at', 'DESC')
        )->make(true);
    }

    public function getAllReceiptReferralDataTables()
    {
        return Datatables::eloquent(
            Receipt::leftJoin('tbl_invb2b', 'tbl_invb2b.invb2b_id', '=', 'tbl_receipt.invb2b_id')
                ->rightJoin('tbl_referral', 'tbl_referral.id', '=', 'tbl_invb2b.ref_id')
                ->leftJoin('tbl_corp', 'tbl_corp.corp_id', '=', 'tbl_referral.partner_id')
                ->select(
                    'tbl_receipt.id as increment_receipt',
                    'tbl_corp.corp_name',
                    'tbl_referral.additional_prog_name as program_name',
                    'tbl_receipt.receipt_id',
                    'tbl_receipt.invb2b_id',
                    'tbl_receipt.receipt_method',
                    'tbl_receipt.created_at',
                    'tbl_invb2b.invb2b_num',
                    'tbl_invb2b.currency',
                    'tbl_receipt.receipt_amount as total_price_other',
                    'tbl_receipt.receipt_amount_idr as total_price_idr',
                )
                ->where('tbl_receipt.receipt_status', 1)
                ->where('tbl_referral.referral_type', 'Out')
                ->orderBy('tbl_receipt.created_at', 'DESC')
        )->make(true);
    }

    public function getReceiptById($receiptId)
    {
        return Receipt::find($receiptId);
    }


    public function getAllReceiptByStatusDataTables() # client program
    {

        $query = Receipt::leftJoin('tbl_inv', 'tbl_inv.inv_id', '=', 'tbl_receipt.inv_id')
            ->leftJoin('tbl_client_prog', 'tbl_client_prog.clientprog_id', '=', 'tbl_inv.clientprog_id')
            ->leftJoin('tbl_prog', 'tbl_prog.prog_id', '=', 'tbl_client_prog.prog_id')
            ->leftJoin('tbl_main_prog', 'tbl_main_prog.id', '=', 'tbl_prog.main_prog_id')
            ->leftJoin('tbl_sub_prog', 'tbl_sub_prog.id', '=', 'tbl_prog.sub_prog_id')
            ->leftJoin('tbl_client', 'tbl_client.id', '=', 'tbl_client_prog.client_id')
            ->where('receipt_status', 1)
            ->whereNotNull('tbl_receipt.inv_id')
            ->select([
                'tbl_client_prog.clientprog_id',
                'tbl_inv.clientprog_id',
                'tbl_receipt.id',
                'tbl_receipt.receipt_id',
                'tbl_receipt.created_at',
                DB::raw('CONCAT(first_name, " ", COALESCE(last_name, "")) as client_fullname'),
                DB::raw('CONCAT(prog_program, " - ", COALESCE(tbl_main_prog.prog_name, ""), " / ", COALESCE(tbl_sub_prog.sub_prog_name, "")) as program_name'),
                'tbl_inv.inv_id',
                'tbl_receipt.receipt_method',
                'tbl_inv.created_at',
                'tbl_inv.inv_duedate',
                'tbl_receipt.receipt_amount_idr',
                DB::raw('DATEDIFF(inv_duedate, now()) as date_difference')
            ]);

        return DataTables::eloquent($query)
            ->filterColumn('client_fullname', function ($query, $keyword) {
                $sql = 'CONCAT(first_name COLLATE utf8mb4_unicode_ci, " ", COALESCE(last_name COLLATE utf8mb4_unicode_ci, "")) like ?';
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('program_name', function ($query, $keyword) {
                $sql = 'CONCAT(prog_program COLLATE utf8mb4_unicode_ci, " - ", COALESCE(tbl_main_prog.prog_name COLLATE utf8mb4_unicode_ci, ""), " / ", COALESCE(tbl_sub_prog.sub_prog_name COLLATE utf8mb4_unicode_ci, "")) like ?';
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })->make(true);
    }

    public function getReceiptByInvoiceIdentifier($invoiceType, $identifier)
    {
        return Receipt::when($invoiceType == "Program", function ($query) use ($identifier) {
            $query->where('inv_id', $identifier);
        })->when($invoiceType == "Installment", function ($query) use ($identifier) {
            $query->where('invdtl_id', $identifier);
        })->when($invoiceType == "B2B", function ($query) use ($identifier) {
            $query->where('invb2b_id', $identifier);
        })->first();
    }

    public function getReceiptByReceiptId($receiptId)
    {
        return Receipt::where('receipt_id', $receiptId)->first();
    }

    public function getAllReceiptSchool()
    {
        return Receipt::leftJoin('tbl_invdtl', 'tbl_invdtl.invdtl_id', '=', 'tbl_receipt.invdtl_id')
            ->leftJoin('tbl_invb2b', 'tbl_invb2b.invb2b_id', '=', DB::raw('(CASE WHEN tbl_receipt.invdtl_id is not null THEN tbl_invdtl.invb2b_id ELSE tbl_receipt.invb2b_id END)'))
            ->leftJoin('tbl_sch_prog', 'tbl_sch_prog.id', '=', 'tbl_invb2b.schprog_id')
            ->whereNotNull('tbl_sch_prog.id')
            ->get();
    }

    public function createReceipt(array $receiptDetails)
    {
        return Receipt::create($receiptDetails);
    }

    public function insertReceipt(array $receiptDetails)
    {
        return Receipt::insert($receiptDetails);
    }

    public function updateReceipt($receiptId, array $newDetails)
    {
        return Receipt::whereId($receiptId)->update($newDetails);
    }

    public function updateReceiptByInvoiceIdentifier($invoiceType, $identifier, array $newDetails)
    {
        return Receipt::when($invoiceType == "Program", function ($query) use ($identifier, $newDetails) {
            $query->where('inv_id', $identifier)->update($newDetails);
        })->when($invoiceType == "Installment", function ($query) use ($identifier, $newDetails) {
            $query->where('invdtl_id', $identifier)->update($newDetails);
        })->when($invoiceType == "B2B", function ($query) use ($identifier, $newDetails) {
            $query->where('invb2b_id', $identifier)->update($newDetails);
        });
    }

    public function deleteReceipt($receiptId)
    {
        return Receipt::whereId($receiptId)->delete();
    }

    public function getReportReceipt($start_date = null, $end_date = null)
    {
        $firstDay = Carbon::now()->startOfMonth()->toDateString();
        $lastDay = Carbon::now()->endOfMonth()->toDateString();

        $queryReceipt = Receipt::leftJoin('tbl_invdtl', 'tbl_invdtl.invdtl_id', '=', 'tbl_receipt.invdtl_id')
            ->leftJoin('tbl_invb2b', 'tbl_invb2b.invb2b_id', '=', DB::raw('(CASE WHEN tbl_receipt.invdtl_id is not null THEN tbl_invdtl.invb2b_id ELSE tbl_receipt.invb2b_id END)'))
            ->leftJoin('tbl_inv', 'tbl_inv.inv_id', '=', DB::raw('(CASE WHEN tbl_receipt.invdtl_id is not null THEN tbl_invdtl.inv_id ELSE tbl_receipt.inv_id END)'))
            ->leftJoin('tbl_sch_prog', 'tbl_sch_prog.id', '=', 'tbl_invb2b.schprog_id')
            ->leftJoin('tbl_partner_prog', 'tbl_partner_prog.id', '=', 'tbl_invb2b.partnerprog_id')
            ->leftJoin('tbl_client_prog', 'tbl_client_prog.clientprog_id', '=', 'tbl_inv.clientprog_id')
            ->leftJoin('tbl_referral', 'tbl_referral.id', '=', 'tbl_invb2b.ref_id')
            ->select(
                'tbl_receipt.id',
                'tbl_receipt.receipt_id',
                'tbl_receipt.invdtl_id',
                'tbl_receipt.receipt_method',
                'tbl_invb2b.ref_id',
                'tbl_receipt.created_at',
                'tbl_receipt.receipt_amount_idr',
                DB::raw('(CASE
                            WHEN tbl_receipt.invb2b_id is not null THEN tbl_receipt.invb2b_id
                            WHEN tbl_receipt.invdtl_id is not null THEN 
                                (CASE
                                    WHEN tbl_invdtl.invb2b_id is not null THEN tbl_invdtl.invb2b_id
                                END)
                            END) as invb2b_id'),
                DB::raw('(CASE
                            WHEN tbl_receipt.inv_id is not null THEN tbl_receipt.inv_id
                            WHEN tbl_receipt.invdtl_id is not null THEN 
                                (CASE
                                    WHEN tbl_invdtl.inv_id is not null THEN tbl_invdtl.inv_id
                                END)
                            END) as inv_id'),
                DB::raw('(CASE
                            WHEN tbl_receipt.invdtl_id is not null THEN 
                            (CASE
                                WHEN tbl_invdtl.invb2b_id is not null THEN  
                                    (CASE 
                                        WHEN tbl_invb2b.schprog_id > 0 THEN tbl_sch_prog.status
                                        WHEN tbl_invb2b.partnerprog_id > 0 THEN tbl_partner_prog.status
                                    END)
                                WHEN tbl_invdtl.inv_id is not null THEN tbl_client_prog.status
                            END)
                            WHEN tbl_receipt.inv_id is not null THEN tbl_client_prog.status
                            WHEN tbl_invb2b.schprog_id is not null THEN tbl_sch_prog.status
                            WHEN tbl_invb2b.partnerprog_id is not null THEN tbl_partner_prog.status
                    END) as status_where'),
                DB::raw('(CASE
                            WHEN tbl_receipt.invdtl_id is not null THEN 
                            (CASE
                                WHEN tbl_invdtl.invb2b_id is not null THEN  
                                    (CASE 
                                        WHEN tbl_invb2b.ref_id > 0 THEN tbl_referral.referral_type
                                    END)
                            END)
                            WHEN tbl_invb2b.ref_id > 0 THEN tbl_referral.referral_type
                            ELSE NULL
                    END) as referral_type'),
            );


        if (isset($start_date) && isset($end_date)) {
            $queryReceipt->whereDate('tbl_receipt.created_at', '>=', $start_date)
                ->whereDate('tbl_receipt.created_at', '<=', $end_date)
                ->get();
        } else if (isset($start_date) && !isset($end_date)) {
            $queryReceipt->whereDate('tbl_receipt.created_at', '>=', $start_date)
                ->get();
        } else if (!isset($start_date) && isset($end_date)) {
            $queryReceipt->whereDate('tbl_receipt.created_at', '<=', $end_date)
                ->get();
        } else {
            $queryReceipt->whereBetween('tbl_receipt.created_at', [$firstDay, $lastDay])
                ->get();
        }

        return $queryReceipt->get();
    }

    public function getTotalReceipt($monthYear)
    {
        $year = date('Y', strtotime($monthYear));
        $month = date('m', strtotime($monthYear));

        return Receipt::leftJoin('tbl_invdtl', 'tbl_invdtl.invdtl_id', '=', 'tbl_receipt.invdtl_id')
            ->leftJoin('tbl_invb2b', 'tbl_invb2b.invb2b_id', '=', DB::raw('(CASE WHEN tbl_receipt.invdtl_id is not null THEN tbl_invdtl.invb2b_id ELSE tbl_receipt.invb2b_id END)'))
            ->leftJoin('tbl_inv', 'tbl_inv.inv_id', '=', DB::raw('(CASE WHEN tbl_receipt.invdtl_id is not null THEN tbl_invdtl.inv_id ELSE tbl_receipt.inv_id END)'))
            ->leftJoin('tbl_client_prog', 'tbl_client_prog.clientprog_id', '=', 'tbl_inv.clientprog_id')
            ->leftJoin('tbl_sch_prog', 'tbl_sch_prog.id', '=', 'tbl_invb2b.schprog_id')
            ->leftJoin('tbl_partner_prog', 'tbl_partner_prog.id', '=', 'tbl_invb2b.partnerprog_id')
            ->leftJoin('tbl_referral', 'tbl_referral.id', '=', 'tbl_invb2b.ref_id')
            ->select(DB::raw('COUNT(tbl_receipt.id) as count_receipt'), DB::raw('CAST(SUM(receipt_amount_idr) as integer) as total'))
            ->whereYear('tbl_receipt.created_at', '=', $year)
            ->whereMonth('tbl_receipt.created_at', '=', $month)
            ->where(
                DB::raw('(CASE
                            WHEN tbl_receipt.invdtl_id is not null THEN 
                            (CASE
                                WHEN tbl_invdtl.invb2b_id is not null THEN  
                                    (CASE 
                                        WHEN tbl_invb2b.schprog_id > 0 THEN tbl_sch_prog.status
                                        WHEN tbl_invb2b.partnerprog_id > 0 THEN tbl_partner_prog.status
                                        WHEN tbl_invb2b.ref_id > 0 THEN tbl_referral.referral_type
                                    END)
                                WHEN tbl_invdtl.inv_id is not null THEN tbl_client_prog.status
                            END)
                            WHEN tbl_receipt.inv_id is not null THEN tbl_client_prog.status
                            WHEN tbl_invb2b.schprog_id is not null THEN tbl_sch_prog.status
                            WHEN tbl_invb2b.partnerprog_id is not null THEN tbl_partner_prog.status
                            WHEN tbl_invb2b.ref_id > 0 THEN tbl_referral.referral_type
                    END)'),
                DB::raw('(CASE
                                WHEN tbl_invb2b.ref_id > 0 THEN "Out"
                                ELSE 1
                            END)')
            )
            ->groupBy(DB::raw('(CASE
                                    WHEN tbl_receipt.invb2b_id is not null THEN tbl_invb2b.invb2b_id
                                    WHEN tbl_receipt.inv_id is not null THEN tbl_inv.inv_id
                                END)'))
            ->get();
    }

    # CRM
    public function getAllReceiptFromCRM()
    {
        return V1Receipt::all();
    }

    public function getReceiptDifferences()
    {
        $receipt_v2 = Receipt::pluck('receipt_id')->toArray();

        return V1Receipt::whereNotIn('receipt_id', $receipt_v2)->get();
    }
}
