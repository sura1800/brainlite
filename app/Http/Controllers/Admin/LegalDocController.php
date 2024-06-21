<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\LegalDocsImport;
use App\Models\LedgerDoc;
use App\Models\LegalDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use FilippoToso\PdfWatermarker\Facades\ImageWatermarker;
use FilippoToso\PdfWatermarker\Facades\TextWatermarker;
use FilippoToso\PdfWatermarker\Support\Position;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use LaravelFileViewer;
// use Milon\Barcode\Facades\DNS1DFacade;
// use Milon\Barcode\Facades\DNS2DFacade;

class LegalDocController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:LegalDoc access|LegalDoc create|LegalDoc edit|LegalDoc delete', ['only' => ['index', 'show', 'viewFile']]);
        $this->middleware('role_or_permission:LegalDoc create', ['only' => ['create', 'store', 'importLegalDoc', 'importLegalDocSubmit', 'fileUploadLegalDoc', 'fileUploadLegalDocSubmit']]);
        $this->middleware('role_or_permission:LegalDoc edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:LegalDoc delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // asset(asset_path('storage/upload/legaldoc/' . $data->doc_file))
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(LegalDoc::with('ledgers'))->addColumn('doc_file', function ($data) {

                    if (Storage::exists('public/upload/legaldoc/' . $data->doc_file)) {
                        return "<a target='_blank' href='" .  route('admin.view_legaldocs_file', $data->id)  . "'>$data->doc_file</a>";
                    } else {
                        return $data->doc_file;
                    }
                })->addColumn('uqlid', function ($data) {

                    return $data->ledgers->map(function ($ledger) {
                        return $ledger->uqlid;
                    })->implode(', ');
                })->addColumn('status_action', function ($data) {
                    $table = 'legal_docs';
                    return view('admin.layouts.partials.listing_status_switch', compact(['data', 'table']));
                })->addColumn('status', function ($data) {
                    return $data->status == 1 ? 'Active' :  "Inactive";
                })->addColumn('created_at', function ($data) {
                    return  date_format($data->created_at, "Y-M-d H:i");
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.legaldocs.edit', $data->id);
                    $deleteRoute = route('admin.legaldocs.destroy', $data->id);
                    $permission = 'LegalDoc';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission']))->render();
                })->addIndexColumn()->rawColumns(['doc_file', 'action', 'status_action', 'status', 'created_at', 'uqlid'])->make(true);
            }
            return view('admin.legaldoc.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LegalDoc  $legalDoc
     * @return \Illuminate\Http\Response
     */
    public function show(LegalDoc $legaldoc)
    {
        // $contents = Storage::get('public/upload/legaldoc/'. $legaldoc->doc_file);
        // $url = Storage::url('public/upload/legaldoc/'. $legaldoc->doc_file);
        // $spath = Storage::path('public/upload/legaldoc/' . $legaldoc->doc_file);

        // dd($spath);
        // $url = Storage::temporaryUrl(
        //     'public/upload/legaldoc/'. $legaldoc->doc_file, now()->addMinutes(5)
        // );

        // $path = Storage::putFile('files', new File($spath));


        // dd($path);
        // dd($legaldoc);
        // $legaldoc->update(['status' =>0]);
        // return response()->json($legaldoc);
        // $pathToFile = storage_path().'/upload/legaldoc/'.$legaldoc->doc_file ;
        // $pathToFile = asset(asset_path('storage/upload/legaldoc/' . $legaldoc->doc_file));
        // return redirect($pathToFile);
        // return response()->download($pathToFile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LegalDoc  $legalDoc
     * @return \Illuminate\Http\Response
     */
    public function edit(LegalDoc $legaldoc)
    {

        $unAssignedLedgers = LedgerDoc::doesntHave('legalnocs')->where('aadhaar_no', $legaldoc->aadhaar_no)->get();
        $assignedLedgers = $legaldoc->ledgers->makeHidden('pivot');

        // $ledgers =  collect(array_merge($assignedLedgers, $unAssignedLedgers));
        $ledgers = $unAssignedLedgers->concat($assignedLedgers);
        // dd($ledgers);

        return view('admin.legaldoc.edit', compact(['legaldoc', 'ledgers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LegalDoc  $legalDoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LegalDoc $legaldoc)
    {
        $validated =  $request->validate([
            'noc_no' => "required|string|unique:legal_docs,noc_no, $legaldoc->id",
            'aadhaar_no' => "required|digits:12|numeric",
            // 'main_image' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            'location' => 'required|max:190',
            'admin_comment' => 'max:1000',
            'ledgers.*' => '',
        ]);

        $validated['slug'] = $validated['aadhaar_no'] . '-' . $validated['noc_no'];

        if (isset($validated['ledgers'])) {
            $legaldoc->ledgers()->sync($validated['ledgers']);
        }

        $legaldoc->update($validated);
        return redirect()->back()->withSuccess('NOC updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LegalDoc  $legalDoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(LegalDoc $legaldoc)
    {

        $legalNocDetails = LegalDoc::with('ledgers')->where('id', $legaldoc->id)->first();

        if (count($legalNocDetails->ledgers) > 0) {
            $ledgerIds = $legalNocDetails->ledgers->pluck('id')->toArray();
            $legaldoc->ledgers()->detach($ledgerIds);
        }
        Storage::delete('public/upload/legaldoc/' . $legalNocDetails->doc_file);
        Storage::delete('public/upload/qrimg/' . $legalNocDetails->uqid . '.png');
        $legaldoc->delete();
        return redirect()->back()->withSuccess('Legal NOC deleted !!!');
    }

    public function importLegalDoc()
    {
        return view('admin.legaldoc.import');
    }
    public function importLegalDocSubmit(Request $request)
    {
        $validated =  $request->validate([
            'legaldoc_import_file' => 'file|mimes:xlsx|max:102400',
        ]);

        if ($request->hasFile('legaldoc_import_file')) {
            if ($request->file('legaldoc_import_file')->isValid()) {
                Excel::import(new LegalDocsImport, $request->file('legaldoc_import_file')->store('temp'));
                return redirect()->back()->withSuccess('Legal Doc file uploaded successfully !!!');
            }
        } else {
            return redirect()->back()->withErrors('Invalid Legal Doc import file !!!');
        }
    }


    public function fileUploadLegalDoc()
    {
        return view('admin.legaldoc.fileupload');
    }
    public function fileUploadLegalDocSubmit(Request $request)
    {
        $validated =  $request->validate([
            'file' => 'required|file|mimes:pdf|min:1|max:50000'
        ]);


        $uploadedFile = $request->file('file');
        $fileName = $request->file('file')->getClientOriginalName();

        $uploadedFile->storeAs(Config::get('app_url.asset_legaldoc_url'), $fileName);

        $ldoc = LegalDoc::where('doc_file', $fileName)->first();

        if ($ldoc) {
            $inputPdf = Config::get('app_url.asset_base_path') . 'storage/upload/legaldoc/' . $ldoc->doc_file;
            $watermarkImg = Config::get('app_url.asset_base_path') . 'storage/upload/qrimg/' . $ldoc->uqid . '.png';
            $savepath = Config::get('app_url.asset_base_path') . 'storage/upload/legaldoc/' . $ldoc->doc_file;
            $textStr = 'Date - ' . date_format($ldoc->created_at, 'd-m-Y') . '  ' .  'Time - ' . date_format($ldoc->created_at, 'h:i A');


            try {
                ImageWatermarker::input($inputPdf)
                    ->watermark($watermarkImg)
                    ->output($savepath)
                    ->position(Position::TOP_RIGHT, -2, 5)
                    ->asBackground()
                    ->pageRange(0)
                    ->resolution(150) //  dpi
                    ->save();

                TextWatermarker::input($savepath)->output($savepath)
                    ->position(Position::TOP_RIGHT, -2, 1)
                    ->asBackground()
                    ->pageRange(0)
                    ->text($textStr)
                    ->angle(0)
                    ->font(Config::get('app_url.asset_base_path') . 'arial.ttf')
                    ->size('13')
                    ->color('#000000')
                    ->resolution(150) //  dpi
                    ->save();
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['success' => false, 'message' => $th->getMessage()], 404);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Data ralated to this file was not found.'], 404);
        }

        return response()->json(['success' => true, 'message' => $fileName]);
    }

    function viewFile(LegalDoc $legaldoc)
    {
        $filename = $legaldoc->doc_file;
        $filepath = 'public/upload/legaldoc/' . $filename;
        $file_url = asset(asset_path('storage/upload/legaldoc/' . $filename));
        $qrImg = asset(asset_path('storage/upload/qrimg/' . $legaldoc->uqid . '.png'));
        $createDate = 'Date - ' . date_format($legaldoc->created_at, 'd-m-Y') . '  ' .  'Time - ' . date_format($legaldoc->created_at, 'h:i A');

        $file_data = [
            [
                'label' => __('Label'),
                'value' => "Value",
                'noc_no' => $legaldoc->noc_no,
                'qrimg' => $qrImg,
                'datetime' => $createDate,
            ]
        ];

        return LaravelFileViewer::show($filename, $filepath, $file_url, $file_data);
    }
}
