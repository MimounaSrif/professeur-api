<?php
namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::orderByDesc('created_at')->get();
        return response()->json(['publications' => $publications]);
    }

    public function archive($id)
    {
        $publication = Publication::findOrFail($id);
        $publication->archived = true;
        $publication->save();

        return response()->json(['message' => 'Publication archivée avec succès']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }

        $publication = Publication::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $path ? asset('storage/' . $path) : null,
            'archived' => false
        ]);

        return response()->json(['publication' => $publication], 201);
    }

    public function update(Request $request, $id)
    {
        $publication = Publication::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4|max:10240'
        ]);

        if ($request->hasFile('image')) {
            if ($publication->image && strpos($publication->image, 'storage/') !== false) {
                $oldPath = str_replace(asset('storage/'), '', $publication->image);
                Storage::disk('public')->delete($oldPath);
            }

            $newPath = $request->file('image')->store('uploads', 'public');
            $publication->image = asset('storage/' . $newPath);
        }

        $publication->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json([
            'message' => 'Publication mise à jour',
            'publication' => $publication
        ]);
    }

    public function destroy($id)
    {
        $publication = Publication::findOrFail($id);

        if ($publication->image && strpos($publication->image, 'storage/') !== false) {
            $filePath = str_replace(asset('storage/'), '', $publication->image);
            Storage::disk('public')->delete($filePath);
        }

        $publication->delete();

        return response()->json(['message' => 'Publication supprimée']);
    }

    public function public()
    {
        $publications = Publication::where('archived', false)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'publications' => $publications
        ]);
    }
}
