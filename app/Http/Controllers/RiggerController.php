<?php

namespace App\Http\Controllers;

use App\Models\Rigger;
use App\Models\RiggerDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RiggerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $riggers = Rigger::all();
        if (request()->ajax()) {
            return datatables($riggers)
            ->editColumn('option', 'riggers.partials.action')
            ->rawColumns(['option'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('riggers.index', ['riggers'=>$riggers]);
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
        $data = request()->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', 'unique:riggers'],
            'nid' => ['required', 'unique:riggers'],
        ]);

        Rigger::create($data);

        return redirect()->back()->with('success', 'Rigger created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rigger  $rigger
     * @return \Illuminate\Http\Response
     */
    public function show(Rigger $rigger)
    {
        return view('riggers.profile', ['rigger'=>$rigger, 'documents'=>RiggerDocument::where('rigger_id', $rigger->id)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rigger  $rigger
     * @return \Illuminate\Http\Response
     */
    public function edit(Rigger $rigger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rigger  $rigger
     * @return \Illuminate\Http\Response
     */
    public function update(Rigger $rigger)
    {
        $data = request()->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', Rule::unique('riggers')->ignore($rigger->id)],
            'nid' => ['required', Rule::unique('riggers')->ignore($rigger->id)],
        ]);

        $rigger->update($data);

        return redirect()->back()->with('success', 'Rigger updated');
    }

    public function upload(Rigger $rigger)
    {
        $data = request()->validate([
            'document_type' => ['required', 'string'],
            'document' => ['required', 'file', 'max:10000'],
            'expiry_date' =>['nullable'],
            'issued_date' => ['nullable'],
        ]);
        $file = request()->file('document');
        $data['document'] = uniqid().'_'.trim($file->getClientOriginalName());
        $file->storeAs('riggers/'.$rigger->name, $data['document'], 'public');
        $data['rigger_id'] = $rigger->id;
        RiggerDocument::create($data);

        return redirect()->back()->with('success', 'Document uploaded');
    }

    public function updateDoc(RiggerDocument $document)
    {
        $data = request()->validate([
            'document_type' => ['required', 'string'],
            'expiry_date' =>['nullable'],
            'issued_date' => ['nullable'],
        ]);
        $file = request()->file('document');
        if (! is_null($file)) {
            $rigger = Rigger::where('id', $document->rigger_id)->first();
            Storage::delete('riggers/'.$rigger->name.'/'.$document->document);
            $data['document'] = uniqid().'_'.trim($file->getClientOriginalName());
            $file->storeAs('riggers/'.$rigger->name, $data['document'], 'public');
        }

        $document->update($data);

        return redirect()->back()->with('success', 'Document updated');
    }

    public function download()
    {
        $items = Rigger::all();

        $pdf = Pdf::loadView('riggers.download_riggers', [
            'items' => $items,
        ]);

        return $pdf->download('Riggers_List.pdf');
        // return view('riggers.download_riggers', [
        //     'items' => $items,
        // ]);
    }

    public function removeDocument(Rigger $rigger, RiggerDocument $document)
    {
        Storage::delete('riggers/'.$rigger->name.'/'.$document->document);
        $document->delete();

        return redirect()->back()->with('success', 'Document removed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rigger  $rigger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rigger $rigger)
    {
        $rigger->delete();

        return redirect()->back()->with('success', 'Rigger deleted');
    }
}
