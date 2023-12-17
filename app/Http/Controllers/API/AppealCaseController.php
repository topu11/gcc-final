<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\CaseHearing;
// use Validator;
use App\Models\GccAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use Validator;

class AppealCaseController extends BaseController
{
    public function test()
    {
        $data[] = "Test";
        return $this->sendResponse($data, 'test successfully.');
    }

    // use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function court_execute(Request $request)
    {
        $data = [];

        $roleID = $request->role_id;
        $status = $request->status;
        $court_id = $request->court_id;
        $division_id = $request->division_id;
        $userID = $request->user_id;
        $district_id = $request->district_id;
        $office_id = $request->office_id;

        $offset = 0;
        $limit = 3;
        if (($request->page != 1) && ($request->page != 0)) {
            $offset = ($request->page - 1) * $limit;
        }

        $data = array();
        if ($roleID == 1) {

            if (isset($status)) {
                $appeal = GccAppeal::where('appeal_status', $status);
            } else {
                $appeal = GccAppeal::whereNotIn('appeal_status', ['DRAFT']);
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            // $appeal = GccAppeal::where('appeal_status', $status);
            $data['total_case'] = $appeal->count();
            $data['appeal'] = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'Superadmi Data.');

        } else if ($roleID == 2) {
            $moujaIDs = DB::table('mouja_ulo')->where('ulo_office_id', $office_id)->pluck('mouja_id');

            if (isset($status)) {
                $appeal = GccAppeal::where('appeal_status', $status)->where('mouja_id', [$moujaIDs]);
            } else {
                $appeal = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->where('mouja_id', [$moujaIDs]);
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total_case'] = $appeal->count();
            $data['appeal'] = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'The secretary Data.');

        } else if ($roleID == 6) {

            if (isset($status)) {
                $appeal = GccAppeal::where('appeal_status', $status)->where('district_id', $district_id);
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total_case'] = $appeal->count();
            $appeal = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();
           
            foreach($appeal as $single_appeal)
           {
              $single_appeal->court_name=$this->get_court_name($single_appeal->court_id);
              $single_appeal->applicant_name=$this->get_applicant_name($single_appeal->id);
           } 
            
           $data['appeal'] = $appeal;

            return $this->sendResponse($data, 'District Commissioner Data.');

        } else if ($roleID == 24) {

            if (isset($status)) {
                $appeal = GccAppeal::where('appeal_status', $status)->where('updated_by', $userID);
            } else {
                $appeal = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->where('updated_by', $userID);
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total_case'] = $appeal->count();
            $data['appeal'] = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'LAB Chairman Data.');

        } else if ($roleID == 25) {

            if (isset($status)) {
                $appeal = GccAppeal::where('appeal_status', $status)->where('updated_by', $userID);
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total_case'] = $appeal->count();
            $appeal = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();
           
            foreach($appeal as $single_appeal)
           {
              $single_appeal->court_name=$this->get_court_name($single_appeal->court_id);
              $single_appeal->applicant_name=$this->get_applicant_name($single_appeal->id);
           } 
            
           $data['appeal'] = $appeal;

            return $this->sendResponse($data, 'LAB Chairman Data.');

        } else if ($roleID == 27) {

            if (isset($status)) {

                if ($status == 'SEND_TO_GCO') {
                    $appeal = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO', 'SEND_TO_GCO'])->where('court_id', $court_id);
                } else {

                    $appeal = GccAppeal::where('appeal_status', $status)->where('court_id', $court_id);
                }
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            // $appeal = GccAppeal::where('appeal_status', $status)->where('court_id', $court_id);
            $data['total_case'] = $appeal->count();
            $appeal = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();
           
            foreach($appeal as $single_appeal)
           {
              $single_appeal->court_name=$this->get_court_name($single_appeal->court_id);
              $single_appeal->applicant_name=$this->get_applicant_name($single_appeal->id);
           } 
            
           $data['appeal'] = $appeal;

            return $this->sendResponse($data, 'GCO Data.');
        } else if ($roleID == 28) {
            // asst GCO dashboard

            if (isset($status)) {
                $appeal = GccAppeal::where('appeal_status', $status)->where('court_id', $court_id);
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            // $appeal = GccAppeal::where('appeal_status', $status)->where('court_id', $court_id);
            $data['total_case'] = $appeal->count();
            $appeal = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();
           
            foreach($appeal as $single_appeal)
           {
              $single_appeal->court_name=$this->get_court_name($single_appeal->court_id);
              $single_appeal->applicant_name=$this->get_applicant_name($single_appeal->id);
           } 
            
           $data['appeal'] = $appeal;

            return $this->sendResponse($data, 'Asst. GCO Data.');

        } else if ($roleID == 32) {

            if (isset($status)) {
                $appeal = GccAppeal::where('appeal_status', $status)->where('court_id', $court_id);
            } else {
                $appeal = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->where('court_id', $court_id);
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total_case'] = $appeal->count();
            $data['appeal'] = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'Sub Register Data.');

        } else if ($roleID == 33) {
            // asst GCO dashboard

            if (isset($status)) {
                $appeal = GccAppeal::where('appeal_status', $status)->where('updated_by', $userID);
            } else {
                $appeal = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->where('updated_by', $userID);
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            // $appeal = GccAppeal::where('appeal_status', $status)->where('updated_by', $userID);
            $data['total_case'] = $appeal->count();
            $data['appeal'] = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'Officer incharge Data.');

        } else if ($roleID == 34) {

            if (isset($status)) {
                $appeal = GccAppeal::where('appeal_status', $status)->where('division_id', $division_id);
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            // $appeal = GccAppeal::where('appeal_status', $status)->where('division_id', $division_id);
            $data['total_case'] = $appeal->count();
            $appeal = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();
           
            foreach($appeal as $single_appeal)
           {
              $single_appeal->court_name=$this->get_court_name($single_appeal->court_id);
              $single_appeal->applicant_name=$this->get_applicant_name($single_appeal->id);
           } 
            
           $data['appeal'] = $appeal;

            return $this->sendResponse($data, 'Divisional Commissioner Data.');

        } else if ($roleID == 35) {

            if (isset($status)) {

                if ($status == 'SEND_TO_ASST_GCO') {
                    $appeal_ids_as_agent = [];
                    $appeal_ids_as_applicant = [];

                    $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                        ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                        ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                        ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                        ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
                        ->whereIn('gcc_appeals.appeal_status', ['SEND_TO_GCO', 'SEND_TO_ASST_GCO'])
                        ->select('gcc_appeal_citizens.appeal_id')
                        ->get();

                    foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                        array_push($appeal_ids_as_agent, $appeal_ids_from_db_single->appeal_id);

                    }

                    $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', globalUserInfo()->id)->whereIn('gcc_appeals.appeal_status', ['SEND_TO_GCO', 'SEND_TO_ASST_GCO'])->select('id')->get();

                    foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
                        array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

                    }
                    $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

                    $appeal = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);
                } else {
                    $appeal_ids_as_agent = [];
                    $appeal_ids_as_applicant = [];

                    $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                        ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                        ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                        ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                        ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
                        ->where('gcc_appeals.appeal_status', $status)
                        ->select('gcc_appeal_citizens.appeal_id')
                        ->get();

                    foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                        array_push($appeal_ids_as_agent, $appeal_ids_from_db_single->appeal_id);

                    }

                    $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', globalUserInfo()->id)->where('appeal_status', $status)->select('id')->get();

                    foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
                        array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

                    }
                    $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

                    $appeal = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);
                }
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total_case'] = $appeal->count();
            $appeal = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();
             
            
           
           foreach($appeal as $single_appeal)
           {
              $single_appeal->court_name=$this->get_court_name($single_appeal->court_id);
              $single_appeal->applicant_name=$this->get_applicant_name($single_appeal->id);
           } 
            
           $data['appeal'] = $appeal;

            return $this->sendResponse($data, 'Organization  Data.');

        } else if ($roleID == 36) {

            if (isset($status)) {

                $status_array=[];

                if($status == 'ON_TRIAL')
                {
                    $status_array=['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM','ON_TRIAL_DIV_COM'];
                }
                elseif($status == 'SEND_TO_ASST_GCO')
                {
                    $status_array=['SEND_TO_DIV_COM', 'SEND_TO_DC', 'SEND_TO_LAB_CM'];
                }
                else
                {
                    $status_array=['CLOSED'];
                }




                $citizen_id = DB::table('gcc_citizens')
                    ->where('citizen_NID', globalUserInfo()->citizen_nid)
                    ->select('id')
                    ->get();

                if (!empty($citizen_id)) {
                    foreach ($citizen_id as $key => $value) {
                        // return $value;
                        $appeal_no = DB::table('gcc_appeal_citizens')
                            ->where('citizen_id', $value->id)
                            ->where('citizen_type_id', 2)
                            ->select('appeal_id')
                            ->get();

                    }
                } else {
                    $appeal_no = null;
                }
                
                $appeal_ids=[];
                if (!empty($appeal_no)) {

                    foreach ($appeal_no as $key => $value) {
                        // return $value->appeal_id;
                        array_push($appeal_ids,$value->appeal_id);
                    }
                } else {
                    $appeal = null;
                }
                
            }
               $appeal = GccAppeal::whereIN('id',$appeal_ids)->whereIN('appeal_status', $status_array);

                        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                            $appeal = $appeal->whereBetween('case_date', [$dateFrom, $dateTo]);
                        }
                        if (!empty($_GET['case_no'])) {
                            $appeal = $appeal->where('case_no', '=', $_GET['case_no']);
                        }
                       
            

            $data['total_case'] = $appeal->count();
            $appeal = $appeal->select('id', 'appeal_status', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_user_id', 'gco_office_id', 'court_id', 'created_at')->offset($offset)->limit($limit)->get();
           
            foreach($appeal as $single_appeal)
           {
              $single_appeal->court_name=$this->get_court_name($single_appeal->court_id);
              $single_appeal->applicant_name=$this->get_applicant_name($single_appeal->id);
           } 
            
           $data['appeal'] = $appeal;


            return $this->sendResponse($data, 'User info Data.');

        } else {
            $data = array();
            return $this->sendResponse($data, 'Sorry dose not fill up requirement.');
        }
    }

