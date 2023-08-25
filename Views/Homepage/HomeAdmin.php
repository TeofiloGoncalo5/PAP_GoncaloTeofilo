<?php
include '../partials/header.php';
include '../partials/left.php';
include '../partials/footer.php';
include '../../api/get_user_data.php';

// Assuming you have a function to fetch user records from the database
$users = getUsers(); // Replace with your own code to fetch users

?>

<html>

<head>
    <title>AdminHomePage</title>
    <link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="global.css">
</head>

<body>

    <div style="padding: 100px 100px">

        <h1>Admin Home Page</h1>

        <table id="user-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <input type="checkbox" id="c<?php echo $user['id']; ?>" onchange="checkAdmin('c<?php echo $user['id']; ?>', <?php echo $user['id']; ?>)" value="<?php echo $user['id']; ?>" class="admin-checkbox" <?php echo $user['isAdmin'] ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Include necessary JS files -->
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
    <script src="../../assets/plugins/toastr/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#user-table').DataTable();

        });

        function checkAdmin(id, userid) {
           var icheck = $("#" + id).is(":checked") ? "1":"0";
           $.ajax({
                url: '/minha_PAP/api/update_admin_status.php',
                type: 'post',
                data: {
                    'status': icheck,
                    'userid': userid,
                }
            }).done(res => {
                if(res) toastr['success']('alterado com sucesso');
            })
        }
    </script>
</body>

</html>