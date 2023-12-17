<?php

namespace App\Services;

use App\Models\Upazila;
use App\Models\CrpcSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AppealRepository;
use App\Models\EmCaseShortdecisionTemplates;
use App\Models\GccCaseShortdecisionTemplates;

class ShortOrderTemplateServiceUpdated
{
    public static function getShortOrderTemplateListByAppealId($appealId)
    {
        $templateList = DB::table('gcc_case_shortdecision_templates')
            ->where('appeal_id', $appealId)
            ->get();
        return $templateList;
    }

    public static function deleteShortOrderTemplate($causeListId)
    {
        $shortOrderList = GccCaseShortdecisionTemplates::where('cause_list_id', $causeListId);
        // dd($shortOrderList);
        $shortOrderList->delete();
        return;
    }

    public static function storeShortOrderTemplate($shortOrderId, $appealId, $causeListId, $shortOrderTemplateContent, $templateName)
    {
        $shortOrderTemplate = new GccCaseShortdecisionTemplates();
        $shortOrderTemplate->appeal_id = $appealId;
        $shortOrderTemplate->cause_list_id = $causeListId;
        $shortOrderTemplate->case_shortdecision_id = $shortOrderId;
        $shortOrderTemplate->template_full = $shortOrderTemplateContent;
        $shortOrderTemplate->template_header = '';
        $shortOrderTemplate->template_body = '';
        $shortOrderTemplate->template_name = $templateName;
        $shortOrderTemplate->created_at = date('Y-m-d H:i:s');
        $shortOrderTemplate->created_by = Auth::user()->username;
        $shortOrderTemplate->updated_at = date('Y-m-d H:i:s');
        $shortOrderTemplate->updated_by = Auth::user()->username;
        $shortOrderTemplate->save();
        return $shortOrderTemplate->id;
    }
    public static function generateShortOrderTemplate($shortOrders, $appealId, $causeList, $requestInfo)
    {
        $appealInfo = AppealRepository::getAllAppealInfo($appealId);
       // dd($appealInfo);
        // self::deleteShortOrderTemplate($causeList->id);
        // if(count($shortOrders)>0){
        if ($shortOrders != null) {
            // dd($shortOrders);
            $templateIds = [];
            foreach ($shortOrders as $shortOrder) {
                if ($shortOrder == 21) {
                    
                    $templateName = 'রিকুইজিশন সার্টিফিকেট খাতকের প্রতি দাবী ( ১০(ক) ধারা)';
                    $shortOrderTemplate = self::getCertificateDefaulterNoticeSectionTenShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    $templateName = 'সার্টিফিকেট  রাজকীয় প্রাপ্যের সার্টিফিকেট';
                    $shortOrderTemplate = self::getRajokioPrappoShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);

                    return $templateIds;
                } elseif ($shortOrder == 2 || $shortOrder == 3) {
                    
                    $templateName = 'সার্টিফিকেট খাতকের প্রতি দাবী (৭ ধারা)';
                    $shortOrderTemplate = self::getCertificateDefaulterNoticeSectionSevenShortOrderTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    $templateName = 'সার্টিফিকেট  রাজকীয় প্রাপ্যের সার্টিফিকেট';
                    $shortOrderTemplate = self::getRajokioPrappoShortOrderTemplate($appealInfo, $requestInfo);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } elseif ($shortOrder == 5) {
                    
                    $templateName = 'সার্টিফিকেট  খাতকের প্রতি W/A ইস্যু করা হোক ';
                    $shortOrderTemplate = self::getDefaulterJailWarrentShortOrderTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }  elseif ($shortOrder == 17) {
                    
                    $templateName = '৭৭ মোতাবেক কারণ দর্শানো নোটিশ জারী';
                    $shortOrderTemplate = self::getSeventySevenShortOrderTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                } 
                elseif ($shortOrder == 6 || $shortOrder == 7 || $shortOrder == 11) {
                    
                    $templateName = '২৯ ধারার নোটিশ (গ্রেফতারী পরোয়ানা)';
                    $shortOrderTemplate = self::getTwentyNineShortOrderTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }
                elseif($shortOrder == 18)
                {
                    $templateName = 'দেনাদারকে সিভিল জেলে  এ সোপর্দ করার আদেশ';
                    $shortOrderTemplate = self::getSentToCivilCourtTemplate($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }
                elseif($shortOrder == 19)
                {
                    $templateName = 'সার্টিফিকেট কার্যকরী করার উদ্দেশ্যে জেলে আটক বাক্তিকে মুক্তি করার আদেশ';
                    $shortOrderTemplate = self:: getReleasePerson($appealInfo, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }
                else {
                    return null;
                }
            }
        }
    }
    /******* যা যা লাগবে সেগুলো */
    //--------------------------সার্টিফিকেট খাতকের প্রতি দাবী ( ১০(ক) ধারা)  ------------------------------------------
    public static function getCertificateDefaulterNoticeSectionTenShortOrderTemplate($appealInfo, $requestInfo)
    {
        
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $defaulter = $appealInfo['defaulterCitizen'];
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        //$trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        //$trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));
        $amount_to_pay_as_remaining=$requestInfo->amount_to_pay_as_remaining;
        $amount_to_pay_as_costing=$requestInfo->amount_to_pay_as_costing;

        $template =
            '<div style="padding-top: 5%;">
                          <header>
                              <div style="text-align: center">
                                  <h3>সার্টিফিকেট খাতকের প্রতি দাবীর নোটিশ</h3>
                                  <h3>( বাংলাদেশ ফরম নম্বর ১০২৯ ) </h3>
                                  <h3>১০/ক ধারা দেখুন । </h3>
                                  <h3>সার্টিফিকেট মোকদ্দমা নম্বর-(' .
            $case_in_text .
            ')</h3>
                                  <h3>L. L. F. No </h3>
                              </div>
                          </header>
                          <br>
  
                          <div style="font-size:  medium;">
                              <span style="float:left">জনাব  ' .
            $defaulter->citizen_name .
            ' </span>
                              <br>
                              <br>
                              <span style="margin-left: 40px">
                              এতদ্বারা আপনাকে জানানো যাচ্ছে যে, আপনার নিকট ' .
            $case_data_mapping->office_name_bn .
            ', ' .
            $case_data_mapping->district_name_bn .
            ', প্রাপ্য বাবদ ' .
            en2bn($case_data_mapping->loan_amount) .
            '(' .
            $case_data_mapping->loan_amount_text .
            ' টাকা মাত্র) বিপরীতে আপনার বিরুদ্ধে একটি পিডিআর এক্ট ১৯১৩,এর ৪ ও ৬ ধারা মোতাবেক নিম্নস্বাক্ষরকারীর কোর্টে একটি সার্টিফিকেট মামলা রুজু করা হয়ছে। আপনি এই নোটিশ জারি করার ৩০ দিনের মধ্যে উক্ত টাকা সম্পূর্ণ অথবা আংশিক দায়দেনা অস্বীকার করে আবেদন পত্র দাখিল করতে পারেন। আপনি যদি উক্ত ৩০(ত্রিশ) দিনের মধ্যে দায় দেনা অস্বীকার করে আবেদন দায়ের করতে অথবা আপনি যদি কারণ দর্শাতে ব্যার্থ হন অথবা এরূপ সার্টিফিকেট কেস কেন কার্যকর করা হবে না তার পর্যাপ্ত কারণ না দর্শান তাহলে ইহা উক্ত আইনে বিধান মোতাবেক কার্যকরী করা হবে, যতক্ষণ পর্যন্ত আপনি '.$amount_to_pay_as_remaining.' টাকা বকেয়া বাবদ এবং '.$amount_to_pay_as_costing. ' টাকা খরচ আদায় বাবদ আমার অফিসে পরিশোধ না করেন।</span>
                              <br>
                              <br>
                              <span style="margin-left: 40px">উক্ত টাকা পরিশোধ না করা পর্যন্ত আপনার স্তাবর সম্পত্তি অথবা অংশ বিশেষ বিক্রি,দান,মর্গেজ অথবা অন্যান্যভাবে হস্তান্তর করতে নিষেধ করা হল। ইতোমধ্যে আপনি যদি অস্তাবর সম্পত্তি অংশ বিশেষ গোপনে অপশারণ বা হস্তান্তর করেন তাহলে সার্টিফিকেট ততক্ষখনাত কার্যকর হবে। </span>
                              <br>
                              <br>
                              <span style="margin-left: 40px">উপরের বর্ণিত সার্টিফিকেত এক কপি এই সংগে যুক্ত করা হল। আপনি সার্টিফিকেত নম্বর ও বছর উল্লেখ করে টাকা মানি অর্ডারের মাধ্যমে প্রেরণ করতে পারেন।</span>
                               <br><br>
                              <span style="margin-left: 40px"> তারিখ ঃ ' .
            $trialBanglaDate .
            ' </span><span>
                          </div>
                          <br>
                          <br>
                          <div style="float: right;font-size:medium;">
                               <span>সার্টিফিকেট অফিসার । </span>
                                  <br>
                              <span>' .
            $office_name->office_name_bn .
            ', ' .
            $case_data_mapping->district_name_bn .
            '</span>
                              <br>
                              <br>
                           </div>
                      </div>';

        return $template;
    }

    //-------------------------- সার্টিফিকেট খাতকের প্রতি দাবী (৭ ধারা) ------------------------------------------///
    public static function getCertificateDefaulterNoticeSectionSevenShortOrderTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $defaulter = $appealInfo['defaulterCitizen'];
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();
          $amount_to_pay_as_remaining=$requestInfo->amount_to_pay_as_remaining;
          $amount_to_pay_as_costing=$requestInfo->amount_to_pay_as_costing;

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        //$trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        //$trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $template =
            '<div style="padding-top: 5%;">
                          <header>
                              <div style="text-align: center">
                                  <h3>সার্টিফিকেট খাতকের প্রতি দাবীর নোটিশ</h3>
                                  <h3>( বাংলাদেশ ফরম নম্বর ১০২৯ ) </h3>
                                  <h3>সার্টিফিকেট মোকদ্দমা নম্বর-(' .
            $case_in_text .
            ')</h3>
                              </div>
                          </header>
                          <br>
  
                          <div style="font-size:  medium;">
                              <span style="float:left">জনাব  ' .
            $defaulter->citizen_name .
            ' </span>
                              <br>
                              <br>
                              <span style="margin-left: 40px">
                              এতদ্বারা আপনাকে জানানো যাচ্ছে যে, আপনার নিকট ' .
            $case_data_mapping->office_name_bn .
            ', ' .
            $case_data_mapping->district_name_bn .
            ', প্রাপ্য বাবদ ' .
            en2bn($case_data_mapping->loan_amount) .
            '(' .
            $case_data_mapping->loan_amount_text .
            ' টাকা মাত্র) বিপরীতে আপনার বিরুদ্ধে একটি পিডিআর এক্ট ১৯১৩,এর ৪ ও ৬ ধারা মোতাবেক নিম্নস্বাক্ষরকারীর কোর্টে একটি সার্টিফিকেট মামলা রুজু করা হয়ছে। আপনি এই নোটিশ জারি করার ৩০ দিনের মধ্যে উক্ত টাকা সম্পূর্ণ অথবা আংশিক দায়দেনা অস্বীকার করে আবেদন পত্র দাখিল করতে পারেন। আপনি যদি উক্ত ৩০(ত্রিশ) দিনের মধ্যে দায় দেনা অস্বীকার করে আবেদন দায়ের করতে অথবা আপনি যদি কারণ দর্শাতে ব্যার্থ হন অথবা এরূপ সার্টিফিকেট কেস কেন কার্যকর করা হবে না তার পর্যাপ্ত কারণ না দর্শান তাহলে ইহা উক্ত আইনে বিধান মোতাবেক কার্যকরী করা হবে, যতক্ষণ পর্যন্ত আপনি '.en2bn($amount_to_pay_as_remaining).' টাকা বকেয়া বাবদ এবং '.en2bn($amount_to_pay_as_costing).' টাকা খরচ আদায় বাবদ আমার অফিসে পরিশোধ না করেন।</span>
                              <br>
                              <br>
                              <span style="margin-left: 40px">উক্ত টাকা পরিশোধ না করা পর্যন্ত আপনার স্তাবর সম্পত্তি অথবা অংশ বিশেষ বিক্রি,দান,মর্গেজ অথবা অন্যান্যভাবে হস্তান্তর করতে নিষেধ করা হল। ইতোমধ্যে আপনি যদি অস্তাবর সম্পত্তি অংশ বিশেষ গোপনে অপশারণ বা হস্তান্তর করেন তাহলে সার্টিফিকেট ততক্ষখনাত কার্যকর হবে। </span>
                              <br>
                              <br>
                              <span style="margin-left: 40px">উপরের বর্ণিত সার্টিফিকেত এক কপি এই সংগে যুক্ত করা হল। আপনি সার্টিফিকেত নম্বর ও বছর উল্লেখ করে টাকা মানি অর্ডারের মাধ্যমে প্রেরণ করতে পারেন।</span>
                               <br><br>
                              <span style="margin-left: 40px"> তারিখ ঃ ' .
            $trialBanglaDate .
            ' </span><span>
                          </div>
                          <br>
                          <br>
                          <div style="float: right;font-size:medium;">
                               <span>সার্টিফিকেট অফিসার । </span>
                                  <br>
                              <span>' .
            $office_name->office_name_bn .
            ', ' .
            $case_data_mapping->district_name_bn .
            '</span>
                              <br>
                              <br>
                           </div>
                      </div>';

        return $template;
    }

    //---------------------------------সার্টিফিকেট  রাজকীয় প্রাপ্যের সার্টিফিকেট  ------------------------------------------------
    public static function getRajokioPrappoShortOrderTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $defaulter = $appealInfo['defaulterCitizen'];
        $applicantCitizen = $appealInfo['applicantCitizen'];
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $requestInfo->appealId)
            ->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')
            ->first();

        $organization_full_address = $case_data_mapping->office_name_bn . ', ' . $case_data_mapping->organization_physical_address . ', ' . $case_data_mapping->district_name_bn;
        $template =
            '<style>
                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                    padding: 10px;
                    padding-bottom: 5px;
                    font-weight: normal;
                }
                </style>
                <div id="crimieDescription" class="arrest-warrant">
                    
