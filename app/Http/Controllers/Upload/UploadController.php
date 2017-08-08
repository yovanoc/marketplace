<?php

namespace App\Http\Controllers\Upload;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Upload;
use App\File;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(File $file, Request $request)
    {
        $this->authorize('touch', $file);

        $uploadedFile = $request->file('file');

        $upload = $this->storeUpload($file, $uploadedFile);

        Storage::disk('local')->putFileAs(
            'files/' . $file->identifier,
            $uploadedFile,
            $upload->filename
        );

        return response()->json([
            'id' => $upload->id
        ], 200);
    }

    protected function storeUpload(File $file, UploadedFile $uploadedFile)
    {
        $upload = new Upload;

        $upload->fill([
            'filename' => $this->generateFilename($uploadedFile),
            'size' => $uploadedFile->getSize()
        ]);

        $upload->file()->associate($file);
        $upload->user()->associate(auth()->user());

        $upload->save();

        return $upload;
    }

    protected function generateFilename(UploadedFile $uploadedFile)
    {
        return $uploadedFile->getClientOriginalName();
    }

    public function destroy(File $file, Upload $upload)
    {
        $this->authorize('touch', $file);
        $this->authorize('touch', $upload);

        if ($file->uploads->count() === 1) {
            return response()->json(null, 422);
        }

        $upload->delete();
    }
}
