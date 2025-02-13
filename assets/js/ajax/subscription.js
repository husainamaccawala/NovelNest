document.querySelectorAll('#subscribe-btn').forEach(button => {
    button.addEventListener('click', () => {
        const subscriptionType = button.getAttribute('data-tier');
        const userId = document.getElementById('user-id').value;

        fetch('../../controller/subscriptionController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=updateSubscription&user_id=${userId}&subscription_type=${subscriptionType}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
