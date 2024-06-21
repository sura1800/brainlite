<?php

namespace App\Imports;

use App\Models\LedgerDoc;
use App\Models\LegalDoc;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Milon\Barcode\Facades\DNS2DFacade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class LedgerDocsImport implements WithStartRow, WithValidation, OnEachRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {

    //     if (!LedgerDoc::where(['ledger_file' => $row[3]])->exists()) {


    //         $aadhar = ($row[1] !== "") ? preg_replace('/\s+/', '', $row[1]) : "";
    //         $noc = ($row[2] !== "") ? ($row[2]) : "";           


    //         $unique_code = IdGenerator::generate(['table' => 'ledger_docs', 'field' => 'uqlid', 'length' => 17, 'prefix' => "JB" . date('dYm'). "L", 'reset_on_prefix_change' => true]);

    //         $fullCode = $unique_code . date('Hi');

    //         $slug = $aadhar . '-' . $fullCode;

    //         Storage::disk('public')->put('upload/ledger_qrimg/' . $fullCode . '.png', base64_decode(DNS2DFacade::getBarcodePNG($fullCode, 'QRCODE')));


    //         $ledger =  new LedgerDoc([
    //             'uqlid'     => $fullCode,
    //             'aadhaar_no'     => $aadhar,
    //             // 'noc_no'     => $noc,
    //             'ledger_file'     => ($row[3] !== "") ? $row[3] : "",
    //             'admin_comment'     => ($row[4] !== "") ? $row[4] : "",
    //             'slug' => $slug,
    //         ]);

    //         if ($noc) {
    //             $legalNoc = LegalDoc::where(['uqid'=> $noc, 'aadhaar_no' => $aadhar])->first();
    //             if ($legalNoc) {
    //                 $legalNoc->ledgers()->attach([$ledger->id]);

    //                 // $legalNoc->setRelation('ledgers', new LedgerDoc(['aadhaar_no' => $aadhar]));

    //             }    

    //         }

    //         return $ledger;
    //     }

    // }

    public function onRow(Row $row)
    {
        if (!LedgerDoc::where(['ledger_file' => $row[3]])->exists()) {


            $aadhar = ($row[1] !== "") ? preg_replace('/\s+/', '', $row[1]) : "";
            $noc = ($row[2] !== "") ? ($row[2]) : "";


            $unique_code = IdGenerator::generate(['table' => 'ledger_docs', 'field' => 'uqlid', 'length' => 17, 'prefix' => "JB" . date('dYm') . "L", 'reset_on_prefix_change' => true]);

            $fullCode = $unique_code . date('Hi');

            $slug = $aadhar . '-' . $fullCode;

            Storage::disk('public')->put('upload/ledger_qrimg/' . $fullCode . '.png', base64_decode(DNS2DFacade::getBarcodePNG($fullCode, 'QRCODE')));

            $ledger = LedgerDoc::create([
                'uqlid'     => $fullCode,
                'aadhaar_no'     => $aadhar,
                // 'noc_no'     => $noc,
                'ledger_file'     => ($row[3] !== "") ? $row[3] : "",
                'admin_comment'     => ($row[4] !== "") ? $row[4] : "",
                'slug' => $slug,
            ]);


            if ($noc) {
                $legalNoc = LegalDoc::where(['uqid' => $noc, 'aadhaar_no' => $aadhar])->first();
                if ($legalNoc) {
                    $legalNoc->ledgers()->attach([$ledger->id]);
                }
            }

            return $ledger;
        }
    }

    public function rules(): array
    {
        return [
            '1' => "required|digits:12|numeric",
            // '2' => "required|unique:legal_docs,noc_no",
            // '3' => "required|string",
            '3' => "required|string|unique:ledger_docs,ledger_file",
        ];
    }

    public function customValidationMessages()
    {
        return [
            // '2.unique' => 'Noc no already added.',
            '3.unique' => 'File name already associated with some other users.',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }
}
