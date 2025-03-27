$(document).ready(function () {
    function loadSubscriptions() {
        $.ajax({
            url: "/NovelNest/controller/subscriptionController.php",
            type: "POST",
            data: { action: "fetchSubscriptions" }, // AJAX action for controller
            dataType: "json",
            success: function (response) {
                console.log("Subscriptions data:", response); // Debug
                $("#subscriptionTableBody").empty(); // Clear existing data
                if (response.length > 0) {
                    $.each(response, function (index, subscription) {
                        $("#subscriptionTableBody").append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${subscription.user_name}</td>
                                <td>${subscription.email}</td>
                                <td>${subscription.subscription_type}</td>
                                <td>${subscription.start_date}</td>
                                <td>${subscription.end_date}</td>
                                <td>${subscription.subscription_status}</td>
                                <td>${subscription.plan_name}</td>
                                <td>₹${subscription.plan_price}</td>
                                <td>
                                    <a href="${subscription.invoice_url}" target="_blank">📄</a>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    $("#subscriptionTableBody").html("<tr><td colspan='10'>No subscriptions found.</td></tr>");
                }
            },
            error: function () {
                alert("Error loading subscriptions.");
            }
        });
    }

    loadSubscriptions(); // Load subscriptions on page load
    setInterval(loadSubscriptions, 10000); // Refresh every 10 seconds
});
