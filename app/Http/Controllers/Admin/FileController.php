<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;

class FileController extends Controller
{
    public function show(File $file)
    {
        $file = $this->replaceFilePropertiesWithUnapprovedChanges($file);

        return view('files.show', [
            'file' => $file,
            'uploads' => $file->uploads
        ]);
    }

    protected function replaceFilePropertiesWithUnapprovedChanges(File $file)
    {
        if ($file->approvals()->count()) {
            $file->fill($file->approvals->first()->toArray());
        }

        return $file;
    }
}
