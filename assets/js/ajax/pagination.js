function loadData(table, page = 1, limit = 10, renderCallback) {
    $.ajax({
        url: "/NovelNest/config/pagination.php",
        type: "GET",
        data: { table: table, page: page, limit: limit },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                let data = response.data;
                let totalRecords = response.totalRecords;
                let currentPage = response.currentPage;
                let perPage = limit;

                if (typeof renderCallback === "function") {
                    renderCallback(data);
                }

                updatePagination(table, currentPage, totalRecords, perPage);
            } else {
                console.error("Error fetching data:", response);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
}

function updatePagination(table, currentPage, totalRecords, perPage) {
    let totalPages = Math.ceil(totalRecords / perPage);
    let paginationHTML = "";

    if (totalPages > 1) {
        paginationHTML += `<nav>
            <ul class="pagination justify-content-center">`;

        // Previous button
        paginationHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage - 1}" data-table="${table}">Previous</a>
        </li>`;

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}" data-table="${table}">${i}</a>
            </li>`;
        }

        // Next button
        paginationHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage + 1}" data-table="${table}">Next</a>
        </li>`;

        paginationHTML += `</ul></nav>`;
    }

    $(`#${table}-pagination`).html(paginationHTML);
}

// Handle pagination click event
$(document).on("click", ".page-link", function (e) {
    e.preventDefault();
    let page = $(this).data("page");
    let table = $(this).data("table");

    if (page) {
        loadData(table, page, 10, window[`render${table}Table`]);
    }
});
