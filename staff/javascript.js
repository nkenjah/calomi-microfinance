document.getElementById('searchClient').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#clientTable tbody tr');

    rows.forEach(row => {
        const name = row.cells[0].textContent.toLowerCase();
        const phone = row.cells[1].textContent.toLowerCase();
        const address = row.cells[2].textContent.toLowerCase();

        if (name.includes(searchTerm) || phone.includes(searchTerm) || address.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