    // case details api
    public function appealCaseDetails(Request $request)
    {
        $data = array();

        $data['appeal'] = $this->getCaseAppealInfo($request->id);
        $data['applicantCitizen'] = [];
        $data['defaulterCitizen'] = [];
        $data['lawerCitizen'] = [];
        $data['nomineeCitizen'] = [];
        $citizen_types = $this->getCitizenTypes($request->id);

        foreach ($citizen_types as $row) {
            if ($row->citizen_type_id == 1) {
                $data['applicantCitizen'][] = $this->getCitizenInfo($row->citizen_id);
            }
            if ($row->citizen_type_id == 2) {
                $data['defaulterCitizen'][] = $this->getCitizenInfo($row->citizen_id);
            }

            if ($row->citizen_type_id == 4) {
                $data['lawerCitizen'] = $this->getCitizenInfo($row->citizen_id);
            }
            if ($row->citizen_type_id == 5) {
                $data['nomineeCitizen'][] = $this->getCitizenInfo($row->citizen_id);
            }
        }

        return $this->sendResponse($data, 'Case details Data.');
    }

    public function checkHearingHostStatus($id)
    {
        $appeal = DB::table('gcc_appeals as em')->where('em.id', '=', $id)
            ->select('em.is_hearing_host_active', 'em.next_date_trial_time', 'em.next_date', 'em.hearing_key')
            ->first();
        return $this->sendResponse($appeal, 'Appeal Case Hearing Host Active Check Data.');
    }

