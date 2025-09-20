<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $query = Letter::with('category');

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $request->search . '%');
            });
        }

        $letters = $query->orderBy('created_at', 'desc')->paginate(10);
        $letters->appends($request->only('search'));

        return view('letters.index', compact('letters'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('letters.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:letters',
            'category_id' => 'required|exists:categories,id',
            'judul' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($request->judul) . '.pdf';
            $filePath = $file->storeAs('letters', $fileName, 'public');

            Letter::create([
                'nomor_surat' => $request->nomor_surat,
                'category_id' => $request->category_id,
                'judul' => $request->judul,
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName()
            ]);

            return redirect()->route('letters.index')->with('success', 'Data berhasil disimpan');
        }

        return back()->with('error', 'Gagal mengupload file');
    }

    public function show(Letter $letter)
    {
        return view('letters.show', compact('letter'));
    }

    public function edit(Letter $letter)
    {
        $categories = Category::all();
        return view('letters.edit', compact('letter', 'categories'));
    }

    public function update(Request $request, Letter $letter)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:letters,nomor_surat,' . $letter->id,
            'category_id' => 'required|exists:categories,id',
            'judul' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $updateData = [
            'nomor_surat' => $request->nomor_surat,
            'category_id' => $request->category_id,
            'judul' => $request->judul,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($letter->file_path)) {
                Storage::disk('public')->delete($letter->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($request->judul) . '.pdf';
            $filePath = $file->storeAs('letters', $fileName, 'public');

            $updateData['file_path'] = $filePath;
            $updateData['file_name'] = $file->getClientOriginalName();
        }

        $letter->update($updateData);

        return redirect()->route('letters.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Letter $letter)
    {
        if (Storage::disk('public')->exists($letter->file_path)) {
            Storage::disk('public')->delete($letter->file_path);
        }

        $letter->delete();

        return redirect()->route('letters.index')->with('success', 'Data berhasil dihapus');
    }

    public function download(Letter $letter)
    {
        if (Storage::disk('public')->exists($letter->file_path)) {
            return Storage::disk('public')->download($letter->file_path, $letter->file_name);
        }

        return back()->with('error', 'File tidak ditemukan');
    }
}
