$(document).ready(function() {
    let table = $('#datatable').DataTable({
        pagingType: "full_numbers",
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "",
            searchPlaceholder: "Search here...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                previous: "‹",
                next: "›",
                first: "<<",
                last: ">>"
            }
        }
    });

    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('#entriesSelect').on('change', function() {
        table.page.len($(this).val()).draw();
    });
});
