<?php

namespace App\Http\Controllers\Files;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;

class FileController extends Controller
{
    public function show(File $file)
    {
        if (!$file->visible()) {
            return abort(404);
        }

        $uploads = $file->uploads()->approved()->get();

        return view('files.show', [
            'file' => $file,
            'uploads' => $uploads
        ]);
    }
}
