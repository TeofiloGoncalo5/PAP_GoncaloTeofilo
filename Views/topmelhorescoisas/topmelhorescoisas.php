<?php

include '../partials/header.php';
include '../partials/left.php';
include '../partials/footer.php';

?>

<html>

<div style="padding: 100px 100px;">

    <head>
        <title>User Posts</title>
        <!-- Link the CSS file for styling -->
        <link rel="stylesheet" href="../../assets/plugins/font-awesome-pro-v6-6.2.0/css/all.min.css">
        <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="topsytle.css">
    </head>

    <body>
        <input type="hidden" id="isAdmin" value="<?php echo $_SESSION["isAdmin"] ?>">
        <!-- Button to trigger the post creation menu -->
        <button id="createPostButton" class="create-post">Create Post</button>

        <!-- Post creation menu -->
        <div id="postCreationMenu" style="display: none;">
            <!-- Add form elements to allow users to add video/image and caption -->
            <textarea id="default-editor">

            </textarea>
            <button class="btn btn-dark form-control" id="publicar">Publicar</button>
        </div>

        <!-- Card to display user posts -->
        <div class="card-posts">
            <div class="card-header">
                <h2>User Posts</h2>
            </div>
            <div class="posts">

            </div>
        </div>
        <br></br>

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.tiny.cloud/1/qjwjpa3vz2r9isfalswr4n2kk3q0iytcn1k5hwaui4kuor3w/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="../../assets/plugins/font-awesome-pro-v6-6.2.0/js/pro.min.js"></script>

</body>


<script>
    tinymce.init({
        selector: 'textarea#default-editor',
        plugins: "link",
        menubar: "insert",
        toolbar: "undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link"
    });
    // Rest of your existing JavaScript code here
    function togglePostCreationMenu() {
        const postCreationMenu = document.getElementById("postCreationMenu");
        postCreationMenu.style.display =
            postCreationMenu.style.display === "none" ? "block" : "none";
    }

    // Event listener for the "Create Post" button
    document.getElementById("createPostButton").addEventListener("click", togglePostCreationMenu);

    $("#publicar").on("click", () => {
        $.ajax({
            url: '../../api/topcoisasapi.php',
            type: 'post',
            data: {
                'text': tinymce.get("default-editor").getContent(),
            }
        }).done(res => {
            window.location.reload();

        })
    })

    $.ajax({
        url: '../../api/fetch_user_posts.php',
        type: 'post',
    }).done(res => {
        res = JSON.parse(res);
        $.each(res, (key, value) => {
            var Admin = $("#isAdmin").val();
            console.log(Admin);
            var apagar = Admin ? `<div><i class="fa-regular fa-trash-xmark delete-icon" style="color: #ec3022;" onclick="deletePostAndComments(${value["id"]})"></i></div>` : "";
            $(".posts").on("click", ".fa-trash-xmark", function() {
                var postId = $(this).closest(".post").data("post-id");
                deletePostAndComments(postId);
            });
            $(".posts").append(`
            <div class="post d-flex justify-content-center mb-3" data-post-id="${value["id"]}">
                    ${apagar}
                    <div class="card-design">${value["post"]}</div>
                </div>
                <div class="d-flex justify-content-between">
                <i class="fa-solid fa-comment-captions comment-icon" onclick="getcomment(${value["id"]})"></i>
                <input class="form-control mb-3 me-3 comment-input" id="c${value["id"]}"></input>
                <button class="btn btn-dark ms-3 comment-post" onclick="acentcomment(${value["id"]})">Post</button>
                </div>
                <div class="comments${value["id"]}"></div>
            `)
        })
    })

    function acentcomment(id_post){
        console.log(id_post);
        var text = $("#c" + id_post).val();
        $.ajax({
        url: '../../api/guardarcommentsapi.php',
        type: 'post',
        data: {
            'id': id_post,
            'text': text
        }
    })
    }

    function getcomment(idpost){
        if($(".comments" + idpost).hasClass("showing")){
            $(".comments" + idpost + " div").remove()
            $(".comments" + idpost).removeClass("showing")
            return;
        }
        $.ajax({
        url: '../../api/getcommentsapi.php',
        type: 'post',
        data: {
            'idpost': idpost,
        }
    }).done(res => {
        res = JSON.parse(res);
        $.each(res, (key, value) => {
            $(".comments" + idpost).append(`
                <div class="post  mb-3">
                    <h4>${value.nomedouser}: </h4>
                    <div class="d-flex justify-content-center">
                    <div>${value.comment}</div>
                    </div>
                </div>
            `)
        })
        $(".comments" + idpost).addClass("showing")
    })
    }

    function deletePostAndComments(idpost) {
            $.ajax({
                type: "POST",
                url: "../../api/deletepostapi.php",
                data: { 
                    post_id: idpost
                 },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $("#responseMessage").text(response.message);
                        window.location.reload();
                    } else {
                        $("#responseMessage").text("Error: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                }
            });
        }
</script>

</html>