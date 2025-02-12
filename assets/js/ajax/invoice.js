$(document).ready(function() {
    $('#user-table').DataTable({
        responsive: true, // Enables responsiveness
        autoWidth: false  // Prevents column width issues
    });

    // Update invoice status via AJAX
    $('.update-status').click(function() {
        var invoiceId = $(this).data('invoice-id');
        var newStatus = $(this).data('status');

        $.ajax({
            url: 'controller/invoiceController.php?action=updateInvoiceStatus',
            method: 'POST',
            data: {invoice_id: invoiceId, status: newStatus},
            success: function(response) {
                alert('Invoice status updated!');
                location.reload();  // Reload the page to reflect changes
            },
            error: function() {
                alert('Error updating invoice status');
            }
        });
    });
});