                    <header>
                        <div style="text-align: left">
                            বাংলাদেশ ফরম নং ১০২৭
                        </div>
                        <div style="text-align: center">
                            <h3>সরকারি দাবির সার্টিফিকেট(ধারা ৪ও৬, পিডিআর এক্ট ১৯১৩)</h3>
                        </div>
                    </header>
                    <table style="width: 100%">
                        <tr>
                            <th width="10%" style="text-align: justify">সার্টিফিকেট নাম্বার</th>
                            <th width="30%" style="text-align: justify">সার্টিফিকেট দাবিদারের নাম ও ঠিকানা</th>
                            <th width="30%" style="text-align: justify">সার্টিফিকেট দেনাদারের নাম ও ঠিকানা</th>
                            <th width="20%" style="text-align: justify">সরকারি দাবির পরিমাণ(সুদ এবং ৫(২)ধারা মোতাবেক প্রদত্ত ফিসসহ যার জন্যে সার্টিফিকেট সাক্ষর করা হয়েছে এবং যে সময়ের জন্যে পাওনা।</th>
                            <th width="" style="text-align: justify">সরকারি দাবি আর যে সময়ের জন্যে সাক্ষর করা হয়</th>
                        </tr>
                        <tr>
                            <td>' .
            $case_in_text .
            '</td>
                            <td>' .
            $applicantCitizen[0]->citizen_name .
            '<br>' .
            $organization_full_address .
            '</td>
                            <td>' .
            $defaulter->citizen_name .
            '<br>বর্তমান ঠিকানা - ' .
            $defaulter->present_address .
            '  ,স্থায়ী ঠিকানা - ' .
            $defaulter->permanent_address .
            '</td>
                            <td>' .
            en2bn($case_data_mapping->loan_amount) .
            '<br>' .
            $case_data_mapping->loan_amount_text .
            '</td>
                            <td></td>
                        </tr>
                    </table>
                    <div>
                     <br>
                     <br>
                       <span>এত দ্বারা প্রত্যয়ণ করা যাচ্ছে যে উপরউল্লেখিত ' .
            en2bn($case_data_mapping->loan_amount) .
            ', ( কথায় )' .
            $case_data_mapping->loan_amount_text .
            ' টাকা উপরিউল্লেখিত নামের ব্যাক্তিদের নিকট হতে প্রাপ্য। </span>
                       <br>
                       <br>
                       <span>আর প্রত্যয়ণ করা যাচ্ছে যে, উপরঊল্লেখিত ' .
            en2bn($case_data_mapping->loan_amount) .
            ', ( কথায় )' .
            $case_data_mapping->loan_amount_text .
            ' টাকা সঠিকভাবে আদায় যোগ্য এবং ইহা আদায় আইন মোতাবেক তামাদি হয়নি।  </span>
                       <div style="float: right;font-size:medium;margin-top:25px">
                               <span>সার্টিফিকেট অফিসার । </span>
                                  <br>
                              <span>' .
            $office_name->office_name_bn .
            ', ' .
            $case_data_mapping->district_name_bn .
            '</span>
                              <br>
                              <br>
                        </div>
                    </div>
            </div>';

        return $template;
    }
    //---------------------------------সার্টিফিকেট  খাতকের প্রতি W/A ইস্যু করা হোক  ------------------------------------------------
    public static function getDefaulterJailWarrentShortOrderTemplate($appealInfo, $requestInfo)
    {
        $offender = $appealInfo['defaulterCitizen'];
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $lawSection = DataConversionService::toBangla($appealInfo['appeal']->law_section);
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appealInfo['appeal']->created_at)));

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $trialBanglaYear = DataConversionService::toBangla(date('Y', strtotime($modified_conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $office_info = get_office_by_id(globalUserInfo()->office_id);
        //$office_name=
        $distric_name = DB::table('district')
            ->where('id', '=', $office_info->district_id)
            ->first();
        $location = $office_info->office_name_bn;

        $template =
            '<style>
                td{
                    padding-top: 10px;
                    padding-bottom: 10px;
                }
                </style>
        <div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: left">
                বাংলাদেশ ফরম নং ১০৩৫
            </div>
            <div style="text-align: center">
                <h3>গ্রেফতারী ওয়ারেন্ট</h3>
                <h4>(২৯ ধারা দেখুন।)</h4>
            </div>
        </header>
        <p class="text-center">যেহেতু বাংলাদেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সালের আইনের ' .
            $lawSection .
            ' ধারানুসারে</p>
        <div style="padding-top: 20px">
            <table width="100%" class="table">
                <tr>
                    <td width="10%" style="border: 1px solid black">
                        <p style="padding-top: 20px">মূল্য দাবী...</p>

                        <p>সুদ.........</p>

                    </td>
                    <td width="10%" style="border: 1px solid black">টাকা </br> ' .
            $loanAmountBng .
            '</td>
                    <td width="10%" style="border: 1px solid black">পঃ </td>
                    <td width="50%" rowspan="2">
                        <div style="text-align: justify;">
                            সার্টিফিকেট  খাতক
                            জনাব ' .
            $offender->citizen_name .
            ' এর বিরুদ্ধে ' .
            $appealBanglaYear .
            ' সালের ' .
            $appealBanlaMonth .
            ' মাসের ' .
            $appealBanglaDay .
            ' দিবসে
                            ' .
            $caseNo .
            '  নম্বরে<span style="padding-left: 40px">এক </span> সার্টিফিকেট এই অফিসে গাঁথিয়া রাখা
                            হইয়াছে, এবং পার্শ্বে লিখিত টাকা তাহার নিকট হইতে উক্ত
                            সার্টিফিকেট বাবদ প্রাপ্য, এবং যেহেতু উক্ত সার্টিফিকেটের দাবী
                            পরিশোধ কল্পে সার্টিফিকেটধারীকে উক্ত
                            ' .
            $loanAmountBng .
            ' টাকা প্রদত্ত করা হয় নাই।

                        </div>

                        <div style="text-align: justify;">
                            <span style="padding-left: 40px">অতএব,</span> এতদ্বারা আপনাকে আদেশ করা যাইতেছে যে,
                            আপনি উক্ত সার্টিফিকেটমত খাতককে গ্রেফতার করিবেন,এবং
                            সার্টিফিকেটমত খাতক এই পরোয়ানা জারীর খরচ বাবদ ' .
            $loanAmountBng .
            '
                            টাকা আপনাকে না দিলে সুবিধামত সত্ত্বরতা তাহাকে আদালতের সম্মুখে উপস্থিত করিবেন।
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="10%" style="border: 1px solid black">

                        <p>খরচ......</p>

                        <p>জারী......</p>

                        <p>মোট......</p>
                    </td>
                    <td width="10%" style="border: 1px solid black"></td>
                    <td width="10%" style="border: 1px solid black"></td>
                </tr>
            </table>
        </div>
        <div>
            <span style="padding-left: 40px"> আপনাকে </span> আরও আদেশ করা যাইতেছে যে, আপনি ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' দিবসে বা তৎপূর্বে যে দিবসে ও যে প্রকারে এই ওয়ারেন্ট জারি করা হইয়াছে অথবা উহা জারি না হইবার কারণ বিজ্ঞাপক পৃষ্ঠালিপিসহ উহা ফিরাইয়া দিবেন।
        </div>
        <div style="padding-top: 20px">
            <span style="padding-left: 40px"> তারিখ অদ্য ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' দিবসে।
        </div>
        <div style="padding-top: 20px;padding-bottom: 100px">
            <span style="float: right">
                <p style=" text-align : center; color: blueviolet;">
                        <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                        
                        <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
                    সার্টিফিকেট   অফিসার <br>
                </p>
               ' .
            $location .
            ', ' .
            $distric_name->district_name_bn .
            '
            </span>
        </div>
    </div>';
        return $template;
    }
    //---------------------------------------ক্রোক---------------------------------//
    public static function generateCrokeTemplate($appealInfo, $requestInfo)
    {
        $offender = $appealInfo['defaulterCitizen'];
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $lawSection = DataConversionService::toBangla($appealInfo['appeal']->law_section);
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appealInfo['appeal']->created_at)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appealInfo['appeal']->created_at)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appealInfo['appeal']->created_at)));

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $trialBanglaYear = DataConversionService::toBangla(date('Y', strtotime($modified_conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $office_info = get_office_by_id(globalUserInfo()->office_id);
        //$office_name=
        $distric_name = DB::table('district')
            ->where('id', '=', $office_info->district_id)
            ->first();
        $location = $office_info->office_name_bn;

        $template =
            '<style>
                td{
                    padding-top: 10px;
                    padding-bottom: 10px;
                }
                </style>
        <div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: left">
                বাংলাদেশ ফরম নং ১১৭৭
            </div>
            <div style="text-align: center">
                <h3>১১ক নং ফরম।</h3>
                <h3>অস্থাবর সম্পত্তি ক্রোকের পরোয়ানা</h3>
                <h4>(১৩ ও ১৪ ধারা দ্রষ্টব্য)</h4>
            </div>
        </header>
        <p class="text-center">যেহেতু বাংলাদেশের রাজকীয় প্রাপ্য আদায় বিষয়ক ১৯১৩ সালের আইনের ' .
            $lawSection .
            ' ধারানুসারে</p>
        <div style="padding-top: 20px">
            <table width="100%" class="table">
                <tr>
                    <td width="10%" style="border: 1px solid black">
                        <p style="padding-top: 20px">মূল্য দাবী...</p>

                        <p>সুদ.........</p>

                    </td>
                    <td width="10%" style="border: 1px solid black">টাকা </br> ' .
            $loanAmountBng .
            ' </td>
                    <td width="10%" style="border: 1px solid black">পঃ </td>
                    <td width="50%" rowspan="2">
                        <div style="text-align: justify;">
                            সার্টিফিকেট খাতক
                            জনাব ' .
            $offender->citizen_name .
            ' র বিরুদ্ধে ' .
            $appealBanglaYear .
            ' সালের ' .
            $appealBanlaMonth .
            ' মাসের ' .
            $appealBanglaDay .
            ' দিবসে
                            ' .
            $caseNo .
            '  নম্বরে এক সার্টিফিকেট এই অফিসে গাঁথিয়া রাখা
                            হইয়াছে, এবং পার্শ্বে লিখিত টাকা তাহার নিকট হইতে উক্ত
                            সার্টিফিকেট বাবদ প্রাপ্য, এবং যেহেতু উক্ত সার্টিফিকেটের দাবী
                            পরিশোধ কল্পে সার্টিফিকেটধারীকে উক্ত  ' .
            $loanAmountBng .
            ' টাকা প্রদত্ত করা হয় নাই।

                        </div>

                        <div style="text-align: justify;">
                            <span style="padding-left: 40px">অতএব,</span> এতদ্বারা আপনাকে আদেশ করা যাইতেছে যে,
                             আপনি উক্ত সার্টিফিকেটমত খাতকের *অস্থাবর সম্পত্তি ক্রোক
                             করিবেন, এবং সার্টিফিকেটমত খাতক আপনাকে উক্ত
                             টাকা, যা এই পরোয়ানা জারীর খরচ বাবদ ' .
            $loanAmountBng .
            '
                            টাকা না দিলে আপনি এই আদালত হইতে অন্য কোন হুকুম না পাওয়া পর্যন্ত উহা ক্রোক রাখিবেন।
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="10%" style="border: 1px solid black">

                        <p>খরচ......</p>

                        <p>জারী......</p>

                        <p>মোট......</p>
                    </td>
                    <td width="10%" style="border: 1px solid black"></td>
                    <td width="10%" style="border: 1px solid black"></td>
                </tr>
            </table>
        </div>
        <div>
            <span style="padding-left: 40px"> আপনাকে </span> আরও আদেশ করা যাইতেছে যে, যে তারিখে ও যে প্রকারে এই পরোয়ানা জারী করা হয় অথবা উহা জারী না হইয়া থাকিলে কি কারণে জারী হয় নাই তাহা ইহার পৃষ্ঠে লিখিয়া ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' দিবসে অথবা তৎপূর্বে এই পরোয়ানা ফেরত দিবেন।
        </div>
        <div style="padding-top: 20px">
            <span style="padding-left: 40px"> তারিখ অদ্য ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' দিবসে।
        </div>
        <div style="padding-top: 20px;padding-bottom: 100px">
            <span style="float: right">
               <p style=" text-align : center; color: blueviolet;">
                        <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                        
                        <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
                    সার্টিফিকেট   অফিসার <br>
                </p>
                ' .
            $location .
            ', ' .
            $distric_name->district_name_bn .
            '
            </span>
        </div>
        <div>
         <p style="text-align: center;border-top: 1px solid #0d0808">
            *যে স্থলে অস্থাবর সম্পত্তির কতক অংশ মাত্র ক্রোক করিবার হুকুম হয় সে স্থলে এখানে “টাকা মূল্যের” এই কথাগুলি যোগ করিয়া দিতে হইবে।
         </p>
        </div>
    </div>';
        return $template;
    }
    //---------------------------------------৭৭ মোতাবেক কারণ দর্শানো নোটিশ জারী---------------------------------//

    public static function getSeventySevenShortOrderTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        //$loanMoney=DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        //$offenderAddress=$offender->present_address;
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $applicant_name = $appealInfo['applicantCitizen'][0]->citizen_name;
        $modified_trial_date = date_formater_helpers_make_bd($requestInfo->trialDate);

        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>গ্রেফতারী পরোয়ানা কেন বাহির করা হইবে না <br> তাহার কারণ দর্শাইবার নোটিশ </h3>
                <h4>
                    ( বিধি - ৭৭ দ্রষ্টব্য )
                </h4>
            </div>
        </header>
        <div>
            <p style="text-align: right">সার্টিফিকেট মোকদ্দমা নং ' .
            $caseNo .
            '</p>
        </div>
        <br>
        <div>
            <div>
                <p style="text-align: justify;line-height: 30px;"> প্রতি (খাতক): ' .
            $offender->citizen_name .
            ' পিতার নাম: ' .
            $offender->father .
            ' ঠিকানা: ' .
            $offender->present_address .
            ' </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
                যেহেতু জনাব ' .
            $applicant_name .
            ', উক্ত সার্টিফিকেট কেস নং . ' .
            $case_in_text .
            '
                কার্যকরী করার জন্য আপনাকে  গ্রেফতার  ও আটক এবং আটক করার জন্য আবেদন করেছে ;
                অতএব আপনাকে জেলে আমার সম্মুখে ' .
            $modified_trial_date .
            '
                তারিখে হাজির হয়ে উক্ত সার্টিফিকেট  কেন কার্যকরী করার জন্য কেন আপনাকে সিভিল জেলে সপারদ করা হবেনা
                তা কারন দর্শাতে হবে
            </div>
            <div>
                <span style="margin-left: 30px">আমার স্বাক্ষর ও আদালতের মোহর যুক্ত মতে দেওয়া গেল। </span>
            </div>
        </div>
        <div style="text-align: right">
            <span> সার্টিফিকেট অফিসার </span><br>
            ' .
            $location .
            '
        </div>

        <div>
           <h5 > বিঃ দ্রঃ এই নোটিশ অগ্রাহ্য করা হইলে গ্রেফতারী পরোয়ানা ইস্যু করা হইবে।</h5>
        </div>
    </div>';
        return $template;
    }
    //---------------------------------------২৯ ধারার নোটিশ (গ্রেফতারী পরোয়ানা) ---------------------------------//
    public static function getTwentyNineShortOrderTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        //$loanMoney=DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        //$offenderAddress=$offender->present_address;
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $applicant_name = $appealInfo['applicantCitizen'][0]->citizen_name;
        $modified_created_date = date_formater_helpers_make_bd_v2(explode(' ',$appealInfo['appeal']->created_at)[0]);
        $conduct_date_modify_array=explode('-',date_formater_helpers_v2($requestInfo->conductDate));
        $conduct_date_modify_string=$conduct_date_modify_array[2].'/'.$conduct_date_modify_array[1].'/'.$conduct_date_modify_array[0];

        $total_amt=$requestInfo->main_amount_29_dhara+$requestInfo->interest_29_dhara+$requestInfo->costing_29_dhara+$requestInfo->working_amount_29_dhara;
        
        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>গ্রেফতারী পরোয়ানা (২৯ ধারা দ্রষ্টব্য ) </h3>
            </div>
        </header>
        <br>
        <div>
            <div>
                <p style="text-align: justify;line-height: 30px;"> 
                প্রাপক: ' .$requestInfo->warrantExecutorName .'<br>
                ভারপাপ্ত কর্মকর্তা
               </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
            যেহেতু  সার্টিফিকেট নং '.$case_in_text.' তারিখ '.en2bn($modified_created_date).' ১৯১৩ সরকারি বকেয়া পাওনা আদায় আইনের ৫ ধারা মোতাবেক দায়ের করা হয়েছিল সার্টিফিকেট  দেনাদার জনাব '.$offender->citizen_name.' এর বিরুদ্ধে এবং নিম্নে বর্ণিত '.$total_amt.' টাকা উক্ত সার্টিফিকেট বাবদ তার নিকট প্রাপ্যঃ
            <table style="width: 100%">
                        <tr>
                            <th width="10%" style="text-align: justify">মুল দাবি</th>
                            <th width="30%" style="text-align: justify">'.en2bn($requestInfo->main_amount_29_dhara).' টাকা</th>
                        </tr>
                        <tr>
                        <th width="10%" style="text-align: justify">সুদ</th>
                            <th width="30%" style="text-align: justify">'.en2bn($requestInfo->interest_29_dhara).' টাকা</th>
                        </tr>
                        <tr>
                        <th width="10%" style="text-align: justify">খরচ</th>
                            <th width="30%" style="text-align: justify">'.en2bn($requestInfo->costing_29_dhara).'  টাকা</th>
                        </tr>
                        <tr>
                        <th width="10%" style="text-align: justify">কার্যকরীকরন</th>
                            <th width="30%" style="text-align: justify">'. en2bn($requestInfo->working_amount_29_dhara).' টাকা</th>
                        </tr>
                        <th width="10%" style="text-align: justify">মোট</th>
                            <th width="30%" style="text-align: justify">'. en2bn($total_amt).' টাকা</th>
                        </tr>
             </table>
             এবং যেহেতু উক্ত '. en2bn($total_amt).' টাকা সার্টিফিকেট দাবিদারের নিকট উক্ত সার্টিফিকেটের দাবি মিটানোর জন্য পরিষদ করা হয়নাই।
             উক্ত সার্টিফিকেট  দেনাদারকে গ্রেফতার করে এবং যতক্ষন পর্যন্ত উক্ত সার্টিফিকেট  দেনাদার আপনার নিকট '. en2bn($total_amt).'  টাকা এই প্রসেস  কার্যকরী করার খরচসহ প্রদান না করে , তাকে দ্রুত কোর্টে হাজির করার আদেশ দেয়া হচ্ছে। আপনাকে পরোয়ানা '.en2bn($requestInfo->trialDate).' তারিখ বা তার পূর্বে কিভাবে ইহা কার্যকরী করা হয়েছে অথবা কি কারনে ইহা কার্যকরী করা হয়নাই তার পৃষ্ঠাঅংকন ফেরত দেয়ার জন্য আরও আদেশ দেয়া হচ্ছে। 
            </div>
            <div>
                <span style="margin-left: 30px">আমার স্বাক্ষর ও আদালতের মোহর যুক্ত মতে দেওয়া গেল। </span>
                
            </div>
        </div>
        <div style="text-align: left">
            <span style="margin-left: 30px">তারিখ ঃ '.en2bn($conduct_date_modify_string).'</span>
        </div>
        <div style="text-align: right">
            <span> সার্টিফিকেট অফিসার </span><br>
            ' .
            $location .
            '
        </div>
    </div>';
        return $template;
    }

