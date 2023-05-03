<?php

namespace App\Http\Controllers;

use App\Models\MeasurementUnit;
use App\Models\ProductCategory;
use App\Models\Products;
use App\Models\Subcategory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::query()->with(['category', 'unit', 'subcategory'])->get();
        if (request()->ajax()) {
            return datatables($products)
                ->editColumn('product_unit_price', function ($product) {
                    return number_format($product->product_unit_price, 0, '.', ',').' Rwf';
                })
                ->editColumn('option', 'products.partials.action')
                ->rawColumns(['option'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('products.index', [
            'categories' => ProductCategory::all(),
            'subcategories' => Subcategory::all(),
            'units' => MeasurementUnit::all(),
        ]);
    }

    public function edit(Products $product)
    {
        return view('products.edit', [
            'categories' => ProductCategory::all(),
            'subcategories' => Subcategory::all(),
            'units' => MeasurementUnit::all(),
            'product' => $product,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'product_name' => ['required', 'string'],
            'product_quantity' => ['required'],
            'product_unit_price' => ['required'],
            'category_id' => ['required', 'integer'],
            'subcategory_id' => ['required', 'integer'],
            'measurement_unit' => ['required', 'integer'],

        ]);

        $productCode = [
            'table' => 'products',
            'field' => 'product_code',
            'length' => 7,
            'prefix' => 'MPS',
            'reset_on_prefix_change' => true,
        ];
        $data['product_code'] = IdGenerator::generate($productCode);

        Products::create($data);

        return redirect()->back()->with('success', 'Product created successfully');
    }

    public function upload()
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
            if (Products::query()->where('product_name', $rowData[1])->exists()) {
                $duplicates[] = $rowData[1];
                continue;
            }
            if (is_null($rowData[1])) {
                continue;
            }
            $data = [
                'product_name' => $rowData[1],
                'product_quantity' => $rowData[2],
                'product_unit_price' => $rowData[3],
                'category_id' => $rowData[4],
                'subcategory_id' => $rowData[5],
                'measurement_unit' => $rowData[6],

            ];
            $productCode = [
                'table' => 'products',
                'field' => 'product_code',
                'length' => 7,
                'prefix' => 'MPS',
                'reset_on_prefix_change' => true,
            ];
            $data['product_code'] = IdGenerator::generate($productCode);
            Products::create($data);
        }

        return redirect()->back()->with(['success'=> 'Products uploaded successfully', 'duplicates' => $duplicates ?? null]);
    }

    public function update(Products $product)
    {
        $data = request()->validate([
            'product_name' => ['required', 'string'],
            'product_quantity' => ['required'],
            'product_unit_price' => ['required'],
            'category_id' => ['required', 'integer'],
            'subcategory_id' => ['required', 'integer'],
            'measurement_unit' => ['required', 'integer'],

        ]);

        $product->update($data);

        return redirect()->route('product.index')->with('success', $product->product_name.' updated successfully');
    }

    public function delete(Products $product)
    {
        $product->delete();

        return redirect()->back()->with('success', $product->product_name.' deleted successfully');
    }
}
