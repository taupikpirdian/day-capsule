<?php

use Carbon\Carbon;
use App\Models\Access;
use App\Models\InstitutionCategoryPart;
use Illuminate\Support\Facades\Auth;

function generateRandomString($length = 10):string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function inArrayCheck($arr, $valCheck)
{
    if(!in_array($valCheck, $arr)){
        return false;
    }
    return true;
}

function storeFile($request, $uuid, $nameForm, $type)
{
    $path = "";
    $generateName = "";

    if ($request->hasFile($nameForm)) {
        $generateName = extraxtFile($request->$nameForm)['name'];
        $path = $request->file($nameForm)->storeAs($uuid, $generateName, options: $type);
    }

    return [
        'path' => $path,
        'name_file' => $generateName,
    ];
}

function extraxtFile($file)
{
    $rand = generateRandomString();
    $ext = $file->getClientOriginalExtension();
    $name = $rand . "-" . date('YmdHis') . '.' . $ext;
    // Get the original name of the file
    $originalName = $file->getClientOriginalName();
    // Get the file extension (type)
    $fileExtension = $file->getClientOriginalExtension();

    return [
        'original_name' => $originalName,
        'name' => $name,
        'type_file' => $fileExtension,
    ];
}

function formatDateTime($date)
{
    if (!$date) return null;
    $carbonDate = Carbon::createFromFormat('Y-m-d H:i:s', $date);
    return $carbonDate->format('d/m/Y H:i');
}

function formatDateTimeV2($date)
{
    if (!$date) return null;
    $carbonDate = Carbon::createFromFormat('Y-m-d', $date);
    return $carbonDate->format('d/m/Y');
}

function fullPath($urlFile)
{
    return "<a target='_blank' href=" . "/file/berkas/" . $urlFile . " class='font-secondary'><i class='fa fa-download' aria-hidden='true'></i></a>";
}

function formatRupiah($amount){
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function splitDateRange($dateRange) {
    // Define the regular expression pattern for the date range format
    $pattern = '/^\d{4}-\d{2}-\d{2} to \d{4}-\d{2}-\d{2}$/';
    
    // Check if the input matches the pattern
    if (preg_match($pattern, $dateRange)) {
        // Split the date range string into start and end dates
        $dates = explode(' to ', $dateRange);
        
        // Return the array of dates
        return $dates;
    } else {
        // Return false if the format is incorrect
        return false;
    }
}

function dataCategoryPartByAuth()
{
    $data = Access::where('user_id', Auth::user()->id)->first();
    return $data ? $data->institution_category_part_id : null;
}

function dataCategoryByAuth()
{
    $data = Access::where('user_id', Auth::user()->id)->first();
    $category = InstitutionCategoryPart::find($data->institution_category_part_id);
    return $category ? $category->institution_category_id : null;
}

function typeFile($nameForm)
{
    $fileType = "";
    if($nameForm == "p2"){
        $fileType = FILE_P2;
    }elseif($nameForm == "ba_ekspose"){
        $fileType = FILE_BA_EKSPOSE;
    }elseif($nameForm == "capture_cms_p2"){
        $fileType = FILE_CAPTURE_CMS_P2;
    }elseif($nameForm == "pidsus7"){
        $fileType = FILE_PIDSUS_7;
    }elseif($nameForm == "p8"){
        $fileType = FILE_P8;
    }elseif($nameForm == "capture_cms_p8"){
        $fileType = FILE_CAPTURE_CMS_P8;
    }elseif($nameForm == "tap_tersangka"){
        $fileType = FILE_TAP_TERSANGKA;
    }elseif($nameForm == "p16"){
        $fileType = FILE_P16;
    }elseif($nameForm == "p21"){
        $fileType = FILE_P21;
    }elseif($nameForm == "p16a"){
        $fileType = FILE_P16A;
    }elseif($nameForm == "p31"){
        $fileType = FILE_P31;
    }elseif($nameForm == "p38"){
        $fileType = FILE_P38;
    }elseif($nameForm == "putusan"){
        $fileType = FILE_PUTUSAN;
    }elseif($nameForm == "surat_auditor"){
        $fileType = FILE_SURAT_AUDITOR;
    }elseif($nameForm == "p48"){
        $fileType = FILE_P48;
    }elseif($nameForm == "p48a"){
        $fileType = FILE_P48A;
    }elseif($nameForm == "d4"){
        $fileType = FILE_D4;
    }elseif($nameForm == "pidsus38"){
        $fileType = FILE_PIDSUS_38;
    }elseif($nameForm == "sp3"){
        $fileType = FILE_SP3;
    }

    return $fileType;
}

function convertCurrencyToInt($currency) {
    // Remove the currency symbol and any non-numeric characters except for the dot.
    $number = preg_replace('/[^\d]/', '', $currency);

    // Convert the cleaned string to an integer
    return (int)$number;
}

function folderGDrive($type)
{
    $folderName = "";
    if($type == PENYELIDIKAN){
        $folderName = GOOGLE_DRIVE_FOLDER_PENYELIDIKAN;
    }elseif($type == PENYIDIKAN){
        $folderName = GOOGLE_DRIVE_FOLDER_PENYIDIKAN;
    }elseif($type == TUNTUTAN){
        $folderName = GOOGLE_DRIVE_FOLDER_TUNTUTAN;
    }elseif($type == EKSEKUSI){
        $folderName = GOOGLE_DRIVE_FOLDER_EKSEKUSI;
    }

    return $folderName;
}

function nanRpStringToInt($currency){
    if($currency == "RpNaN"){
        $currency = 0;
    }
    return $currency;
}