    public function hearingHostActiveStatusUpdate($id)
    {
        // dd($id);
        $appeal = DB::table('gcc_appeals')->where('id', '=', $id)->update(
            [
                'is_hearing_host_active' => 1,
            ]
        );
        return $this->sendResponse($appeal, 'Appeal Case Hearing Host Active Status Updated.');
    }

    public function getCitizenInfo($id)
    {
        $citizenInfo = DB::table('gcc_citizens as gcc')->where('gcc.id', '=', $id)
            ->select(
                'gcc.id as citizen_id',
                'gcc.citizen_name',
                'gcc.father',
                'gcc.mother',
                'gcc.citizen_gender',
                'gcc.designation',
                'gcc.organization_id',
                'gcc.organization',
                'gcc.present_address',
                'gcc.citizen_NID',
                'gcc.email',
            )
            ->first();
        return $citizenInfo;
    }

    public function getCitizenTypes($appealId)
    {
        $appeal = DB::table('gcc_appeal_citizens as gcc')->where('gcc.appeal_id', '=', $appealId)
            ->select(
                'gcc.appeal_id as appeal_id',
                'gcc.citizen_id',
                'gcc.citizen_type_id',
            )
            ->get();

        return $appeal;
    }

    public function getCaseAppealInfo($appealId)
    {
        $appeal = DB::table('gcc_appeals as gcc')->where('gcc.id', '=', $appealId)
            ->leftjoin('users', 'gcc.created_by', '=', 'users.id')
            ->leftjoin('role', 'users.role_id', '=', 'role.id')
            ->select(
                'gcc.id as appeal_id',
                'gcc.case_no',
                'gcc.case_date',
                'gcc.case_date',
                'gcc.loan_amount',
                'gcc.loan_amount_text',
                'gcc.appeal_status',
                'gcc.law_section',
                'gcc.district_id',
                'gcc.district_name',
                'gcc.next_date_trial_time',
                'gcc.is_hearing_host_active',
                'gcc.next_date',
                'gcc.hearing_key',
                'gcc.zoom_join_meeting_id',
                'gcc.zoom_join_meeting_password',  
                'users.id as created_user_id',
                'users.name as created_by',
                'users.role_id as role_id',
                'role.role_name as role_name',
            )
            ->first();

        return $appeal;
    }

