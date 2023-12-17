<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\CaseRegister;
// use Validator;
use App\Http\Resources\CaseRegister as CaseResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CaseRegisterController extends BaseController
{
    public function test()
    {
        // $data = array();
        // Counter
        //$data['total_case'] = DB::table('case_register')->count();
        $data[]="Test";
        // dd($data);
        // echo 'Hellollll'; exit;
        return $this->sendResponse($data, 'test successfully.');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $data['name']     =  $user->name;
        $data['user_id']  =  $user->id;

        $districtID = DB::table('office')->select('district_id')->where('id', $user->office_id)
        ->first()->district_id;
        // dd($districtID);

        // Counter
        if ($user->role_id == 1) {
            $data['total_case'] = DB::table('case_register');
            $data['running_case'] = DB::table('case_register')->where('status', 1);
            $data['appeal_case'] = DB::table('case_register')->where('status', 2);
            $data['completed_case'] = DB::table('case_register')->where('status', 3);

            $data['total_office'] = DB::table('office');
            $data['total_user'] = DB::table('users');
            $data['total_court'] = DB::table('court');
            $data['total_mouja'] = DB::table('mouja');
            $data['total_ct'] = DB::table('case_type');
        }elseif ($user->role_id == 2) {
            $data['total_case'] = DB::table('case_register');
            $data['running_case'] = DB::table('case_register')->where('status', 1);
            $data['appeal_case'] = DB::table('case_register')->where('status', 2);
            $data['completed_case'] = DB::table('case_register')->where('status', 3);

            $data['total_office'] = DB::table('office');
            $data['total_user'] = DB::table('users');
            $data['total_court'] = DB::table('court');
            $data['total_mouja'] = DB::table('mouja');
            $data['total_ct'] = DB::table('case_type');
        }else{
            $data['total_case'] = DB::table('case_register')->where('district_id', $districtID);
            $data['running_case'] = DB::table('case_register')->where('district_id', $districtID)->where('status', 1);
            $data['appeal_case'] = DB::table('case_register')->where('district_id', $districtID)->where('status', 2);
            $data['completed_case'] = DB::table('case_register')->where('district_id', $districtID)->where('status', 3);

            $data['total_office'] = DB::table('office')->where('district_id', $districtID);
            $data['total_user'] = DB::table('users');
            $data['total_court'] = DB::table('court')->where('district_id', $districtID);
            $data['total_mouja'] = DB::table('mouja')->where('district_id', $districtID);
            $data['total_ct'] = DB::table('case_type');
        }

        if($request->court) {
            $data['total_case'] = $data['total_case']->where('case_register.court_id','=',$request->court);
            $data['running_case'] = $data['running_case']->where('case_register.court_id','=',$request->court);
            $data['appeal_case'] = $data['appeal_case']->where('case_register.court_id','=',$request->court);
            $data['completed_case'] = $data['completed_case']->where('case_register.court_id','=',$request->court);
        }

        if($request->division) {
            $data['total_case'] = $data['total_case']->where('case_register.division_id','=',$request->division);
            $data['running_case'] = $data['running_case']->where('case_register.division_id','=',$request->division);
            $data['appeal_case'] = $data['appeal_case']->where('case_register.division_id','=',$request->division);
            $data['completed_case'] = $data['completed_case']->where('case_register.division_id','=',$request->division);

            $data['total_office'] = $data['total_office']->where('division_id', $request->division);
            // $data['total_user'] = $data['total_user']->count();
            $data['total_court'] = $data['total_court']->where('division_id', $request->division);
            $data['total_mouja'] = $data['total_mouja']->where('division_id', $request->division);
            // $data['total_ct'] = $data['total_ct']->count();
        }
        if($request->district) {
            $data['total_case'] = $data['total_case']->where('case_register.district_id','=',$request->district);
            $data['running_case'] = $data['running_case']->where('case_register.district_id','=',$request->district);
            $data['appeal_case'] = $data['appeal_case']->where('case_register.district_id','=',$request->district);
            $data['completed_case'] = $data['completed_case']->where('case_register.district_id','=',$request->district);

            $data['total_office'] = $data['total_office']->where('district_id', $request->district);
            // $data['total_user'] = $data['total_user']->count();
            $data['total_court'] = $data['total_court']->where('district_id', $request->district);
            $data['total_mouja'] = $data['total_mouja']->where('district_id', $request->district);
            // $data['total_ct'] = $data['total_ct']->count();
        }
        if($request->upazila) {
            $data['total_case'] = $data['total_case']->where('case_register.upazila_id','=',$request->upazila);
            $data['running_case'] = $data['running_case']->where('case_register.upazila_id','=',$request->upazila);
            $data['appeal_case'] = $data['appeal_case']->where('case_register.upazila_id','=',$request->upazila);
            $data['completed_case'] = $data['completed_case']->where('case_register.upazila_id','=',$request->upazila);

            $data['total_office'] = $data['total_office']->where('upazila_id', $request->upazila);
            // $data['total_user'] = $data['total_user']->count();
            // $data['total_court'] = $data['total_court']->where('upazila_id', $request->upazila);
            $data['total_mouja'] = $data['total_mouja']->where('upazila_id', $request->upazila);
            // $data['total_ct'] = $data['total_ct']->count();
        }

        $data['total_case'] = $data['total_case']->count();
        $data['running_case'] = $data['running_case']->count();
        $data['appeal_case'] = $data['appeal_case']->count();
        $data['completed_case'] = $data['completed_case']->count();

        $data['total_office'] = $data['total_office']->count();
        $data['total_user'] = $data['total_user']->count();
        $data['total_court'] = $data['total_court']->count();
        $data['total_mouja'] = $data['total_mouja']->count();
        $data['total_ct'] = $data['total_ct']->count();

        // dd($data);
        // echo 'Hellollll'; exit;
        return $this->sendResponse($data, 'Dashboard Counter.');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = CaseRegister::all();

        return $this->sendResponse(CaseResource::collection($items), 'Case retrieved successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_case(Request $request)
    {
        $query = DB::table('case_register')
            ->orderBy('id','DESC')
            ->select('case_register.status','case_register.id', 'case_register.case_number', 'case_register.case_date', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')
            ->join('court', 'case_register.court_id', '=', 'court.id')
            ->join('district', 'case_register.district_id', '=', 'district.id')
            ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
            ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id');

        if($request->status){
            $query->where('case_register.status', $request->status);
        }
        if($request->court) {
            $query->where('case_register.court_id','=',$request->court);
        }
        if($request->division) {
            $query->where('case_register.division_id','=',$request->division);
        }
        if($request->district) {
            $query->where('case_register.district_id','=',$request->district);
        }
        if($request->upazila) {
            $query->where('case_register.upazila_id','=',$request->upazila);
        }

        $query = $query->paginate(10);

        return $this->sendResponse($query, 'Case list retrieved successfully.');
    }

    public function case_tracking(Request $request)
    {
        $query = DB::table('case_register')
            ->orderBy('id','DESC')
            ->select( 'case_register.*', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'case_type.ct_name', 'case_status.status_name')
            ->join('court', 'case_register.court_id', '=', 'court.id')
            ->join('district', 'case_register.district_id', '=', 'district.id')
            ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
            ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
            ->leftJoin('case_type', 'case_register.ct_id', '=', 'case_type.id')
            ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id');

        if($request->division) {
            $query->where('case_register.division_id','=',$request->division);
        }
        if($request->district) {
            $query->where('case_register.district_id','=',$request->district);
        }
        if($request->upazila) {
            $query->where('case_register.upazila_id','=',$request->upazila);
        }

        if($request->upazila) {
            $query->where('case_register.upazila_id','=',$request->upazila);
        }

        if($request->case_number) {
            $query->where('case_register.case_number','=',$request->case_number);
        }

        if($request->court) {
            $query->where('case_register.court_id','=',$request->court);
        }

        $query = $query->get();

        return $this->sendResponse($query, 'Case list retrieved successfully.');

        // $data = CaseResource::paginate(request()->all());
        // dd($data);
        // return Response::json($data, 200); //CaseResource::collection($items)

        // $items = CaseRegister::all();

        /*$data = DB::for(CaseResource::class)
        // ->allowedFilters(['name', 'email'])
        ->paginate()
        ->appends(request()->query());
        return $this->sendResponse($data, 'Case retrieved successfully.');*/

        // $items = CaseRegister::all();
        // return $this->sendResponse(CaseResource::collection($items), 'Case list retrieved successfully.');
    }

    public function case_list(Request $request)
    {
        // Filtering
        $caseStatus = $request->get('status');
        $caseNumber = $request->get('case_no');
        // dd($status);
        // return $this->sendError('Case not found.');

        // Query
        $query = DB::table('case_register')
        ->select('case_register.id', 'case_register.case_number', 'case_register.case_date', 'case_register.status', 'court.court_name', 'mouja.mouja_name_bn', 'upazila.upazila_name_bn', 'district.district_name_bn', 'division.division_name_bn', 'case_register.division_id', 'case_register.district_id', 'case_register.upazila_id')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('district', 'case_register.district_id', '=', 'district.id')
        ->join('division', 'case_register.division_id', '=', 'division.id')
        ->orderBy('id','DESC');
        // Filtering
        if(!empty($caseStatus)) {
            $query->where('case_register.status','=',$caseStatus);
        }
        if(!empty($caseNumber)) {
            $query->where('case_register.case_number','=',$caseNumber);
        }

        $case = $query->get();

        // Return FALSE
        if (is_null($case)) {
            return $this->sendError('Case not found.');
        }

        return $this->sendResponse($case, 'Case list retrieved successfully.');
    }

    public function details($id)
    {
        // $case = CaseRegister::find($id);
        $data['details'] = DB::table('case_register')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->leftJoin('users', 'case_register.gp_user_id', '=', 'users.id')
        ->leftJoin('division', 'case_register.division_id', '=', 'division.id')
        ->leftJoin('district', 'case_register.district_id', '=', 'district.id')
        ->leftJoin('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->leftJoin('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->leftJoin('case_type', 'case_register.ct_id', '=', 'case_type.id')
        ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
        ->leftJoin('case_badi', 'case_register.id', '=', 'case_badi.case_id')
        ->leftJoin('case_bibadi', 'case_register.id', '=', 'case_bibadi.case_id')
        ->select('case_register.*', 'court.court_name','users.name', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'case_type.ct_name', 'case_status.status_name')
        ->where('case_register.id', '=', $id)
        ->first();

        $data['badis'] = DB::table('case_badi')
        ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
        ->select('case_badi.*')
        ->where('case_badi.case_id', '=', $id)
        ->get();

        $data['bibadis'] = DB::table('case_bibadi')
        ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
        ->select('case_bibadi.*')
        ->where('case_bibadi.case_id', '=', $id)
        ->get();

        $data['surveys'] = DB::table('case_survey')
        ->join('case_register', 'case_survey.case_id', '=', 'case_register.id')
        ->join('survey_type', 'case_survey.st_id', '=', 'survey_type.id')
        ->join('land_type', 'case_survey.lt_id', '=', 'land_type.id')
        ->select('case_survey.*','survey_type.st_name','land_type.lt_name')
        ->where('case_survey.case_id', '=', $id)
        ->get();

        if (is_null($data)) {
            return $this->sendError('Case not found.');
        }

        return $this->sendResponse($data, 'Case details retrieved successfully.');
        // return $this->sendResponse(new CaseResource($case), 'Case retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
            ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $case = CaseRegister::create($input);

        return $this->sendResponse(new CaseResource($case), 'Case created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $case = CaseRegister::find($id);

        if (is_null($case)) {
            return $this->sendError('Case not found.');
        }

        return $this->sendResponse(new CaseResource($case), 'Case retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CaseRegister $case)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
            ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $case->name = $input['name'];
        $case->detail = $input['detail'];
        $case->save();

        return $this->sendResponse(new CaseResource($case), 'Case updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CaseRegister $case)
    {
        $case->delete();

        return $this->sendResponse([], 'Case deleted successfully.');
    }

    public function hearing_date(Request $request)
     {
        $start = $request->start_date;
        $end = $request->end_date;

        // return date('Y-m-d');
       $data = DB::table('case_hearing')
            ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
            ->join('court', 'case_register.court_id', '=', 'court.id')
            ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
            ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
            ->select('case_hearing.*', 'case_register.id', 'case_register.court_id', 'case_register.case_number', 'case_register.status', 'court.court_name');
        if($start || $end){
            $data->whereBetween('case_hearing.hearing_date', [$start, $end]);
        }
       $data = $data->paginate(10);
       return $this->sendResponse($data, 'Case Hearing List.');
    }
}
