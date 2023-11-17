<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImportExcelRequest;
use App\Imports\MergeData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MergeController extends Controller
{

    public function __construct()
    {
        // 
    }

    public function index()
    {
    
        return view('pages.merge.index');
    }

    public function import(StoreImportExcelRequest $request)
    {
        $type = $request->route('type');
        $file = $request->file('file');

        $import = '';
        switch ($type) {
            case 'school':
                $import = new MergeData;
                break;

        }
        $import->import($file);

        return back()->withSuccess('Successfully merge data');
    }



  
}
