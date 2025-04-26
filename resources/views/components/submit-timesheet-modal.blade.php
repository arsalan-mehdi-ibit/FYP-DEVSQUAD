

<!-- Submit Timesheet Modal -->
<div class="modal fade" id="submitModal" tabindex="-1" aria-hidden="true" style="backdrop-filter: blur(3px)">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <h2 class="text-lg font-semibold mb-3 text-center">Are you sure you want to submit this timesheet?</h2>
            <form id="submitForm" method="POST">
                @csrf
            <!-- Modal Footer -->
            <div class="flex justify-center space-x-4">
                <button type="button" class="bg-gray-400 text-white px-6 py-2 text-sm rounded-full shadow-md"
                    data-bs-dismiss="modal">No</button>
                <button id="confirm-submit" type="submit" form="submitForm"
                    class="bg-indigo-900 hover:bg-indigo-800 text-white px-6 py-2 text-sm rounded-full shadow-md">Yes</button>
            </div>
               </form>
        </div>
    </div>
</div>