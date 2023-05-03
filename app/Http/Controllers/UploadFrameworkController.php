<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PricingBook;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadFrameworkController extends Controller
{
    public function __invoke(Customer $customer)
    {
        $attribute = \request()->validate([
            'file' => ['required', 'file', 'max:5000', 'mimes:xlsx,xls,csv'],
        ]);
        $fileName = $attribute['file']->getPathName();
        $objPHPExcel = IOFactory::load($fileName);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = 'g';
        ini_set('max_execution_time', '0');
        for ($i = 2; $i <= $highestRow; $i++) {
            $rowData = $sheet->rangeToArray('A'.$i.':'.$highestColumn.$i, null, true, false)[0];
            if (PricingBook::query()->where('product_id', $rowData[2])->where('customer_id', $customer->id)->exists()) {
                $duplicates[] = $rowData[1];
                continue;
            }
            if (is_null($rowData[1])) {
                continue;
            }
            $data = [
                'customer_id' => $customer->id,
                'product_id' => $rowData[2],
                'unit_price' => $rowData[3],
            ];

            PricingBook::create($data);
        }

        return redirect()->back()->with(['success'=> 'Pricing book uploaded successfully', 'duplicates' => $duplicates ?? null]);
    }
}
