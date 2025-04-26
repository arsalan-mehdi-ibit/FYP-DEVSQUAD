<!-- Submitted Success Modal -->
<div class="modal fade" id="submittedSuccessModal" tabindex="-1" aria-hidden="true" style="backdrop-filter: blur(3px)">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom"> <!-- Added class here -->
        <div class="modal-content p-4 flex flex-col items-center">
            <div class="text-green-500 text-5xl mb-2">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h2 class="text-lg font-semibold text-center mb-3">Your timesheet has been submitted</h2>

            <button type="button"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 text-sm rounded-full shadow-md"
                data-bs-dismiss="modal">OK</button>
        </div>
    </div>
</div>
<style>
    .modal-dialog-zoom {
        transform: scale(0.7);
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog-zoom {
        transform: scale(1);
    }
</style>
