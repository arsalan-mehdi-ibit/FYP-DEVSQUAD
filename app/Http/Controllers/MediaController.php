<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class MediaController extends Controller
{
    public static function uploadFile($request, $parent_id)
    {
        // dd($request);
        if (!$request->hasFile('attachments')) {
            
             
             //dd("Herk kse");
            return response()->json(['success' => false, 'message' => 'No files uploaded'], 400);
        }
        
        // dd($request->file("attachments"));
        $files = $request->file('attachments');
        // Normalize to an array
        $files = is_array($files) ? $files : [$files];

        $uploadedFiles = [];
        foreach ( $files as $file) {
            // dd($file);
            $fileName = $file->getClientOriginalName();
            $imagePath = 'storage/' . $fileName;
            // $file->storeAs('public', $fileName);
            //dd("Here");
            $fileAttachment = FileAttachment::create([
                'file_size' => $file->getSize(),
                'file_for' => $request->file_for,
                'parent_id' => $parent_id,
                'file_type' => $file->getClientOriginalExtension(),
                'file_path' => $imagePath,
            ]);
            // Generate new filename (file_id + original filename)
            $newFileName = $fileAttachment->id . '_' . $file->getClientOriginalName();

            // Define the storage path
            $imagePath = 'storage/' . $newFileName;

            // Store file in 'public/storage' with the new name
            $filePath = $file->storeAs('public', $newFileName);

            // dd(Storage::disk('public')->exists($filePath));


            // Update the file path in the database
            $fileAttachment->update(['file_path' => $imagePath]);

            $uploadedFiles[] = $imagePath;

        }

        return response()->json(['success' => true, 'files' => $uploadedFiles]);
    }

    public function deleteFile($id)
    {
        $file = FileAttachment::find($id);

        if ($file) {
            // Ensure file is only deleted when the user manually clicks the delete button
            Storage::delete($file->file_path);
            $file->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'File not found']);
    }

    public function downloadFile($id)
{
    $file = FileAttachment::findOrFail($id);

    // Remove 'storage/' prefix to get the actual storage path
    $relativePath = Str::after($file->file_path, 'storage/');

    if (!Storage::disk('public')->exists($relativePath)) {
        abort(404, 'File not found');
    }

    // Get original file name after underscore
    $originalFilename = Str::after($relativePath, '_');

    return Storage::disk('public')->download($relativePath, $originalFilename);
}
}
