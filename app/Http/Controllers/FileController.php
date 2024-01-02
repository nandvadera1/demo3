<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FileController extends Controller
{
    public function index()
    {
        $heads = [
            'File Name',
            ['label' => 'Download', 'no-export' => true, 'width' => 5],
            ['label' => 'Delete', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'processing' => true,
            'serverSide' => true,
            'ajax' => url('admin/files/dataTable'),
            'columns' => [
                ['data' => 'file_name', 'name' => 'file_name'],
                ['data' => 'download', 'name' => 'download', 'orderable' => false, 'searchable' => false],
                ['data' => 'delete', 'name' => 'delete', 'orderable' => false, 'searchable' => false],
            ]
        ];
        return view('files.index', compact('heads', 'config'));
    }

    public function create()
    {
        return view('files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string|unique:files',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = $request->file_name . '_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path(). '/files';

        $file->move($destinationPath, $fileName);

        File::create([
            'file_name' => $request->file_name,
            'file' => $fileName,
        ]);

        return redirect('/admin/files')->with('Success', 'File added successfully.');
    }

    public function dataTable()
    {
        $files = File::select('id', 'file_name')->get();

        return DataTables::of($files)
            ->addColumn('download', function ($user) {
                $btn = '<a href="/admin/files/download/' . $user->id . '" class="btn btn-primary btn-sm">Download</a>';
                return $btn;
            })
            ->addColumn('delete', function ($file) {
                $btn = '<button class="btn btn-danger btn-sm btn_delete " data-id="' . $file->id . '">Delete</button>';
                return $btn;
            })
            ->rawColumns(['download','delete'])
            ->make(true);
    }

    public function download($fileId)
    {
        $file = File::findOrFail($fileId);

        $path = public_path('files/' . $file->file);

        return response()->download($path);
    }

}