//--------------------------------------- দেনাদারকে সিভিল জেলে সোপর্দ ---------------------------------//
    public static function getSentToCivilCourtTemplate($appealInfo, $requestInfo)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        //$loanMoney=DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        //$offenderAddress=$offender->present_address;
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $applicant_name = $appealInfo['applicantCitizen'][0]->citizen_name;
        $modified_created_date = date_formater_helpers_make_bd_v2(explode(' ',$appealInfo['appeal']->created_at)[0]);
        $conduct_date_modify_array=explode('-',date_formater_helpers_v2($requestInfo->conductDate));
        $conduct_date_modify_string=$conduct_date_modify_array[2].'/'.$conduct_date_modify_array[1].'/'.$conduct_date_modify_array[0];
        
        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }
        $amount_to_deposite=$requestInfo->amount_to_deposite;
        $days_in_court=$requestInfo->days_in_court;
        $daily_cost_ta_da=$requestInfo->daily_cost_ta_da;

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>সার্টিফিকেট দেনাদারকে সিভিল জেলে সোপর্দ করার আদেশ</h3>
                <h4>
                    ( বিধি - ২৯ দ্রষ্টব্য )
                </h4>
            </div>
        </header>
        <br>
        <div>
            <div>
            <p style="text-align: justify;line-height: 30px;"> 
            প্রাপক: ' .$requestInfo->warrantExecutorName .'<br>
            ভারপাপ্ত কর্মকর্তা,<br>সিভিল জেল
           </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
            যেহেতু জনাব ' .$offender->citizen_name .' যাকে আমার সন্মুখে আজ '.en2bn($conduct_date_modify_string).' তারিখে আনায়ন করা হয়েছে অত্র অফিসে
            দায়েরকৃত '.$case_in_text.'  নং সার্টিফিকেট কেসে ১৯১৩ সালের সরকারি বকেয়া পাওনা আদায় আইনের ৫ ধারার অধীনে এবং সে সার্টিফিকেট আদেশ দেয়া 
            হয়েছিল যে '.en2bn($amount_to_deposite).' টাকা পরিশোধ করবেন ।
            <br>
            <br>
            যেহেতু উক্তু '.en2bn($amount_to_deposite).' টাকা পরিশোধ করেন নাই অথবা তিনি এই আমাকে এই মর্মে সন্তুষ্ট করেন নাই যে তিনি আটক অবস্থা থেকে মুক্তি পেতে পারেন । এতএব আপনাকে আদেশ দেয়া হচ্ছে আপনি উক্ত জনাব ' .$offender->citizen_name .' সিভিল জেলে গ্রহণ করে অনাধিক
            '.en2bn($days_in_court).' দিন জেলে আটকে অথবা যতদিন না উক্ত সার্টিফিকেট সম্পূর্ণরুপে পরিশোধ অথবা উক্ত আইনের ৩১ অথবা ৩২ ধারারর শর্ত মোতাবেগ
            মুক্তি পাওয়া অধিকার হয় এবং আমি এতদ্বারা '.en2bn($daily_cost_ta_da).' টাকা হারে দৈনিক ভাতা নির্ধারণ করলাম তার মাসিক খোরপোষ ভাতা এবং এই আদেশে আটক থাকার সময়ের জন্য । 
            
            </div>
        </div>
        <div style="text-align: left">
            <span style="margin-left: 30px">তারিখ ঃ '.en2bn($conduct_date_modify_string).'</span>
        </div>
        <div style="text-align: right">
            <span> সার্টিফিকেট অফিসার </span><br>
            ' .
            $location .
            '
        </div>
    </div>';

        return $template;
    }

    //--------------------------------------- সার্টিফিকেট কার্যকরী করার উদ্দেশ্যে জেলে আটক বাক্তিকে মুক্তি করার আদেশ ---------------------------------//
   public static function getReleasePerson($appealInfo, $requestInfo)
   {
    $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        //$loanMoney=DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        //$offenderAddress=$offender->present_address;
        $digital_case_no = $appealInfo['appeal']->case_no;
        $manual_case_no = $appealInfo['appeal']->manual_case_no;
        $applicant_name = $appealInfo['applicantCitizen'][0]->citizen_name;
        $modified_created_date = date_formater_helpers_make_bd_v2(explode(' ',$appealInfo['appeal']->created_at)[0]);
        $conduct_date_modify_array=explode('-',date_formater_helpers_v2($requestInfo->conductDate));
        $conduct_date_modify_string=$conduct_date_modify_array[2].'/'.$conduct_date_modify_array[1].'/'.$conduct_date_modify_array[0];
        
        if (!empty($manual_case_no)) {
            $case_in_text = $digital_case_no . ' / ' . $manual_case_no;
        } else {
            $case_in_text = $digital_case_no;
        }
 

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>সার্টিফিকেট কার্যকরী করার উদ্দেশ্যে জেলে আটক বাক্তিকে মুক্তি করার আদেশ</h3>
                <h4>
                    ( ধারা ৩১ এবং ৩২ দ্রষ্টব্য )
                </h4>
            </div>
        </header>
        <br>
        <div>
            <div>
            <p style="text-align: justify;line-height: 30px;"> 
            প্রাপক: ' .$requestInfo->warrantExecutorName .'<br>
            ভারপাপ্ত কর্মকর্তা,<br>সিভিল জেল
           </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
            এতদ্বারা আজকের আদেশ মোতাবেক আপনার জিম্মায় আটক সার্টিফিকেট দেনাদার জনাব '. $offender->citizen_name .'কে মুক্ত করার নির্দেশ দেয়া হোল ।
            
            </div>
            <div>
                <span style="margin-left: 30px">আমার স্বাক্ষর ও আদালতের মোহর যুক্ত মতে দেওয়া গেল। </span>
                
            </div>
        </div>
        <div style="text-align: left">
            <span style="margin-left: 30px">তারিখ ঃ '.en2bn($conduct_date_modify_string).'</span>
        </div>
        <div style="text-align: right">
            <span> সার্টিফিকেট অফিসার </span><br>
            ' .
            $location .
            '
        </div>
    </div>';
        return $template;
   }



    /****************************/
    public static function getCertificateRequestShortOrderTemplate($appealInfo, $causeList)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $defaulter = $appealInfo['defaulterCitizen'];
        $guarantorCitizen = $appealInfo['guarantorCitizen'];
        // dd($appealInfo);
        $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialTime = date('h:i:s a', strtotime($causeList->conduct_time));
        $trialBanglaYear = DataConversionService::toBangla(date('Y', strtotime($causeList->conduct_date)));

        $template =
            '
                    <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                            padding: 10px;
                            font-weight: normal;
                        }
                    </style>
            <div >
                <span style="font-size:  medium;">বাংলাদেশ ফরম নং ১০২৮  </span>
                        <header>
                            <div style="text-align: center">
                                <h3>সার্টিফিকেটের নিমিত্ত অনুরোধপত্র</h3>
                                <h3>(৫ নং ধারা দেখুন )। </h3>
                            </div>
                        </header>
             <br>
             <span style="float: right; font-size: medium">' .
            Session::get('districtName') .
            ' সার্টিফিকেট অফিসার মহাশয় বরাবরেষু</span>
             <br>
             <br>
            <div style="height:100%">
               <table width="100%">
                    <colgroup><col>
                    </colgroup><colgroup span="2"></colgroup>
                    <colgroup span="2"></colgroup>
                    <tbody><tr>
                        <th width="20%" rowspan="2">সার্টিফিকেট মত খাতকের নাম</th>
                        <th width="40%" rowspan="2">সার্টিফিকেট মত খাতকের ঠিকানা</th>
                        <th width="20%" colspan="2" scope="colgroup">যত রাজকীয় প্রাপ্যের নিমিত্ত এই অনুরোধপত্র <br> দেওয়া গেল</th>
                        <th width="20%" rowspan="2">যে প্রকারের রাজকীয় প্রাপ্যের নিমিত্ত এই অনুরোধ পত্র দেওয়া গেল</th>
                    </tr>
                    <tr>
                        <th scope="col"> টাকা</th>
                        <th scope="col"> পয়সা </th>
                    </tr>
                    <tr style="word-spacing: 4px;text-align: justify;">
                        <td>১ । ঋণ গ্রহীতা - ' .
            $defaulter->citizen_name .
            ', পিতা -' .
            $defaulter->father .
            ' ,মাতা -' .
            $defaulter->mother .
            '</td>
                        <td>ব্যবসায়িক ঠিকানা - ' .
            $defaulter->present_address .
            '  ,স্থায়ী ঠিকানা - ' .
            $defaulter->permanent_address .
            '</td>
                        <td>' .
            $loanAmountBng .
            ' টাকা </td>
                        <td>0</td>
                        <td></td>
                    </tr>
                    <tr style="word-spacing: 4px;text-align: justify;">
                        <td>গ্যারান্টর -' .
            ($guarantorCitizen != null ? $guarantorCitizen->citizen_name : '') .
            ', পিতা -' .
            ($guarantorCitizen != null ? $guarantorCitizen->father : '') .
            ' ,মাতা -' .
            ($guarantorCitizen != null ? $guarantorCitizen->mother : '') .
            '</td>
                        <td>ব্যবসায়িক ঠিকানা -' .
            $defaulter->present_address .
            '</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody></table>
                 <br>
                <div style="float: right;">
                     <span> [ অপর পৃষ্ঠায় দেখুন ] </span>

                 </div>
            </div>




                <div style="font-size:  medium;padding-top: 25%">

                    <span>
                     উক্ত    ......র স্থানে .................................... উপলক্ষ্যে উপরিলিখিত টাকা পাওনা আছে এ বিষয়ে অনুসন্ধান করিয়া আমার প্রতীতি জন্মিয়াছে ।  আপনার নিকট অনুরোধ ঐ টাকা আদায় করিবেন ।
                    </span>
                    <br>
                    <br>

                        <span>
                    ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' তারিখে সত্য পাঠযুক্ত করা গেল ।


                </span></div>
                <br>
                <br>
                <div style="float: right;font-size:medium;">
                     <span> প্রতিষ্ঠানের দায়িত্বপ্রাপ্ত ব্যক্তির নাম ও পদবি</span>

                    <br>
                    <br>
                 </div>
            </div>';
        // dd($template);
        return $template;
    }

    //---------------------------------সার্টিফিকেট  রাজকীয় প্রাপ্য  আইনের ৭৭ ধারা। ------------------------------------------------
    public static function getRajokioPrappoAinerDharaShortOrderTemplate($appealInfo, $causeList)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $offenderAddress = $offender->present_address;

        $template =
            '<div id="crimieDescription" class="arrest-warrant">
        <header>
            <div style="text-align: center">
                <h3>গ্রেফতারী পরোয়ানা কেন বাহির করা হইবে না <br> তাহার কারণ দর্শাইবার নোটিশ </h3>
                <h4>
                    ( রাজকীয় প্রাপ্য আইনের ৭৭ ধারা )
                </h4>
            </div>
        </header>
        <div>
            <p style="text-align: right">সার্টিফিকেট মোকদ্দমা নং ' .
            $caseNo .
            '</p>
        </div>
        <br>
        <div>
            <div>
                <p style="text-align: justify;line-height: 30px;"> প্রতি (খাতক): ' .
            $offender->citizen_name .
            ' পিতার নাম: ' .
            $offender->father .
            ' ঠিকানা: ' .
            $offender->present_address .
            ' </p>
            </div>
            <div style="text-align: justify;line-height: 30px;">
                <span style="margin-left: 30px">আপনাকে জানানো যাচ্ছে যে, </span>উক্ত সার্টিফিকেট মোকদ্দমার ' .
            $loanMoney .
            '
                টাকা আদায়ের জন্য কেন আপনাকে গ্রেফতার করা হইবে না তাহা নোটিশ পাওয়ার
                ....................... তারিখের মধ্যে এই আদালতে হাজির হইয়া তাহার কারণ
                দর্শাইবেন।  অন্যথায় সার্টিফিকেট আইনানুযায়ী যথারীতি ব্যবস্থা গ্রহণ করা হইবে।
            </div>
            <div>
                <span style="margin-left: 30px">আমার স্বাক্ষর ও আদালতের মোহর যুক্ত মতে দেওয়া গেল। </span>
            </div>
        </div>
        <div style="text-align: right">
            <span> সার্টিফিকেট অফিসার </span><br>
            ' .
            $location .
            '
        </div>

        <div>
           <h5 > বিঃ দ্রঃ এই নোটিশ অগ্রাহ্য করা হইলে গ্রেফতারী পরোয়ানা ইস্যু করা হইবে।</h5>
        </div>
    </div>';

        return $template;
    }

    //---------------------------------সার্টিফিকেট  পরোয়ানা রি-কল ------------------------------------------------
    public static function getPoroanaRecallShortOrderTemplate($appealInfo, $causeList)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();

        $location = $office_name->office_name_bn;
        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $offenderAddress = $offender->present_address;
        $currentBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));

        $template =
            '<div style="padding-top: 5%;">
            <div style="text-align: center">
                 <span>
                 গণপ্রজাতন্ত্রী বাংলাদেশ সরকার </br>
                ' .
            $location .
            '</br>
                 ( জেনারেল সার্টিফিকেট আদালত )</br>
                </span>
            </div></br>

            <div>
                <span>
                     স্বারক  সংখ্যাঃ  ৩৬৯  জি সি ও
                </span>
                <span style="float: right">
                     তারিখঃ ' .
            $currentBanglaDate .
            '
                </span>
            </div></br>
            <div>
                বিষয় : সার্টিফিকেট মামলা নং - ' .
            $caseNo .
            '  এর  খাতক ' .
            $offender->citizen_name .
            '  পিতা /স্বামী ' .
            $offender->father .
            ' ঠিকানা ' .
            $offenderAddress .
            ' এর বিরুদ্ধে জারীর জন্য প্রেরিত গ্রেফতারী/ক্রোকী পরোয়ানা রি-কল প্রদান প্রসঙ্গে ।
            </div></br>
            <div>
               <span>
              উপর্যুক্ত বিষয়ে আপনাকে জানানো যাচ্ছে যে, পিডিআর এক্ট ১৯১৩ এর বিধানমতে উল্লেখিত সার্টিফিকেট মামলার সমুদয় সরকারী দাবির টাকা আদায়ের লক্ষে উপরোক্ত খাতক/খাতকগণের বিরুদ্ধে গ্রেফতারী/ক্রোকী পরোয়ানা প্রেরণ করা হয়েছিল। উক্ত খাতক/খাতকগণ ইতোমধ্যে উচ্চ আদালতে আপীল দায়ের করেছেন/আংশিক পরিশোধ করেছেন/আপত্তি দাখিল করেছেন/আপোষ/মীমাংসা/সমুদয় অর্থ পরিশোধ করেছেন ।
            </span>
            </div></br>
            <div>
                <span>এমতাবস্থায়, উক্ত খাতক/খাতকগণের বিরুদ্ধে তামিলের নিমিত্তে আপনার থানায় প্রেরিত সকল গ্রেফতারী/ক্রোকী পরোয়ানা পরবর্তী নির্দেশ না দেয়া পর্যন্ত আপাততঃ বিনা জারীতে/বিনা তামিলে রি-কল দেয়ার নির্দেশ দেয়া হল।</span>
            </div></br>
            <div><table width="100%">
              <tr><td>ভারপ্রাপ্ত  কর্মকর্তা </br>
                    .................</td> <td class="text-right">জেনারেল সার্টিফিকেট  অফিসার</br>
                    ' .
            $location .
            '</td> </tr>
            </table></div>

    </div>';

        return $template;
    }

    //---------------------------------মামলার প্রত্যহার------------------------------------------------
    public static function getCaseRejectionApplicationShortOrderTemplate($appealInfo, $causeList)
    {
        $office_name = DB::table('office')
            ->where('id', '=', globalUserInfo()->office_id)
            ->first();
        $location = $office_name->office_name_bn;

        if ($office_name->level == 4) {
            $unoHeader = ' </br>
             উপজেলা নির্বাহী অফিসার</br>
             ও</br>';

            $UpazilaPorishoderPhokhe = 'উপজেলা পরিষদের পক্ষে</br>';
        } else {
            $unoHeader = '</br>';
            $UpazilaPorishoderPhokhe = '<br>';
        }

        $caseNo = DataConversionService::toBangla($appealInfo['appeal']->case_no);
        $loanMoney = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);
        $offender = $appealInfo['defaulterCitizen'];
        $offenderAddress = $offender->present_address;
        $currentBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));

        $template =
            '<div style="padding-top: 5%;">
        <span>
        বরাবর ' .
            $unoHeader .
            '
        জেনারেল সার্টিফিকেট অফিসার</br>
        ' .
            $location .
            '।</br>
        </br>
        বিষয় : সার্টিফিকেট মামলা নং - ' .
            $caseNo .
            ' প্রত্যাহার</br>
        </br>
        মহোদয়,</br>
        </span>
        <span style="margin-left: 40px;">সবিনয়ে জানাচ্ছি যে,</span> <span>
        উপজেলা পরিষদের বকেয়া টাকা আদায়ের লক্ষে আপনার আদালতে সার্টিফিকেট মামলা দায়ের করা হল।
        দায়েরকৃত ' .
            $caseNo .
            ' নং মামলার খাতক ' .
            $offender->citizen_name .
            ', পিতা-' .
            $offender->father .
            ', ' .
            $offenderAddress .
            '
        দাবীকৃত ' .
            $loanMoney .
            ' টাকা উপজেলা হাটবাজার হিশাব নং - ____________ তে জমা করে জমা স্লিপ নিম্ন স্বাক্ষরকারীর
        নিকট দাখিল করেছেন।
        </span></br>
        </br>
        <span style="margin-left: 40px;">এমতাবস্থায়,</span> <span>
        বর্ণিত মামলাটি প্রত্যাহারের প্রয়োজনীয় ব্যবস্থা গ্রহণের জন্য সবিনয়ে অনুরোধ করছি।</br>
        সংযুক্ত : জমা স্লিপ-০১ প্রস্থ।
        </span></br>
               </br>
        তারিখ : ' .
            $currentBanglaDate .
            '</br>
        <div style="float: right">
            <span style="margin-left: 20px">নিবেদক-</span></br>
            ' .
            $UpazilaPorishoderPhokhe .
            '
            ' .
            $appealInfo['appeal']->gco_name .
            '</br>
             জেনারেল সার্টিফিকেট অফিসার</br>
            ' .
            $appealInfo['appeal']->office_name .
            '</br>
        </div>
        </br>
        <span>
        দেখলাম</br>
        </br>
        জেনারেল সার্টিফিকেট অফিসার</br>
        ' .
            $unoHeader .
            '
        ' .
            $location .
            '</br>
        </span>

    </div>';
        //dd($template);
        return $template;
    }

    //---------------------------------------ক্রোক---------------------------------//

    //---------------------------------দেওয়ানী কারাগারে প্রেরণের জন্য কারণ দর্শানো ------------------------------------------------
    public static function getReasonToCriminalJailShortOrderTemplate($appealInfo, $causeList)
    {
        $template = '';
        $defaulter = $appealInfo['defaulterCitizen'];
        $appeal = $appealInfo['appeal'];

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->conduct_date)));
        $trialTime = date('h:i:s a', strtotime($causeList->conduct_time));
        $trialBanglaYear = DataConversionService::toBangla(date('Y', strtotime($causeList->conduct_date)));

        $appealBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($appeal->case_date)));
        $appealBanglaDay = DataConversionService::toBangla(date('d', strtotime($appeal->case_date)));
        $appealBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($appeal->case_date)));
        $appealBanglaYear = DataConversionService::toBangla(date('Y', strtotime($appeal->case_date)));

        $template =
            '<div style="font-size: medium;padding-top: 5%;">
                        <header>
                            <div style="text-align: center">
                                <h4>" কেন গ্রেফতারী পরোয়ানা ইস্যু করা হইবে না তাহার কারণ দর্শানোর নোটিশ "
                                <br>
                                 (বিধি  -৭৭ )</h4>
                                <br>

                            </div>
                        </header>
                        <div>
                             <p> প্রতি : জনাব  ' .
            $defaulter->citizen_name .
            ' পিতা ' .
            $defaulter->father .
            ' </p>

                                <p>সাং ............. পো : ................... উপজেলা ................</p>
                                <p> জেলা ................................ ।</p>
                            <p>
                                &emsp; যেহেতু ১৯৯৩ সালের পাবলিক ডিমান্ড রিকভারি এক্টের ৪/৬ ধারা অনুসারে আপনার বিরুদ্ধে ' .
            $appeal->case_no .
            ' নম্বরের এক সার্টিফিকেট ' .
            $appealBanglaYear .
            ' সালের ' .
            $appealBanlaMonth .
            ' মাসের ' .
            $appealBanglaDay .
            ' দিবসে এই অফিসে গাথিয়া রাখা হইয়াছে এবং যেহেতু আপনি দাবীকৃত অর্থ পরিশোধ করেন নাই সেহেতু আপনি আগামী ' .
            $trialBanglaDate .
            ' খ্রি  তারিখ আমার সম্মুখে হাজির হইয়া কেন আপনাকে দেওয়ানী কারাগারে সোপর্দ করা হইবে না তাহার কারণ দর্শাইবেন ।

                            </p>
                            <br>
                                <p align="center">
                                    অদ্য ' .
            $trialBanglaYear .
            ' সালের ' .
            $trialBanlaMonth .
            ' মাসের ' .
            $trialBanglaDay .
            ' দিবস ।
                                </p>
                                <br><br>
                                <p align="right">
                                    <p style=" text-align : center; color: blueviolet;">
                                            <img src="' .
            globalUserInfo()->signature .
            '" alt="signature" width="100" height="50">
                                            
                                            <br>' .
            '<b>' .
            globalUserInfo()->name .
            '</b>' .
            '<br> ' .
            '
                                        সার্টিফিকেট   অফিসার <br>
                                    </p>
                                    জেলা প্রশাসকের কার্যালয়, ' .
            user_district_name() .
            '
                                   
                                </p>

                        </div>
                 </div>';

        return $template;
    }



}
