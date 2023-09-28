<?php

!defined("giriskontrol") ? die(header("location:index.php")) : null;

?>
<div class="py-6 px-6 text-center">
    <p class="mb-0 fs-4">© 2023 Telif Hakları: Semih Öksüz | Web Yazılım Hizmetleri</p>
</div>
</div>
</div>
</div>



<script src="../src/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../src/assets/js/sidebarmenu.js"></script>
<script src="../src/assets/js/app.min.js"></script>
<script src="../src/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="../src/assets/libs/simplebar/dist/simplebar.js"></script>
<script src="../src/assets/js/dashboard.js"></script>
<!-- datatable -->
<script src="../src/assets/libs/jquery/dist/jquery.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script type="text/javascript" src="../src/assets/libs/DataTables/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tablo').DataTable();
    });
</script>
</body>

</html>

<?php $db = null; ?>