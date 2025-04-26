<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="rejectForm">
            @csrf
            <div class="modal-content p-4">
                <h2 class="text-lg font-semibold text-center mb-4">Please provide a reason for rejection</h2>

                <div class="mb-4">
                    <textarea name="rejection_reason" class="w-full p-2 border rounded" rows="3" placeholder="Enter reason..." required></textarea>
                </div>

                <div class="flex justify-center space-x-4">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Reject Timesheet</button>
                    <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
