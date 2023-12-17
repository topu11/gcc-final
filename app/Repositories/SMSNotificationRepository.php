<?php

namespace App\Repositories;

use App\Models\EmAppeal;
use App\Models\GccAppeal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SMSNotificationRepository
{
    public static function send_sms($mobile, $message)
    {
        // print_r($mobile.' , '.$message);exit('zuel');
        Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
            'auth' => [
                'username' => 'ecourt',
                'password' => 'A2ist2#0166',
                'acode' => 1005370,
            ],
            'smsInfo' => [
                'message' => $message,
                'is_unicode' => 1,
                'masking' => 8801552146224,
                'msisdn' => [
                    '0' => $mobile,
                ],
            ],
        ]);
    }
    public static function send_sms_multiple($msisdn, $message)
    {
        // print_r($msisdn).'sms' .print_r($message);exit('alis');
        //   var_dump($msisdn);
        //   var_dump($message);
        //   exit('zuel');
        //$msisdn=$mobile;

        Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
            'auth' => [
                'username' => 'ecourt',
                'password' => 'A2ist2#0166',
                'acode' => 1005370,
            ],
            'smsInfo' => [
                'message' => $message,
                'is_unicode' => 1,
                'masking' => 8801552146224,
                'msisdn' => $msisdn,
            ],
        ]);
    }

    public static function seven_dara_notice_sms_defaulter($requestInfo, $shortorderTemplateUrl)
    {
        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
        $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();

        $dummy = ['{#name2}', '{#nextdate}'];

        $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        self::send_sms($mobile, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;
                self::send_sms($mobile, $message2);
            }
        }
    }
    public static function seven_dara_notice_sms_nominee($requestInfo, $shortorderTemplateUrl)
    {
        $nominees_appeal = DB::table('gcc_appeal_citizens')
            ->where('appeal_id', '=', $requestInfo->appealId)
            ->where('citizen_type_id', '=', 5)
            ->get();

        $nominees_appeal_array = [];
        foreach ($nominees_appeal as $nominees_appeal_single) {
            array_push($nominees_appeal_array, $nominees_appeal_single->citizen_id);
        }

        $nominees = DB::table('gcc_citizens')
            ->whereIn('id', $nominees_appeal_array)
            ->get();
        $msisdn = [];
        //organization

        foreach ($nominees as $nomineepeoplesingle) {
            array_push($msisdn, $nomineepeoplesingle->citizen_phone_no);
        }

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();

        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);

        $dummy = ['{#name2}', '{#nextdate}'];

        $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        self::send_sms_multiple($msisdn, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;

                self::send_sms_multiple($msisdn, $message2);
            }
        }
    }
    public static function case_close_sms_defaulter($requestInfo, $shortorderTemplateUrl)
    {
        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
        $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();

        $dummy = ['{#name2}'];

        $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        self::send_sms($mobile, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;
                self::send_sms($mobile, $message2);
            }
        }
    }
    public static function case_close_notice_sms_nominee($requestInfo, $shortorderTemplateUrl)
    {
        $nominees_appeal = DB::table('gcc_appeal_citizens')
            ->where('appeal_id', '=', $requestInfo->appealId)
            ->where('citizen_type_id', '=', 5)
            ->get();

        $nominees_appeal_array = [];
        foreach ($nominees_appeal as $nominees_appeal_single) {
            array_push($nominees_appeal_array, $nominees_appeal_single->citizen_id);
        }

        $nominees = DB::table('gcc_citizens')
            ->whereIn('id', $nominees_appeal_array)
            ->get();
        $msisdn = [];
        //organization

        foreach ($nominees as $nomineepeoplesingle) {
            array_push($msisdn, $nomineepeoplesingle->citizen_phone_no);
        }

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();

        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);

        $dummy = ['{#name2}'];

        $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        self::send_sms_multiple($msisdn, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;

                self::send_sms_multiple($msisdn, $message2);
            }
        }
    }
    public static function crock_sms_defaulter($requestInfo, $shortorderTemplateUrl)
    {
        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);
        $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();

        $dummy = ['{#name2}','{#nextdate}'];

        $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        $message .='নিলামের জন্য format '.url('').'/download_template/'.'crock.docx'; 
        self::send_sms($mobile, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $mobile = $citizenInfo['defaulterCitizen']->citizen_phone_no;
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;
                self::send_sms($mobile, $message2);
            }
        }
    }
    public static function crock_close_notice_sms_nominee($requestInfo, $shortorderTemplateUrl)
    {
        $nominees_appeal = DB::table('gcc_appeal_citizens')
            ->where('appeal_id', '=', $requestInfo->appealId)
            ->where('citizen_type_id', '=', 5)
            ->get();

        $nominees_appeal_array = [];
        foreach ($nominees_appeal as $nominees_appeal_single) {
            array_push($nominees_appeal_array, $nominees_appeal_single->citizen_id);
        }

        $nominees = DB::table('gcc_citizens')
            ->whereIn('id', $nominees_appeal_array)
            ->get();
        $msisdn = [];
        //organization

        foreach ($nominees as $nomineepeoplesingle) {
            array_push($msisdn, $nomineepeoplesingle->citizen_phone_no);
        }

        $sms_details = DB::table('gcc_case_shortdecisions')
            ->where('id', '=', $requestInfo->shortOrder[0])
            ->first();

        $citizenInfo = CitizenRepository::getDefaulterCitizen($requestInfo->appealId);

        $dummy = ['{#name2}','{#nextdate}'];

        $original = [$citizenInfo['defaulterCitizen']->citizen_name, $requestInfo->trialDate];

        $message = str_replace($dummy, $original, $sms_details->template_code);
        $message .='নিলামের জন্য format '.url('').'/download_template/'.'crock.docx'; 
        self::send_sms_multiple($msisdn, $message);

        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
                $message2 = 'জেনারেল সার্টিফিকেট আদালতে নোটিশ দেখতে প্রবেশ করুন ' . $value;

                self::send_sms_multiple($msisdn, $message2);
            }
        }
    }
}
