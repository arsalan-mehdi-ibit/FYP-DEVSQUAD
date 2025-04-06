<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileAttachment;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public static function uploadFile($request, $parent_id)
    {
        // dd($request);
        if (!$request->hasFile('attachments')) {
            // dd("Herk kse");
            return response()->json(['success' => false, 'message' => 'No files uploaded'], 400);
        }

        // dd("Here");
        $uploadedFiles = [];
        foreach ($request->file('attachments') as $file) {
            $fileName = $file->getClientOriginalName();
            $imagePath = 'storage/' . $fileName;
            // $file->storeAs('public', $fileName);
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
        // Find the file to delete by ID
        $file = FileAttachment::find($id);

        if ($file) {
            // Delete the file from storage
            Storage::delete($file->file_path);

            // Delete the file entry from the database
            $file->delete();

            return redirect()->back()->with('success', 'File deleted successfully');
        }

        return redirect()->back()->with('error', 'File not found');
    }

}
