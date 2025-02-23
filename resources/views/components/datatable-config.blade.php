<script>
const defaultDataTableConfig = {
    pageLength: 20,
    lengthChange: false,
    searching: true,
    ordering: true,
    info: true,
    paging: true,
    language: {
        search: "",
        searchPlaceholder: "Search...",
        info: "Showing _START_ to _END_ of _TOTAL_"
    },
    dom: '<"flex flex-col sm:flex-row items-center justify-between gap-3 mb-5"<"flex-1"f>>rt<"flex flex-col sm:flex-row items-center justify-between gap-3 mt-5"<"text-sm text-gray-700"i><"flex items-center gap-2"p>>',
    initComplete: function() {
        $('.dataTables_filter input').addClass('border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent');
    }
};
</script>
