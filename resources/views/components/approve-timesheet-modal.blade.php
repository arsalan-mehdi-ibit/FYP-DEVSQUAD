<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="approveForm">
            @csrf
            <div class="modal-content p-4">
                <h2 class="text-lg font-semibold text-center mb-4">Are you sure you want to approve this timesheet?</h2>
                <div class="flex justify-center space-x-4">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Yes, Approve</button>
                    <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
