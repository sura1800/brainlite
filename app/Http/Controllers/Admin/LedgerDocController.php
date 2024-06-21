<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\LedgerDocsImport;
use App\Models\LedgerDoc;
use App\Models\LegalDoc;
use Illuminate\Http\Request;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use FilippoToso\PdfWatermarker\Facades\ImageWatermarker;
use FilippoToso\PdfWatermarker\Facades\TextWatermarker;
use FilippoToso\PdfWatermarker\Support\Position;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use LaravelFileViewer;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;

// use Intervention\Image\ImageManager;


class LedgerDocController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:LedgerDoc access|LedgerDoc create|LedgerDoc edit|LedgerDoc delete', ['only' => ['index', 'show', 'viewFile']]);
        $this->middleware('role_or_permission:LedgerDoc create', ['only' => ['create', 'store', 'importLedgerDoc', 'importLedgerDocSubmit', 'fileUploadLedgerDoc', 'fileUploadLedgerDocSubmit']]);
        $this->middleware('role_or_permission:LedgerDoc edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:LedgerDoc delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return DataTables::eloquent(LedgerDoc::with('legalnocs'))->addColumn('ledger_file', function ($data) {

                    if (Storage::exists('public/upload/ledgerdoc/' . $data->ledger_file)) {
                        return "<a target='_blank' href='" .  route('admin.view_ledgerdocs_file', $data->id)  . "'>$data->ledger_file</a>";
                    } else {
                        return $data->ledger_file;
                    }
                })->addColumn('noc', function ($data) {
                    return $data->legalnocs->map(function ($noc) {
                        return $noc->noc_no;
                    })->implode(', ');
                })->addColumn('status_action', function ($data) {
                    $table = 'ledger_docs';
                    return view('admin.layouts.partials.listing_status_switch', compact(['data', 'table']));
                })->addColumn('status', function ($data) {
                    return $data->status == 1 ? 'Active' :  "Inactive";
                })->addColumn('created_at', function ($data) {
                    return  date_format($data->created_at, "Y-M-d H:i");
                })->addColumn('action', function ($data) {
                    $editRoute = route('admin.ledgerdocs.edit', $data->id);
                    $deleteRoute = route('admin.ledgerdocs.destroy', $data->id);
                    $permission = 'LedgerDoc';

                    return view('admin.layouts.partials.edit_delete_btn', compact(['data', 'editRoute', 'deleteRoute', 'permission']))->render();
                })->addIndexColumn()->rawColumns(['ledger_file', 'action', 'status_action', 'status', 'created_at', 'noc'])->make(true);
            }
            return view('admin.ledgerdoc.index');
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
        //
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
     * @param  \App\Models\LedgerDoc  $ledgerDoc
     * @return \Illuminate\Http\Response
     */
    public function show(LedgerDoc $ledgerDoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LedgerDoc  $ledgerDoc
     * @return \Illuminate\Http\Response
     */
    public function edit(LedgerDoc $ledgerdoc)
    {
        return view('admin.ledgerdoc.edit', compact(['ledgerdoc']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LedgerDoc  $ledgerDoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LedgerDoc $ledgerdoc)
    {
        $validated =  $request->validate([
            // 'noc_no' => "required|string|unique:legal_docs,noc_no, $ledgerdoc->id",
            // 'main_image' => 'file|image|mimes:jpg,jpeg,png,webp,svg|min:1|max:500',
            'aadhaar_no' => "required|digits:12|numeric",
            'admin_comment' => 'max:1000',
        ]);

        $validated['slug'] = $validated['aadhaar_no'] . '-' . $ledgerdoc->uqlid;

        $ledgerdoc->update($validated);
        return redirect()->back()->withSuccess('Ledger updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LedgerDoc  $ledgerDoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(LedgerDoc $ledgerdoc)
    {
        $legerDetails = LedgerDoc::with('legalnocs')->where('id', $ledgerdoc->id)->first();

        if (count($legerDetails->legalnocs) > 0) {
            $legalNocIds = $legerDetails->legalnocs->pluck('id')->toArray();
            $ledgerdoc->legalnocs()->detach($legalNocIds);
        }

        Storage::delete('public/upload/ledgerdoc/' . $ledgerdoc->ledger_file);
        Storage::delete('public/upload/ledger_qrimg/' . $ledgerdoc->uqlid . '.png');

        // dd($legalNocIds);

        $ledgerdoc->delete();
        return redirect()->back()->withSuccess('Ledger deleted !!!');
    }

    public function importLedgerDoc()
    {
        return view('admin.ledgerdoc.import');
    }
    public function importLedgerDocSubmit(Request $request)
    {
        $validated =  $request->validate([
            'ledgerdoc_import_file' => 'file|mimes:xlsx|max:102400',
        ]);

        if ($request->hasFile('ledgerdoc_import_file')) {
            if ($request->file('ledgerdoc_import_file')->isValid()) {
                Excel::import(new LedgerDocsImport, $request->file('ledgerdoc_import_file')->store('temp'));
                return redirect()->back()->withSuccess('Ledger Doc file uploaded successfully !!!');
            }
        } else {
            return redirect()->back()->withErrors('Invalid Ledger Doc import file !!!');
        }
    }


    public function fileUploadLedgerDoc()
    {
        return view('admin.ledgerdoc.fileupload');
    }
    public function fileUploadLedgerDocSubmit(Request $request)
    {
        $validated =  $request->validate([
            'file' => 'required|file|mimes:pdf|min:1|max:50000'
        ]);

        // return response()->json(['success' => true, 'message' => "fghdfg"]);
        // dd();
        $uploadedFile = $request->file('file');
        $fileName = $request->file('file')->getClientOriginalName();

        $uploadedFile->storeAs(Config::get('app_url.asset_ledgerdoc_url'), $fileName);

        $ldoc = LedgerDoc::where('ledger_file', $fileName)->first();

        if ($ldoc) {
            $inputPdf = Config::get('app_url.asset_base_path') . 'storage/upload/ledgerdoc/' . $ldoc->ledger_file;
            $watermarkImg = Config::get('app_url.asset_base_path') . 'storage/upload/ledger_qrimg/' . $ldoc->uqlid . '.png';
            $savepath = Config::get('app_url.asset_base_path') . 'storage/upload/ledgerdoc/' . $ldoc->ledger_file;
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

    function viewFile(LedgerDoc $ledgerdoc)
    {
        $filename = $ledgerdoc->ledger_file;
        $filepath = 'public/upload/ledgerdoc/' . $filename;
        $file_url = asset(asset_path('storage/upload/ledgerdoc/' . $filename));
        $qrImg = asset(asset_path('storage/upload/ledger_qrimg/' . $ledgerdoc->uqlid . '.png'));
        $createDate = 'Date - ' . date_format($ledgerdoc->created_at, 'd-m-Y') . '  ' .  'Time - ' . date_format($ledgerdoc->created_at, 'h:i A');

        $file_data = [
            [
                'label' => __('Label'),
                'value' => "Value",
                'noc_no' => $ledgerdoc->uqlid,
                'qrimg' => $qrImg,
                'datetime' => $createDate,
            ]
        ];

        return LaravelFileViewer::show($filename, $filepath, $file_url, $file_data);
    }

    // ---------------------------------------------------------------
    public function imgFileUploadLedgerDoc()
    {
        return view('admin.ledgerdoc.imgfileupload');
    }
    public function imgFileUploadLedgerDocSubmit(Request $request)
    {
        $validated =  $request->validate([
            'file' => 'required|file|mimes:jpg,png,jpeg|min:1|max:50000'
        ]);

        $uploadedFile = $request->file('file');
        $fileName = $request->file('file')->getClientOriginalName();


        $ldoc = LedgerDoc::where('ledger_file', $fileName)->first();

        if ($ldoc) {
            // $uploadedFile->storeAs(Config::get('app_url.asset_ledgerdoc_url'), $fileName);
            // $inputPdf = Config::get('app_url.asset_base_path') . 'storage/upload/ledgerdoc/' . $ldoc->ledger_file;
            $watermarkImg = Config::get('app_url.asset_base_path') . 'storage/upload/ledger_qrimg/' . $ldoc->uqlid . '.png';
            $savepath = Config::get('app_url.asset_base_path') . 'storage/upload/ledgerdoc/' . $ldoc->ledger_file;
            $textStr = 'Date - ' . date_format($ldoc->created_at, 'd-m-Y') . '  ' .  'Time - ' . date_format($ldoc->created_at, 'h:i A');

            try {
                $imgFile = Image::read($uploadedFile);

                $imgWidth = $imgFile->width();
                $imgHeight = $imgFile->height();
                $textXPosition = $imgWidth - 220;
                $textYPosition = $imgHeight - 30;

                $storeFile = $imgFile->place($watermarkImg, 'bottom-right', 30, 50, 100)->text($textStr, $textXPosition, $textYPosition, function (FontFactory $font) {
                    $font->filename(Config::get('app_url.asset_base_path') . 'arial.ttf');
                    $font->size(24);
                    $font->color('000');
                    $font->align('center');
                    $font->valign('middle');
                    $font->lineHeight(1.6);
                    $font->angle(0);
                    $font->wrap(400);
                })->save($savepath);
                // Storage::putFile($savepath, $imgFile);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => $th->getMessage()], 404);
            }
        } else {
            return response()->json(['success' => false, 'message' => "Ledger Not found"], 404);
        }



        return response()->json(['success' => true, 'message' => $fileName]);
    }
    // ---------------------------------------------------------------
}
