<?php

namespace App\Repositories;

use App\Interfaces\InvoicesRepositoryInterface;
use App\Models\Invb2b;
use App\Models\InvoiceProgram;
use App\Models\Lead;
use App\Models\OutstandingPaymentView;
use App\Models\v1\Lead as V1Lead;
use DataTables;
use Illuminate\Support\Facades\DB;

class InvoicesRepository implements InvoicesRepositoryInterface
{
    public function getOustandingPaymentDataTables($monthYear)
    {
        $model_invB2b = $this->getOutstandingPaymentFromB2b($monthYear);
        $model_invProgram = $this->getOutstandingPaymentFromClientProgram($monthYear);

        $query_invB2b = str_replace(['?'], ['\'%s\''], $model_invB2b->toSql());
        $query_invB2b = vsprintf($query_invB2b, $model_invB2b->getBindings());

        $query_invB2c = str_replace(['?'], ['\'%s\''], $model_invProgram->toSql());
        $query_invB2c = vsprintf($query_invB2c, $model_invProgram->getBindings());
        
        $model = DB::table(DB::raw("({$query_invB2b} UNION {$query_invB2c}) A"));

        // $model = $this->getOutstandingPayments($monthYear);

        return Datatables::of($model)
                
                // ->filterColumn('invoice_id', function ($query, $keyword) {
                //     $sql = "tbl_invb2b.invb2b_id like ? or tbl_inv.inv_id like ?";
                //     $query->whereRaw($sql, ["%{$keyword}%", "%{$keyword}%"]);
                // })
                ->make(true);
    }

    private function getOutstandingPayments($monthYear)
    {
        $start_date = $end_date = null;

        $query = OutstandingPaymentView::query();

        if (isset($monthYear)) {
            $year = date('Y', strtotime($monthYear));
            $month = date('m', strtotime($monthYear));

            $query->whereYear('invoice_duedate', '=', $year)->whereMonth('invoice_duedate', '=', $month);
        } else {
            $query->whereBetween('invoice_duedate', [$start_date, $end_date]);
        }

        return $query;
    }

