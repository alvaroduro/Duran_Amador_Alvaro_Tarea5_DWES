<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class LogController extends Controller
{
    public function index()
    {
        //Traemos todos las logs:
        $logs = Log::orderBy('id', 'desc')->paginate(4);

        //Mostramos vista
        return view('admin.logs.index', compact('logs'));
    }

    public function destroy(Log $log)
    {
        //Elimnar Log
        $log->delete();

        session()->flash('swa1', [
            'icon' => 'success',
            'tittle' => 'Bien hecho!',
            'text' => 'Log: ' . $log->operacion .'del usuario '.$log->usuario. ' eliminada correctamente'
        ]);

        return redirect()->route('admin.logs.index');
    }

    public function exportarPDF()
    {
        $logs = Log::orderBy('id', 'desc')->get();
        $pdf = Pdf::loadView('admin.logs.pdf', compact('logs'));
        return $pdf->download('logs.pdf');
    }
}

