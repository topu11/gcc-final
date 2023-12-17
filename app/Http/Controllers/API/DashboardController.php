<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\CaseHearing;
// use Validator;
use App\Models\CaseRegister;
use App\Models\GccAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use Validator;

class DashboardController extends BaseController
{
    public function test()
    {
        // Counter
        //$data['total_case'] = DB::table('case_register')->count();
        $data['Hello'] = 'Hello';
        // dd($data);
        // echo 'Hellollll'; exit;
        return $this->sendResponse($data, 'test successfully.');
    }

    // use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $data = [];

        $roleID = $request->role_id;
        $userID = $request->user_id;
        $court_id = $request->court_id;
        $division_id = $request->division_id;
        $district_id = $request->district_id;
        $office_id = $request->office_id;

        if ($roleID == 1) {
            // Superadmi dashboard

            // Counter
            $data['total_case'] = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = GccAppeal::where('appeal_status', 'ON_TRIAL')->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO', 'SEND_TO_GCO'])->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'Superadmi Data.');

        } elseif ($roleID == 2) {

            $data['total_case'] = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = GccAppeal::where('appeal_status', 'ON_TRIAL')->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO', 'SEND_TO_GCO'])->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'Superadmi Data.');

        } elseif ($roleID == 6) {

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_DC'])->where('district_id', user_district()->id)->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_DC'])->where('district_id', user_district()->id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district()->id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('district_id', user_district()->id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('district_id', user_office_info()->district_id)->count();

            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('district_id', user_office_info()->district_id)->count();

            $data['total_court'] = DB::table('court')->whereNotIn('id',
                [1, 2]
            )->count();

            return $this->sendResponse($data, 'District Commissioner Data.');

        } elseif ($roleID == 14) {

            $data['total_case'] = DB::table('case_register')->count();
            $data['running_case'] = DB::table('case_register')->where('status', 1)->count();
            $data['appeal_case'] = DB::table('case_register')->where('status', 2)->count();
            $data['completed_case'] = DB::table('case_register')->where('status', 3)->count();

            return $this->sendResponse($data, 'LAB Chairman Data.');

        } elseif ($roleID == 20) {
            $data['page_title'] = 'অ্যাডভোকেট এর ড্যাশবোর্ড';
            return view('dashboard.office_head')->with($data);
        } elseif ($roleID == 24) {
            // Superadmin dashboard
            // Counter
            $data['total_case'] = GccAppeal::count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();
            $data['total_sf_count'] = CaseRegister::orderby('id', 'desc')->where('is_sf', 1)->where('status', 1)->get()->count();

            return $this->sendResponse($data, 'LAB Chairman Data.');

        } elseif ($roleID == 25) {

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_LAB_CM', 'CLOSED'])->where('updated_by', globalUserInfo()->id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_LAB_CM'])->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_LAB_CM'])->where('updated_by', globalUserInfo()->id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('updated_by', globalUserInfo()->id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('updated_by', globalUserInfo()->id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();

            return $this->sendResponse($data, 'LAB Chairman Data.');

        } elseif ($roleID == 27) {

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', globalUserInfo()->court_id)->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', globalUserInfo()->court_id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', $court_id)->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', $court_id)->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', $court_id)->count();
            $data['pending_case_list'] = GccAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_GCO'])->where('court_id', $court_id)->count();

            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'GCO Data.');

        } elseif ($roleID == 28) {
            // asst GCO dashboard

            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->where('court_id', globalUserInfo()->court_id)->count();

            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->where('court_id', globalUserInfo()->court_id)->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('court_id', globalUserInfo()->court_id)->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('court_id', globalUserInfo()->court_id)->count();

            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'Asst. GCO Data.');

        } elseif ($roleID == 32) {
            $moujaIDs = DB::table('mouja_ulo')->where('ulo_office_id', $office_id)->pluck('mouja_id');

            $data['total_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->count();
            $data['running_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 1)->count();
            $data['appeal_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 2)->count();
            $data['completed_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 3)->count();

            return $this->sendResponse($data, 'Sub Register Data.');

        } elseif ($roleID == 33) {
            $moujaIDs = DB::table('mouja_ulo')->where('ulo_office_id', $office_id)->pluck('mouja_id');

            $data['total_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->count();
            $data['running_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 1)->count();
            $data['appeal_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 2)->count();
            $data['completed_case'] = DB::table('case_register')->where('mouja_id', [$moujaIDs])->where('status', 3)->count();

            return $this->sendResponse($data, 'Officer incharge Data.');

        } elseif ($roleID == 34) {
            $data['total_case'] = GccAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['pending_case'] = GccAppeal::whereIn('appeal_status', ['SEND_TO_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL_DIV_COM'])->where('division_id', user_office_info()->division_id)->count();

            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->where('division_id', user_office_info()->division_id)->count();

            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->where('division_id', user_office_info()->division_id)->count();

            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->where('division_id', user_office_info()->division_id)->count();

            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            return $this->sendResponse($data, 'Divisional Commissioner Data.');

        } elseif ($roleID == 35) {

            $data['total_case'] = $this->total_case_count_applicant();
            $data['running_case'] = $this->total_running_case_count_applicant();
            $data['pending_case'] = $this->total_pending_case_count_applicant();
            $data['completed_case'] = $this->total_completed_case_count_applicant();

            $data['draft_case'] = GccAppeal::where('created_by', $userID)->where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = GccAppeal::where('created_by', $userID)->where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('created_by', $userID)->where('appeal_status', 'POSTPONED')->count();

            return $this->sendResponse($data, 'Organization Data.');

        } elseif ($roleID == 36) {
            $totalCase = 0;
            $totalRunningCase = 0;
            $totalCompleteCase = 0;

            $array_case_list_to_causlist = [];

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

            if (!empty($appeal_no)) {
                foreach ($appeal_no as $key => $value) {
                    if (!empty($value)) {

                        $all_case = GccAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])->first();

                        if ($all_case) {

                            array_push($array_case_list_to_causlist, $all_case->id);

                            $totalCase++;
                        }
                        $running_case = GccAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])->first();
                        if ($running_case) {
                            $totalRunningCase++;
                        }
                        $completed_case = GccAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['CLOSED'])->first();
                        if ($completed_case) {
                            $totalCompleteCase++;
                        }
                    }

                }
            }

            // return $all_case;

            $data['total_case'] = $totalCase;
            $data['running_case'] = $totalRunningCase;
            $data['completed_case'] = $totalCompleteCase;
            $data['pending_case'] = GccAppeal::where('review_applied_by', globalUserInfo()->id)->whereIn('appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])->count();
            /*$data['total_case'] = GccAppeal::count();
            $data['running_case'] = GccAppeal::whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->count();
            $data['completed_case'] = GccAppeal::where('appeal_status', 'CLOSED')->count();
            $data['draft_case'] = GccAppeal::where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = GccAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = GccAppeal::where('appeal_status', 'POSTPONED')->count();*/

            return $this->sendResponse($data, 'Organization Data.');

        } else {
            $data = array();
            return $this->sendResponse($data, 'Sorry dose not fill up requirement.');
        }
    }

    public function total_case_count_applicant()
    {
        $user = globalUserInfo();
        $appeal_ids_as_agent = [];
        $appeal_ids_as_applicant = [];

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
            ->whereIn('gcc_appeals.appeal_status', ['CLOSED', 'ON_TRIAL'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_ids_as_agent, $appeal_ids_from_db_single->appeal_id);

        }

        $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', $user->id)->whereIn('appeal_status', ['ON_TRIAL',  'CLOSED'])->select('id')->get();

        foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
            array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

        }
        $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

        return GccAppeal::WhereIn('ID', $total_case)->count();
    }
    public function total_running_case_count_applicant()
    {
        $user = globalUserInfo();
        $appeal_ids_as_agent = [];
        $appeal_ids_as_applicant = [];

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
            ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_ids_as_agent, $appeal_ids_from_db_single->appeal_id);

        }

        $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', $user->id)->whereIn('appeal_status', ['ON_TRIAL'])->select('id')->get();

        foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
            array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

        }
        $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

        return GccAppeal::WhereIn('ID', $total_case)->count();
    }
    public function total_pending_case_count_applicant()
    {
        $user = globalUserInfo();
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

        $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', $user->id)->whereIn('appeal_status', ['SEND_TO_GCO', 'SEND_TO_ASST_GCO'])->select('id')->get();

        foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
            array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

        }
        $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

        return GccAppeal::WhereIn('ID', $total_case)->count();
    }
    public function total_completed_case_count_applicant()
    {
        $user = globalUserInfo();
        $appeal_ids_as_agent = [];
        $appeal_ids_as_applicant = [];

        $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
            ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
            ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
            ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->where('gcc_appeal_citizens.citizen_type_id', '=', 1)
            ->whereIn('gcc_appeals.appeal_status', ['CLOSED'])
            ->select('gcc_appeal_citizens.appeal_id')
            ->get();

        foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            array_push($appeal_ids_as_agent, $appeal_ids_from_db_single->appeal_id);

        }

        $appeal_ids_applicant = GccAppeal::orderby('id', 'DESC')->where('created_by', $user->id)->whereIn('appeal_status', ['CLOSED'])->select('id')->get();

        foreach ($appeal_ids_applicant as $appeal_ids_applicant_single) {
            array_push($appeal_ids_as_applicant, $appeal_ids_applicant_single->id);

        }
        $total_case = array_merge($appeal_ids_as_agent, $appeal_ids_as_applicant);

        return GccAppeal::WhereIn('ID', $total_case)->count();
    }

}