    private function getOutstandingPaymentFromClientProgram($monthYear)
    {
        $start_date = $end_date = null;
        
        $whereBy = DB::raw('(CASE
                            WHEN tbl_inv.inv_paymentmethod = "Full Payment" THEN 
                                tbl_inv.inv_duedate 
                            WHEN tbl_inv.inv_paymentmethod = "Installment" THEN 
                                tbl_invdtl.invdtl_duedate
                        END)');

        if (isset($monthYear)) {
            $year = date('Y', strtotime($monthYear));
            $month = date('m', strtotime($monthYear));
        }

        $query = InvoiceProgram::leftJoin('tbl_invdtl', 'tbl_invdtl.inv_id', '=', 'tbl_inv.inv_id')
            ->leftJoin(
                'tbl_receipt',
                DB::raw('(CASE
                        WHEN tbl_inv.inv_paymentmethod = "Full Payment" THEN 
                            tbl_receipt.inv_id 
                        WHEN tbl_inv.inv_paymentmethod = "Installment" THEN 
                                tbl_receipt.invdtl_id
                        ELSE null
                    END )'),
                DB::raw('CASE
                        WHEN tbl_inv.inv_paymentmethod = "Full Payment" THEN 
                            tbl_inv.inv_id 
                        WHEN tbl_inv.inv_paymentmethod = "Installment" THEN 
                                tbl_invdtl.invdtl_id
                        ELSE null
                    END')
            )
            ->leftJoin('tbl_client_prog', 'tbl_client_prog.clientprog_id', '=', 'tbl_inv.clientprog_id')
            ->leftJoin('program', 'program.prog_id', '=', 'tbl_client_prog.prog_id')
            ->leftJoin('tbl_client as child', 'child.id', '=', 'tbl_client_prog.client_id')
            ->leftJoin('tbl_client_relation', 'tbl_client_relation.child_id', '=', 'child.id')
            ->leftJoin('tbl_client as parent', 'parent.id', '=', 'tbl_client_relation.parent_id')
            ->select(
                'tbl_inv.id',
                'tbl_inv.inv_id as invoice_id',
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_inv.inv_id, '/', 1), '/', -1) as 'inv_id_num'"),
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_inv.inv_id, '/', 4), '/', -1) as 'inv_id_month'"),
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_inv.inv_id, '/', 5), '/', -1) as 'inv_id_year'"),
                DB::raw('CONCAT(child.first_name, " ", COALESCE(child.last_name, "")) as full_name'),
                'tbl_inv.clientprog_id as client_prog_id',
                'program.program_name',
                'tbl_invdtl.invdtl_installment as installment_name',
                DB::raw("'B2C' as type"),
                DB::raw('
                    (CASE
                        WHEN tbl_inv.inv_paymentmethod = "Full Payment" THEN 
                            tbl_inv.inv_totalprice_idr 
                        WHEN tbl_inv.inv_paymentmethod = "Installment" THEN 
                            tbl_invdtl.invdtl_amountidr
                        ELSE null
                    END) as total'),
                DB::raw('
                    (CASE 
                        WHEN tbl_inv.inv_paymentmethod = "Full Payment" THEN 
                            tbl_inv.inv_duedate 
                        WHEN tbl_inv.inv_paymentmethod = "Installment" THEN 
                            tbl_invdtl.invdtl_duedate
                    END) as invoice_duedate'),
                'tbl_inv.clientprog_id',
                'child.id as client_id',
                'child.phone as child_phone',
                'parent.phone as parent_phone',
                DB::raw('CONCAT(parent.first_name, " ", COALESCE(parent.last_name, "")) as parent_name'),
                'parent.id as parent_id',
                DB::raw("'client_prog' as typeprog")
            )->whereNull('tbl_receipt.id');

            if (isset($monthYear)) {
                $query->whereYear($whereBy, '=', $year)
                    ->whereMonth($whereBy, '=', $month);
            } else {
                $query->whereBetween($whereBy, [$start_date, $end_date]);
            }

        $query->whereRelation('clientprog', 'status', 1);

        return $query;
    }

    private function getOutstandingPaymentFromB2b($monthYear)
    {
        $start_date = $end_date = null;

        $whereBy = DB::raw('(CASE
                            WHEN tbl_invb2b.invb2b_pm = "Full Payment" THEN 
                                tbl_invb2b.invb2b_duedate 
                            WHEN tbl_invb2b.invb2b_pm = "Installment" THEN 
                                tbl_invdtl.invdtl_duedate
                        END)');

        if (isset($monthYear)) {
            $year = date('Y', strtotime($monthYear));
            $month = date('m', strtotime($monthYear));
        }

        $query = Invb2b::leftJoin('tbl_invdtl', 'tbl_invdtl.invb2b_id', '=', 'tbl_invb2b.invb2b_id')
                ->leftJoin(
                    'tbl_receipt',
                    DB::raw('(CASE
                            WHEN tbl_invb2b.invb2b_pm = "Full Payment" THEN 
                                tbl_receipt.invb2b_id 
                            WHEN tbl_invb2b.invb2b_pm = "Installment" THEN 
                                    tbl_receipt.invdtl_id
                            ELSE null
                        END )'),
                    DB::raw('CASE
                            WHEN tbl_invb2b.invb2b_pm = "Full Payment" THEN 
                                tbl_invb2b.invb2b_id 
                            WHEN tbl_invb2b.invb2b_pm = "Installment" THEN 
                                    tbl_invdtl.invdtl_id
                            ELSE null
                        END')
                )
                ->leftJoin('tbl_sch_prog', 'tbl_sch_prog.id', '=', 'tbl_invb2b.schprog_id')
                ->leftJoin('tbl_sch', 'tbl_sch_prog.sch_id', '=', 'tbl_sch.sch_id')
                ->leftJoin('tbl_partner_prog', 'tbl_partner_prog.id', '=', 'tbl_invb2b.partnerprog_id')
                ->leftJoin('tbl_referral', 'tbl_referral.id', '=', 'tbl_invb2b.ref_id')
                ->leftJoin('tbl_corp', 'tbl_corp.corp_id', '=', DB::raw('(CASE WHEN tbl_invb2b.partnerprog_id > 0 THEN tbl_partner_prog.corp_id WHEN tbl_invb2b.ref_id > 0 THEN tbl_referral.partner_id ELSE NULL END)'))
                ->leftJoin(
                    'program',
                    'program.prog_id',
                    '=',
                    DB::raw('(CASE 
                                WHEN tbl_invb2b.schprog_id > 0 THEN tbl_sch_prog.prog_id
                                    WHEN tbl_invb2b.partnerprog_id > 0 THEN tbl_partner_prog.prog_id
                                ELSE NULL
                                END)')
                )->select(
                    'tbl_invb2b.invb2b_num as id',
                    'tbl_invb2b.invb2b_id as invoice_id',
                    DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_invb2b.invb2b_id, '/', 1), '/', -1) as 'inv_id_num'"),
                    DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_invb2b.invb2b_id, '/', 4), '/', -1) as 'inv_id_month'"),
                    DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_invb2b.invb2b_id, '/', 5), '/', -1) as 'inv_id_year'"),
                    DB::raw('(CASE 
                                WHEN tbl_invb2b.schprog_id > 0 THEN tbl_sch.sch_name
                                WHEN tbl_invb2b.partnerprog_id > 0 THEN tbl_corp.corp_name
                                WHEN tbl_invb2b.ref_id > 0 THEN tbl_corp.corp_name
                            ELSE NULL
                            END) COLLATE utf8mb4_general_ci as full_name'),
                    DB::raw('(CASE 
                                WHEN tbl_invb2b.schprog_id > 0 THEN tbl_invb2b.schprog_id
                                WHEN tbl_invb2b.partnerprog_id > 0 THEN tbl_invb2b.partnerprog_id
                                WHEN tbl_invb2b.ref_id > 0 THEN tbl_invb2b.ref_id
                            ELSE NULL
                            END) as client_prog_id'),
                    DB::raw('(CASE
                        WHEN tbl_invb2b.ref_id > 0 THEN tbl_referral.additional_prog_name 
                        ELSE
                            program.program_name
                    END) AS program_name'),
                    'tbl_invdtl.invdtl_installment as installment_name',
                    DB::raw("'B2B' as type"),
                    DB::raw('(CASE
                            WHEN tbl_invb2b.invb2b_pm = "Full Payment" THEN 
                                tbl_invb2b.invb2b_totpriceidr 
                            WHEN tbl_invb2b.invb2b_pm = "Installment" THEN 
                                tbl_invdtl.invdtl_amountidr
                            ELSE null
                        END) as total'),
                    DB::raw('(CASE
                            WHEN tbl_invb2b.invb2b_pm = "Full Payment" THEN 
                                tbl_invb2b.invb2b_duedate
                            WHEN tbl_invb2b.invb2b_pm = "Installment" THEN 
                                tbl_invdtl.invdtl_duedate
                            ELSE null
                        END) as invoice_duedate'),
                    
                    DB::raw("null as clientprog_id"),
                    DB::raw("null as client_id"),
                    DB::raw("null as child_phone"),
                    DB::raw("null as parent_phone"),
                    DB::raw("null as parent_name"),
                    DB::raw("null as parent_id"),
                    DB::raw('(CASE 
                        WHEN tbl_invb2b.schprog_id > 0 THEN "sch_prog"
                        WHEN tbl_invb2b.partnerprog_id > 0 THEN "partner_prog"
                        WHEN tbl_invb2b.ref_id > 0 THEN "referral"
                    ELSE NULL
                    END) as typeprog'),

                )->whereNull('tbl_receipt.id');
        
                if (isset($monthYear)) {
                    $query->whereYear($whereBy, '=', $year)
                        ->whereMonth($whereBy, '=', $month);
                } else {
                    $query->whereBetween($whereBy, [$start_date, $end_date]);
                }
                
        
                $query->where(
                    DB::raw('(CASE
                                WHEN tbl_invb2b.schprog_id > 0 THEN tbl_sch_prog.status
                                WHEN tbl_invb2b.partnerprog_id > 0 THEN tbl_partner_prog.status
                                WHEN tbl_invb2b.ref_id > 0 THEN tbl_referral.referral_type
                            ELSE NULL
                            END)'),
                    DB::raw('(CASE
                                WHEN tbl_invb2b.ref_id > 0 THEN "Out"
                            ELSE 1
                            END)')
                );
                // ->orderBy('inv_id_year', 'asc')
                // ->orderBy('inv_id_month', 'asc')
                // ->orderBy('inv_id_num', 'asc');

        return $query;
    }
}