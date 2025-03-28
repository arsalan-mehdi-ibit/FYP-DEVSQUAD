<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileAttachment;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function uploadFile(Request $request)
    {
        if (!$request->hasFile('files')) {
            return response()->json(['success' => false, 'message' => 'No files uploaded'], 400);
        }

        $uploadedFiles = [];
        foreach ($request->file('files') as $file) {
            $path = $file->storeAs('public', 'test');

            $fileAttachment = FileAttachment::create([
                'file_size' => $file->getSize(),
                'file_for' => 'users',
                'parent_id' => null,
                'file_type' => $file->getClientOriginalExtension(),
                'file_path' => $path,
            ]);

            // $uploadedFiles[] = [
            //     'id' => $fileAttachment->id,
            //     'original_name' => $file->getClientOriginalName(),
            //     'path' => asset("storage/$path"),
            // ];
        }

        return response()->json(['success' => true, 'files' => $uploadedFiles]);
    }

    public function deleteFile($id)
    {
        $file = FileAttachment::find($id);
        if (!$file) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return response()->json(['success' => true, 'message' => 'File deleted successfully']);
    }
}
