<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormDownLoadController extends Controller
{
    public function index()
    {
        if(globalUserInfo()->role_id == 35 || globalUserInfo()->role_id == 36)
        {
             
             $data['page_title'] = 'ফর্ম ডাউনলোড';
             $data['downloadable_files']=[
                [
                    'file_name'=>'দায় অস্বীকার',
                    'file_location'=>url('').'/download_template/'.'defaulter_disagree_format.docx'
                ],
                [
                    'file_name'=>'সম্পত্তি নিলামে বিক্রি',
                    'file_location'=>url('').'/download_template/'.'crock.docx'
                ]                
             ];
             //dd($data);
             return view('form_download.citizen_form_download')->with($data);
        }else
        {
            $data['page_title'] = 'ফর্ম ডাউনলোড';
            $data['downloadable_files']=[
                [
                    'file_name'=>'দায় অস্বীকার',
                    'file_location'=>url('').'/download_template/'.'defaulter_disagree_format.docx'
                ],
                [
                    'file_name'=>'সম্পত্তি নিলামে বিক্রি',
                    'file_location'=>url('').'/download_template/'.'crock.docx'
                ]                
             ];
            return view('form_download.form_download')->with($data);
        }
        
    }
}
