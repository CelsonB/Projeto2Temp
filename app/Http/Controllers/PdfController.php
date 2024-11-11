<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdfController extends Controller
{

    public function index()
{
    // Obtém todos os PDFs do diretório 'pdfs'
    $pdfs = Storage::files('pdfs');

    return view('dashboard', compact('pdfs'));
}

    public function uploadPDF(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:2048', // Validação para garantir que o arquivo é um PDF e tem no máximo 2MB
        ]);

        // Salva o arquivo PDF no diretório 'pdfs'
        $path = $request->file('pdf')->store('pdfs');

        // Você pode armazenar o caminho no banco de dados ou fazer algo com ele
        // Exemplo: PDF::create(['path' => $path]);

        return redirect()->back()->with('success', 'PDF enviado com sucesso!');
    }

    public function show($filename)
    {
        // Verifica se o arquivo existe
        if (!Storage::disk('private')->exists("pdfs/{$filename}")) {
            abort(404); // Retorna 404 se o arquivo não for encontrado
        }

        // Retorna o PDF para visualização
        return response()->file(storage_path("app/private/pdfs/{$filename}"));
    }

    // Método para baixar o PDF
    public function download($filename)
    {
        // Verifica se o arquivo existe
        if (!Storage::disk('private')->exists("pdfs/{$filename}")) {
            abort(404); // Retorna 404 se o arquivo não for encontrado
        }

        // Retorna o PDF para download
        return response()->download(storage_path("app/private/pdfs/{$filename}"));
    }
}