    //  appeal case tracking details
    // public function appealCaseTracking($id)
    // {
    //     $data = array();
    //     /* $data['appeal'] = DB::table('gcc_appeals as em')->where('em.id', '=', $id)
    //     ->leftjoin('users', 'em.created_by', '=', 'users.id')
    //     ->leftjoin('role', 'users.role_id', '=', 'role.id')
    //     ->select('em.id', 'em.case_no', 'em.case_date', 'em.appeal_status', 'users.name as created_by', 'role.role_name')->get(); */

    //     $data['appeal'] = $this->getCaseAppealInfo($id);
    //     $data['CaseTracking'] = DB::table('gcc_notes as gn')
    //         ->where('gn.appeal_id', $id)
    //         ->leftjoin('gcc_case_shortdecisions as gc', 'gn.case_short_decision_id', '=', 'gc.id')
    //         ->leftjoin('gcc_cause_lists as cc', 'gn.cause_list_id', '=', 'cc.id')
    //         ->select('gn.appeal_id', 'gc.case_short_decision', 'cc.conduct_date')
    //         ->get();

    //     return $this->sendResponse($data, 'Case Tracking Data.');

    // }


    public function appealCaseTracking($id)
    {
        $data = array();
        $data['appeal'] = $this->getCaseAppealInfo($id);
        
         $gcc_notes=DB::table('gcc_notes')->where('appeal_id',$id)->get();
         $CaseTracking=[];
         
         foreach($gcc_notes as $gcc_note_single)
         {
            $CaseTracking_single=[];
            $CaseTracking_single['conduct_date']=explode(' ',$gcc_note_single->created_date)[0];
            $CaseTracking_single['case_short_decision']=$this->get_template_name_by_id($gcc_note_single->case_short_decision_id);

            array_push($CaseTracking,$CaseTracking_single);
         }
         
         
        $data['CaseTracking'] =$CaseTracking;

        return $this->sendResponse($data, 'Appeal Case Tracking Data.');
    }
    
    public function get_template_name_by_id($case_short_decision_id)
    {
         $short_order_template_name= DB::table('gcc_case_shortdecisions')->where('id',$case_short_decision_id)->first();

         return $short_order_template_name->case_short_decision;

    } 
    public function get_court_name($court_id)
    {
        $court_data=DB::table('court')->where('id',$court_id)->first();

        return $court_data->court_name;
    }
    public function get_applicant_name($id)
    {
         $citizen_id=DB::table('gcc_appeal_citizens')
               ->where('appeal_id',$id)
                ->where('citizen_type_id',1)
                ->first();
        $citizen_name=DB::table('gcc_citizens')->where('id',$citizen_id->citizen_id)->first();
        
        return $citizen_name->citizen_name;

    }
}
