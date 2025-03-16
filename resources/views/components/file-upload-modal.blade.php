<!-- File Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <h2 class="text-lg font-semibold mb-4">Upload File</h2>

            <label class="block text-gray-700 font-medium mb-2">File Name</label>
            <input type="text" id="fileNameInput"
                class="w-full bg-gray-100 px-2 py-1 border rounded-md focus:ring focus:ring-blue-300 mb-2">
            <p id="file-name-error" class="text-red-500 text-sm hidden">Please enter File Name.</p>

            <!-- Uploaded Files Container -->
            <div id="uploaded-files" class="mb-2"></div>

            <!-- File Upload Box -->
            <input type="file" class="hidden" id="file-input" multiple>
            <div id="upload-box"
                class="border-2 border-indigo-900 border-dashed rounded-lg p-5 flex flex-col items-center justify-center text-indigo-900 cursor-pointer hover:bg-gray-100">
                <i class="bi bi-upload text-xl"></i>
                <p class="mt-2 text-sm font-medium">Upload a file</p>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" class="bg-gray-400 text-white px-4 py-2 text-sm rounded-full shadow-md"
                    data-bs-dismiss="modal">Cancel</button>
                <button id="submit-files"
                    class="bg-gradient-to-r from-yellow-400 to-red-400 
      hover:from-yellow-300 hover:to-red-300 text-white px-4 py-2 text-sm rounded-full shadow-md">Submit</button>
            </div>
        </div>
    </div>
</div>