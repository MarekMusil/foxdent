<?php
namespace App\Controllers\LogViewer;
use CodeIgniter\Controller;
use CILogViewer\CILogViewer;

class LogViewerController extends Controller
{
    public function log()
    {
        $logViewer = new CILogViewer();
        return $logViewer->showLogs();
    }
}