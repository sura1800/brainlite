<?php

namespace App\Imports;

use App\Models\LegalDoc;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;
use Milon\Barcode\Facades\DNS2DFacade;

class LegalDocsImport implements ToModel, WithStartRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!LegalDoc::where(['noc_no' => $row[2]])->exists()) {


            $aadhar = ($row[1] !== "") ? preg_replace('/\s+/', '', $row[1]) : "";
            $noc = ($row[2] !== "") ? ($row[2]) : "";
            $slug = $aadhar . '-' . Str::slug($noc);
            $unique_code = IdGenerator::generate(['table' => 'legal_docs', 'field' => 'uqid', 'length' => 17, 'prefix' => "JB" . date('dYm'). "N", 'reset_on_prefix_change' => true]);

            $fullCode = $unique_code . date('Hi');


            Storage::disk('public')->put('upload/qrimg/' . $fullCode . '.png', base64_decode(DNS2DFacade::getBarcodePNG($fullCode, 'QRCODE')));

            


            return new LegalDoc([
                'uqid'     => $fullCode,
                'aadhaar_no'     => $aadhar,
                'noc_no'     => $noc,
                'location'     => ($row[3] !== "") ? $row[3] : "",
                'doc_file'     => ($row[4] !== "") ? $row[4] : "",
                'admin_comment'     => ($row[5] !== "") ? $row[5] : "",
                'slug' => $slug,
            ]);
        }
    }







    public function rules(): array
    {
        return [
            '1' => "required|size:12|integer",
            '2' => "required|unique:legal_docs,noc_no",
            '3' => "required|string",
            '4' => "required|string|unique:legal_docs,doc_file",
        ];
    }

    public function customValidationMessages()
    {
        return [
            '2.unique' => 'Noc no already added.',
            '4.unique' => 'File name already associated with some other users.',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }
}
