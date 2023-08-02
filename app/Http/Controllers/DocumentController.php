<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables($documents)
            ->editColumn('name', function ($document) {
                if ($document->file_type == 'pdf') {
                    return '<div class="flex"><img class="rounded-0" src="'.asset('images/file-icons/file/pdf.svg').'"/> <label class="pl-2" style="font-size:0.875rem">'.$document->name.'</label></div>';
                } elseif ($document->file_type == 'doc' || $document->file_type == 'docx') {
                    return '<div class="flex"><img class="rounded-0" src="'.asset('images/file-icons/file/word.svg').'"/> <label class="pl-2" style="font-size:0.875rem">'.$document->name.'</label></div>';
                } elseif ($document->file_type == 'xls' || $document->file_type == 'csv' || $document->file_type == 'xlsx') {
                    return '<div class="flex"><img class="rounded-0" src="'.asset('images/file-icons/file/excel.svg').'"/> <label class="pl-2" style="font-size:0.875rem">'.$document->name.'</label></div>';
                } else {
                    return '<div class="flex"><img class="rounded-0" src="'.asset('images/file-icons/file/file.svg').'"/> <label class="pl-2" style="font-size:0.875rem">'.$document->name.'</label></div>';
                }
            })
            ->editColumn('created_at', function ($document) {
                return $document->created_at->format('d/m/Y');
            })
            ->editColumn('updated_at', function ($document) {
                return $document->updated_at->format('d/m/Y');
            })
            ->editColumn('option', 'documents.partials.action')
            ->rawColumns(['name', 'created_at', 'created_at', 'option'])
            ->make(true);
        }

        return view('documents.index', ['documents' => $documents]);
    }

    public function store()
    {
        $data = request()->validate([
            'name' => ['required', 'string'],
        ]);
        $file = request()->file('document');
        if (! $file) {
            return redirect()->back()->with('error', 'Please add a file to upload');
        }
        $data['file_type'] = $file->extension();
        $data['file_size'] = round($file->getSize() / 1024).' KB';
        $file->storeAs('documents/', $data['name'].'.'.$data['file_type'], 'public');

        Document::create($data);

        return redirect()->back()->with('success', 'Document uploaded');
    }

    public function update(Document $document)
    {
        $data = request()->validate([
            'name' => ['required', 'string'],
        ]);
        $file = request()->file('document');
        if ($file) {
            $data['file_type'] = $file->extension();
            $data['file_size'] = round($file->getSize() / 1024).' KB';
            $file->storeAs('documents/', $data['name'].'.'.$data['file_type'], 'public');
        } else {
            Storage::move('public/documents/'.$document->name.'.'.$document->file_type, 'public/documents/'.$data['name'].'.'.$document->file_type);
        }

        $document->update($data);

        return redirect()->back()->with('success', 'Document updated');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->back()->with('success', 'File deleted');
    }
}
