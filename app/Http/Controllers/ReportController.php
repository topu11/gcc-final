<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Dropdown List
        $data['courts'] = DB::table('court')->select('id', 'court_name')->get();
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['getMonth'] = date('M', mktime(0, 0, 0));

        $data['page_title'] = 'রিপোর্ট'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('report.index')->with($data);
    }

    public function caselist()
    {
        // Dropdown List
        $data['courts'] = DB::table('court')->select('id', 'court_name')->get();
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['getMonth'] = date('M', mktime(0, 0, 0));

        $data['page_title'] = 'মামলার রিপোর্ট ফরম'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('report.caselist')->with($data);
    }

    public function pdf_generate(Request $request)
    {
        

        if ($request->btnsubmit == 'pdf_payment_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক অর্থ আদায়ের রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            $data['year'] = $request->year;
            $data['month'] = $request->month;

            $data['date_start']=$request->date_start;
            $data['date_end']=$request->date_end;

            foreach ($data['divisions'] as $key => $value) {
                $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['claimed'] = $this->payment_claimed_amount_count_by_division($value->id, $data);
                $data['results'][$key]['received'] = $this->payment_received_amount_count_by_division($value->id, $data);
                
            }

            $html = view('report.pdf_payment_by_division')->with($data);

            $this->generatePamentPDF($html);
        }



        if ($request->btnsubmit == 'pdf_payment_district') {

             $request->validate([
                'division' => 'required',
            ],
                [
                    'division.required' => 'বিভাগ নির্বাচন করুন',
                ]);
            $data['page_title'] = 'জেলা ভিত্তিক অর্থ আদায়ের রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();

            $data['year'] = $request->year;
            $data['month'] = $request->month;

            $data['date_start']=$request->date_start;
            $data['date_end']=$request->date_end;

            foreach ($data['districts'] as $key => $value) {
                $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['claimed'] = $this->payment_claimed_amount_count_by_district($value->id, $data);
                $data['results'][$key]['received'] = $this->payment_received_amount_count_by_district($value->id, $data);
                
            }

            $html = view('report.pdf_payment_by_district')->with($data);

            $this->generatePamentPDF($html);
        }


        



        if ($request->btnsubmit == 'pdf_payment_upazila') {

             $request->validate([
                'division' => 'required',
                'district' => 'required',
            ],
                [
                    'division.required' => 'বিভাগ নির্বাচন করুন',
                    'district.required' => 'জেলা নির্বাচন করুন',
                ]);
            $data['page_title'] = 'উপজেলা ভিত্তিক অর্থ আদায়ের রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $request->district)->get();

            $data['year'] = $request->year;
            $data['month'] = $request->month;

            $data['date_start']=$request->date_start;
            $data['date_end']=$request->date_end;

            foreach ($data['upazilas'] as $key => $value) {
                $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['claimed'] = $this->payment_claimed_amount_count_by_upazila($value->id, $data);
                $data['results'][$key]['received'] = $this->payment_received_amount_count_by_upazila($value->id, $data);
                
            }

            $html = view('report.pdf_payment_by_upazila')->with($data);

            $this->generatePamentPDF($html);
        }


        if ($request->btnsubmit == 'pdf_num_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
            
            $data['year'] = $request->year;
            $data['month'] = $request->month;

            $data['date_start']=$request->date_start;
            $data['date_end']=$request->date_end;

            foreach ($data['divisions'] as $key => $value) {
                $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['ON_TRIAL'] = $this->case_count_status_by_division('ON_TRIAL', $value->id, $data);
                $data['results'][$key]['SEND_TO_GCO'] = $this->case_count_status_by_division('SEND_TO_GCO', $value->id, $data);
                $data['results'][$key]['SEND_TO_ASST_GCO'] = $this->case_count_status_by_division('SEND_TO_ASST_GCO', $value->id, $data);
                $data['results'][$key]['SEND_TO_DC'] = $this->case_count_status_by_division('SEND_TO_DC', $value->id, $data);
                $data['results'][$key]['SEND_TO_DIV_COM'] = $this->case_count_status_by_division('SEND_TO_DIV_COM', $value->id, $data);
                $data['results'][$key]['SEND_TO_LAB_CM'] = $this->case_count_status_by_division('SEND_TO_LAB_CM', $value->id, $data);
                $data['results'][$key]['CLOSED'] = $this->case_count_status_by_division('CLOSED', $value->id, $data);
                $data['results'][$key]['REJECTED'] = $this->case_count_status_by_division('REJECTED', $value->id, $data);
            }

            $html = view('report.pdf_num_division')->with($data);

            $this->generatePDF($html);
        }

        if ($request->btnsubmit == 'pdf_case') {
            $data['page_title'] = 'মামলার তালিকা'; //exit;
            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;
            $data['division'] = $request->division;
            $data['district'] = $request->district;

            // Validation
            $request->validate(
                ['date_start' => 'required', 'date_end' => 'required'],
                ['date_start.required' => 'মামলা শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => 'মামলা শেষের তারিখ নির্বাচন করুন']
            );

            // Get Division
            // $data['court'] = DB::table('court')->select('id', 'court_name')->where('id', $request->court)->first();
            $data['results'] = $this->case_list_filter($data);
            // return $data;

            $html = view('report.pdf_case')->with($data);
            // Generate PDF
            $this->generatePamentPDF($html);
        }

        if ($request->btnsubmit == 'pdf_num_district') {
            $data['page_title'] = 'জেলা ভিত্তিক রিপোর্ট'; //exit;

            // Validation
            $request->validate(
                ['division' => 'required'],
                ['division.required' => 'বিভাগ নির্বাচন করুন']
            );

            $data['year'] = $request->year;
            $data['month'] = $request->month;

            $data['date_start']=$request->date_start;
            $data['date_end']=$request->date_end;

            $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();

            foreach ($data['districts'] as $key => $value) {
                $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['ON_TRIAL'] = $this->case_count_status_by_district('ON_TRIAL', $value->id, $data);
                $data['results'][$key]['SEND_TO_GCO'] = $this->case_count_status_by_district('SEND_TO_GCO', $value->id, $data);
                $data['results'][$key]['SEND_TO_ASST_GCO'] = $this->case_count_status_by_district('SEND_TO_ASST_GCO', $value->id, $data);
                $data['results'][$key]['SEND_TO_DC'] = $this->case_count_status_by_district('SEND_TO_DC', $value->id, $data);
                $data['results'][$key]['SEND_TO_DIV_COM'] = $this->case_count_status_by_district('SEND_TO_DIV_COM', $value->id, $data);
                $data['results'][$key]['SEND_TO_LAB_CM'] = $this->case_count_status_by_district('SEND_TO_LAB_CM', $value->id, $data);
                $data['results'][$key]['CLOSED'] = $this->case_count_status_by_district('CLOSED', $value->id, $data);
                $data['results'][$key]['REJECTED'] = $this->case_count_status_by_district('REJECTED', $value->id, $data);
            }

            $html = view('report.pdf_num_district')->with($data);

            $this->generatePDF($html);
        }
        if ($request->btnsubmit == 'pdf_num_upazila') {
            $data['page_title'] = 'উপজেলা ভিত্তিক রিপোর্ট'; //exit;
            // dd($request->division);

            $request->validate([
                'division' => 'required',
                'district' => 'required',
            ],
                [
                    'division.required' => 'বিভাগ নির্বাচন করুন',
                    'district.required' => 'জেলা নির্বাচন করুন',
                ]);
            $data['year'] = $request->year;
            $data['month'] = $request->month;
            $data['date_start']=$request->date_start;
            $data['date_end']=$request->date_end;



            $data['upazilas'] = DB::table('upazila')->select('id', 'district_id', 'upazila_name_bn')->where('district_id', $request->district)->get();


            foreach ($data['upazilas'] as $key => $value) {
                $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['ON_TRIAL'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data);
                $data['results'][$key]['SEND_TO_GCO'] = $this->case_count_status_by_upazila('SEND_TO_GCO', $value->id, $data);
                $data['results'][$key]['SEND_TO_ASST_GCO'] = $this->case_count_status_by_upazila('SEND_TO_ASST_GCO', $value->id, $data);
                $data['results'][$key]['SEND_TO_DC'] = $this->case_count_status_by_upazila('SEND_TO_DC', $value->id, $data);
                $data['results'][$key]['SEND_TO_DIV_COM'] = $this->case_count_status_by_upazila('SEND_TO_DIV_COM', $value->id, $data);
                $data['results'][$key]['SEND_TO_LAB_CM'] = $this->case_count_status_by_upazila('SEND_TO_LAB_CM', $value->id, $data);
                $data['results'][$key]['CLOSED'] = $this->case_count_status_by_upazila('CLOSED', $value->id, $data);
                $data['results'][$key]['REJECTED'] = $this->case_count_status_by_upazila('REJECTED', $value->id, $data);
            }

            $html = view('report.pdf_num_upazila')->with($data);

            $this->generatePDF($html);
        }


    }

    public function case_list_filter($data){
        $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
        $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));

        // Query
        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status','ON_TRIAL')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $ON_TRIAL = $query->count();



        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status','SEND_TO_GCO')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $SEND_TO_GCO = $query->count();


            $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status','SEND_TO_ASST_GCO')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $SEND_TO_ASST_GCO = $query->count();



        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status','SEND_TO_DC')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $SEND_TO_DC = $query->count();



        $query = DB::table('gcc_appeals')
        ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
        ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
        ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
        ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
        ->where('gcc_appeals.appeal_status','SEND_TO_DIV_COM')
        ->orderBy('id', 'DESC');
    // ->where('gcc_appeals.id', '=', 29);
    if ($dateFrom != 0 && $dateTo != 0) {
        $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
    }
    if (!empty($data['division'])) {
        $query->where('gcc_appeals.division_id', $data['division']);
    }
    if (!empty($data['district'])) {
        $query->where('gcc_appeals.district_id', $data['district']);
    }
    if (!empty($data['upazila'])) {
        $query->where('gcc_appeals.upazila_id', $data['upazila']);
    }
    $SEND_TO_DIV_COM = $query->count();



    $query = DB::table('gcc_appeals')
        ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
        ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
        ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
        ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
        ->where('gcc_appeals.appeal_status','SEND_TO_LAB_CM')
        ->orderBy('id', 'DESC');
    // ->where('gcc_appeals.id', '=', 29);
    if ($dateFrom != 0 && $dateTo != 0) {
        $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
    }
    if (!empty($data['division'])) {
        $query->where('gcc_appeals.division_id', $data['division']);
    }
    if (!empty($data['district'])) {
        $query->where('gcc_appeals.district_id', $data['district']);
    }
    if (!empty($data['upazila'])) {
        $query->where('gcc_appeals.upazila_id', $data['upazila']);
    }
    $SEND_TO_LAB_CM = $query->count();



    $query = DB::table('gcc_appeals')
        ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
        ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
        ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
        ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
        ->where('gcc_appeals.appeal_status','CLOSED')
        ->orderBy('id', 'DESC');
    // ->where('gcc_appeals.id', '=', 29);
    if ($dateFrom != 0 && $dateTo != 0) {
        $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
    }
    if (!empty($data['division'])) {
        $query->where('gcc_appeals.division_id', $data['division']);
    }
    if (!empty($data['district'])) {
        $query->where('gcc_appeals.district_id', $data['district']);
    }
    if (!empty($data['upazila'])) {
        $query->where('gcc_appeals.upazila_id', $data['upazila']);
    }
    $CLOSED = $query->count();





    $query = DB::table('gcc_appeals')
        ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
        ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
        ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
        ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
        ->where('gcc_appeals.appeal_status','REJECTED')
        ->orderBy('id', 'DESC');
    // ->where('gcc_appeals.id', '=', 29);
    if ($dateFrom != 0 && $dateTo != 0) {
        $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
    }
    if (!empty($data['division'])) {
        $query->where('gcc_appeals.division_id', $data['division']);
    }
    if (!empty($data['district'])) {
        $query->where('gcc_appeals.district_id', $data['district']);
    }
    if (!empty($data['upazila'])) {
        $query->where('gcc_appeals.upazila_id', $data['upazila']);
    }
    $REJECTED = $query->count();

        $data=[
            'ON_TRIAL'=>$ON_TRIAL,
            'SEND_TO_GCO'=>$SEND_TO_GCO,
            'SEND_TO_ASST_GCO'=>$SEND_TO_ASST_GCO,
            'SEND_TO_DC'=>$SEND_TO_DC,
            'SEND_TO_DIV_COM'=>$SEND_TO_DIV_COM,
            'SEND_TO_LAB_CM'=>$SEND_TO_LAB_CM,
            'CLOSED'=>$CLOSED,
            'REJECTED'=>$REJECTED

        ];

        return $data;
     }

    public function case_count_status_by_upazila($status, $id, $data)
    {
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;

        }
        $query = DB::table('gcc_appeals')->where('upazila_id', $id)->where('appeal_status', $status);

        if ($dateFrom != 0 && $dateTo != 0) {

            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->count();
    }

    public function case_count_status_by_district ($status, $id, $data)
    {
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;

        }
        $query = DB::table('gcc_appeals')->where('district_id', $id)->where('appeal_status', $status);

        if ($dateFrom != 0 && $dateTo != 0) {

            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->count();
    }

    public function case_count_status_by_division($status, $id, $data)
    {

        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;

        }
        $query = DB::table('gcc_appeals')->where('division_id', $id)->where('appeal_status', $status);
        if ($dateFrom != 0 && $dateTo != 0) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->count();
        // return $query;
    }


    

    public function payment_claimed_amount_count_by_division($id, $data)
    {
        // dd($id);
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;

        }
        $query = DB::table('gcc_appeals')->where('division_id', $id)->whereNotIn('appeal_status',['REJECTED']);
        if ($dateFrom != 0 && $dateTo != 0) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->sum('loan_amount');
        // return $query;
    }


    public function payment_received_amount_count_by_division($id, $data)
    {
        // dd($id);
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;

        }
        $appealId = DB::table('gcc_appeals')->where('division_id', $id)->whereNotIn('appeal_status',['REJECTED'])->select('id')->get();
        $query = 0;
        foreach($appealId as $value)
        {
            $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');

            if ($dateFrom != 0 && $dateTo != 0) {
                // dd($dateFrom);

                $appealId->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);

                foreach($appealId as $value)
                {
                    $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');

                }
                $query= $query+$query;
            }
        }
        return $query;
        // return $query;
    }



    public function payment_claimed_amount_count_by_district($id, $data)
    {
        // dd($id);
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;

        }
        $query = DB::table('gcc_appeals')->where('district_id', $id)->whereNotIn('appeal_status',['REJECTED']);
        if ($dateFrom != 0 && $dateTo != 0) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->sum('loan_amount');
        // return $query;
    }
    


    public function payment_received_amount_count_by_district($id, $data)
    {
        // dd($id);
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;

        }
        $appealId = DB::table('gcc_appeals')->where('district_id', $id)->whereNotIn('appeal_status',['REJECTED'])->select('id')->get();
        $query = 0;
        foreach($appealId as $value)
        {
            $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');

            if ($dateFrom != 0 && $dateTo != 0) {
                // dd($dateFrom);

                $appealId->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);

                foreach($appealId as $value)
                {
                    $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');

                }
                $query= $query+$query;
            }
        }
        return $query;
        // return $query;
    }


    



    public function payment_claimed_amount_count_by_upazila($id, $data)
    {
        // dd($id);
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;

        }
        $query = DB::table('gcc_appeals')->where('upazila_id', $id)->whereNotIn('appeal_status',['REJECTED']);
        if ($dateFrom != 0 && $dateTo != 0) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->sum('loan_amount');
        // return $query;
    }
    


    public function payment_received_amount_count_by_upazila($id, $data)
    {
        // dd($id);
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;

        }
        $appealId = DB::table('gcc_appeals')->where('upazila_id', $id)->whereNotIn('appeal_status',['REJECTED'])->select('id')->get();
        $query = 0;
        foreach($appealId as $value)
        {
            $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');

            if ($dateFrom != 0 && $dateTo != 0) {
                // dd($dateFrom);

                $appealId->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);

                foreach($appealId as $value)
                {
                    $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');

                }
                $query= $query+$query;
            }
        }
        return $query;
        // return $query;
    }


    public function generatePDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-L',
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }


    public function generatePamentPDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->btnsubmit == 'pdf_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক রিপোর্ট'; //exit;
            $html = view('report.pdf_division')->with($data);
            // echo 'hello';

            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 12,
                'default_font' => 'kalpurush',
            ]);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
    //    {
    //       //
    //    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
