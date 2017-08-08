<?php

namespace App\Http\Controllers\Files;

use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{File, Sale};

class FileDownloadController extends Controller
{
    protected $zipper;

    public function __construct(Zipper $zipper)
    {
        $this->zipper = $zipper;
    }

    public function show(File $file, Sale $sale)
    {
        if (!$file->visible()) {
            return abort(403);
        }

        if (!$file->matchesSale($sale)) {
            return abort(403);
        }

        $path = $this->generateTemporaryPath($file);

        $this->createZipForFileInPath($file, $path);

        return response()
                ->download($path)
                ->deleteFileAfterSend(true);
    }

    protected function createZipForFileInPath(File $file, $path)
    {
        $this->zipper->make($path)->add($file->getUploadsList())->close();
    }

    protected function generateTemporaryPath(File $file)
    {
        return public_path('tmp/' . str_slug($file->title) . '.zip');
    }
}
