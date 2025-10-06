<!-- Bootstrap bundle JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="/assets/js/pace.min.js"></script>
<script src="/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/js/table-datatable.js"></script>
<script src="/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>

<script src="/assets/plugins/select2/js/select2.min.js"></script>
<script src="/assets/js/form-select2.js"></script>
<!--app-->
<script src="/assets/js/app.js"></script>
<script src="/assets/js/component-popovers-tooltips.js"></script>

@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fileModal = document.getElementById('fileModal');
        const modalContent = document.getElementById('modalFileContent');

        fileModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const fileUrl = button.getAttribute('data-file-url');
            const extension = fileUrl.split('.').pop().toLowerCase();

            // Reset isi
            modalContent.innerHTML = '<p>Memuat konten...</p>';

            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
                modalContent.innerHTML =
                    `<img src="${fileUrl}" alt="Gambar" class="img-fluid rounded shadow">`;
            } else if (extension === 'pdf') {
                modalContent.innerHTML =
                    `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
            } else {
                modalContent.innerHTML = `<p class="text-danger">Jenis file tidak didukung.</p>`;
            }
        });
    });
</script>
