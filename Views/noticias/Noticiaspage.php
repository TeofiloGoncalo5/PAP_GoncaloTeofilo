<?php

include '../partials/header.php';
include '../partials/left.php';
include '../partials/footer.php';

?>

<html>

<head>
    <title>Noticias Page</title>
    <link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="noticias.css">

</head>

<body>
    <div style="padding-left: 100px;">
    <div class="card-posts">
            <div class="card-header">
                <h2>Noticias</h2>
            </div>
            <div class="posts">

            </div>
        </div>
    </div>


</body>


<script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../assets/plugins/jszip/jszip.min.js"></script>
<script src="../../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>



<script src=https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js></script>
<script src=https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js></script>
<script src=https://cdn.datatables.net/colreorder/1.5.5/js/dataTables.colReorder.min.js></script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js></script>


<!-- Page specific script -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>

</html>

<script>
    $.ajax({
        url: '/minha_PAP/api/getnoticias.php',
        type: 'post',
    }).done(res => {
        res = JSON.parse(res);
        $.each(res, (key, value) => {
            $(".posts").append(`
                <div class="post">${value}</div>
            `)
        })
    })
</script>