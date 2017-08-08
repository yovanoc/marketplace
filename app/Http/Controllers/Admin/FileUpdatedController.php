<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use Mail;
use App\Mail\Files\{FileUpdatedApproved, FileUpdatedRejected};

class FileUpdatedController extends Controller
{
    public function index()
    {
        $files = File::whereHas('approvals')->oldest()->get();

        return view('admin.files.updated.index', [
            'files' => $files
        ]);
    }

    public function update(File $file)
    {
        $file->mergeApprovalProperties();
        $file->approveAllUploads();
        $file->deleteAllApprovals();

        Mail::to($file->user)->send(new FileUpdatedApproved($file));

        return back()->withSuccess("{$file->title} changes have been approved.");
    }

    public function destroy(File $file)
    {
        $file->deleteAllApprovals();
        $file->deleteUnapprovedUploads();

        Mail::to($file->user)->send(new FileUpdatedRejected($file));

        return back()->withSuccess("{$file->title} changes have been rejected.");
    }
}
