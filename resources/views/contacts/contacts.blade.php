<style>

    img
    {
        cursor: pointer!important;
    } 

    td {
        background-color: #333 !important;
        text-align: center;
    }

    body {
        background-color: #272727 !important;
    }

    label {
        color: skyblue;
    }

    table {
        border: 2px solid black !important;
        background-color: black !important;
    }

    th {
        background-color: black !important;
        text-align: center !important;
        border-right: 4px solid #333 !important;
    }
</style>
@extends('layout.app')
@section('main')
    <div class=" mt-2 text-center alert alert-info alert-block " style="display: none;" id="output">
    </div>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-sm-8 ">
                <div class="card mt-3 bg-black">
                    <h1 class="text-center"style="color:skyblue; ">Enter Network Details</h1>
                    <form id="form" class="p-3" enctype="multipart/form-data" style="background-color: #333">
                        @csrf
                        <div class="form-control border-0 bg-transparent  row d-flex justify-content-center  ">
                            <label for="">Network Name</label>
                            <input class="form-control w-50 " type="text" id="name" name="name"
                                placeholder="Enter network Name...">

                            <span class="name_err text-danger" id="nameCheck"></span>

                        </div>
                        <div class="form-control border-0 bg-transparent row d-flex justify-content-center">
                            <label for="">Network Code</label>
                            <input class="form-control w-50 " type="text" id="code" name="code"
                                placeholder="Enter network code...">
                            <span id="codeCheck" class="code_err text-danger"></span>
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="form-control border-0 bg-transparent row d-flex justify-content-center">

                            <label for="">Network Image</label>
                            <div id="oldImagePreview"  style="display: none"></div>
                            <label id="newFile" class="mt-3" style="display: none">Choose New File(Not required)</label>
                            <input class="form-control w-50 " type="file" id="image" name="image">
                            <span id="imgCheck" class="image_err text-danger"></span>
                        </div>
                        <div id="imagePreview"  ></div>
                        <input class="btn btn-dark w-50 mt-3" id="submit" type="submit" value="Add Network">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade  bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              
                <div class="modal-body">
                    <img src=""   id="large-image" style="width: 100%; height:100%">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center ">
        <div class="table-responsive-md">
            <table class="table table-dark table-hover mt-3 align-middle" style="background-color: #333;"
                id="networksTable">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#SNo</th>
                        <th scope="col">Network Name</th>
                        <th scope="col">Network Code</th>
                        <th scope="col">Network Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>

    <script>
        function dispRef() {
            $.ajax({
                url: "{{ route('network.display') }}",
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    if (data.networks.length > 0) {
                        $('#networksTable tr').slice(1).remove();
                        data.networks.forEach((element, key) => {

                            $("#networksTable").append(`<tr>
        <td>${key + 1}</td>
        <td>${element['network_name']}</td>
        <td>${element['network_code']}</td>
         }
        <td><img class="table_image" onclick="imgMod(${key})" id=${key}  data-toggle="modal" data-target="#exampleModal" src="contactImage/${element.image}" width="100" height="50"></td>
        <td><button onclick="insertIntoFieldsForEdit('${element['network_name']}','${element['network_code']}','${element['id']}','${element['image']}')" class="btn btn-primary btn-sm mt-2">Edit</button>
        <button data-id="${element['id']}"  class="deleteData btn btn-danger btn-sm mt-2">Delete</button></td>
        </tr>`);

                        });

                    }

                },
                error: function(err) {
                    console.log(err.responseText);

                }
            });

        }

        function imgMod(key) {

            var id = "#";
            var src_value = $(id + key).attr('src');
            $("#large-image").attr('src', src_value);
        }
        function formImage()
        {
            var src_value = $("#formImg").attr('src');
            $("#large-image").attr('src', src_value);
        }
        function oldFormImg()
        {
            var src_value = $("#oldFormImage").attr('src');
            $("#large-image").attr('src', src_value);
        }



        function insertIntoFieldsForEdit(name, code, id, image) {
            $('#name').val(name);
            $('#code').val(code);
            $('#id').val(id);
            $("#submit").attr({
                "value": "Update Network"

            });
            $("#imagePreview").css("display", "none");
            $("#newFile").css("display", "block");
            $("#oldImagePreview").css("display", "block");
            if (image) {
                document.getElementById('oldImagePreview').innerHTML = '<img onclick="oldFormImg()" data-toggle="modal" data-target="#exampleModal" id="oldFormImage" src="contactImage/' + image +
                    '" width="100px" height="100px"/>';
            };

        }

        $(document).ready(function() {
            dispRef();


            $("#name").change(function() {
                validateName();
            });
            $("#code").change(function() {
                validateCode();
            });
            $("#image").change(function() {
                validateImage();

            });



            function validateName() {
                let usernameValue = $("#name").val();
                if (usernameValue.length == "") {
                    return false;
                } else if (usernameValue.length < 4 || usernameValue.length > 8) {

                    $("#nameCheck").html("length of network name must be between 4 and 8");
                    return false;
                } else {
                    $("#nameCheck").html('');
                    return true;
                }
            }

            function validateCode() {

                let codeValue = $("#code").val();

                if (codeValue.length == "") {
                    return false;
                    $("#codeCheck").html("Above Field Is required");
                } else if (codeValue.length < 4 || codeValue.length > 4) {
                    $("#codeCheck").html("length of code must be 4");
                    return false;
                } else {
                    $("#codeCheck").html('');
                    return true;
                }


            }

            function validateImage() {
                var fileInput = document.getElementById('image');
                var submitValue = $("#submit").val();
                var filePath = fileInput.value;

                var allowedExtensions =
                    /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                if (submitValue == "Add Network" && filePath == "") {
                    return false;
                } else if (submitValue == "Add Network" && !allowedExtensions.exec(filePath)) {
                    $("#imgCheck").html("File must be an Image");
                    $("#image").val('');
                    return false;
                } else {
                    $("#imgCheck").html('');

                    if (fileInput.files && fileInput.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById(
                                    'imagePreview').innerHTML =
                                '<img onclick="formImage()" data-toggle="modal" data-target="#exampleModal" id=formImg src=" ' + e.target.result +
                                '" width="100" height="100"/>';
                        };

                        reader.readAsDataURL(fileInput.files[0]);
                    }
                    return true;
                }
            }
            $("#form").submit(function(event) {
                event.preventDefault();
                let valNam = validateName();
                let valCod = validateCode();
                let valImg = validateImage();
                if (valNam == true && valCod == true && valImg == true) {
                    var form = $("#form")[0];
                    var data = new FormData(form);
                    $('#submit').prop("disabled", true);

                    $.ajax({
                        type: "post",
                        url: "{{ route('network.store') }}",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $('.name_err').text('');
                            $('.code_err').text('');
                            $('.image_err').text('');
                            $("#imagePreview").text('');
                            if ($.isEmptyObject(data.error)) {

                                $("#output").css("display", "block");
                                $('#submit').prop("disabled", false);
                                $("#output").text(data.success);
                                $('#name').val('');
                                $("#newFile").css("display", "none");
                                $("#oldImagePreview").css("display", "none");

                                $('#code').val('');
                                $('#image').val('');
                                $('#id').val('');
                                $("#submit").attr({
                                    "value": "Add Network"
                                });
                                dispRef();

                                setTimeout(function() {

                                    $('#output').fadeOut();
                                }, 3000);
                            } else {
                                printErrorMsg(data.error)
                                $('#submit').prop("disabled", false);
                            }

                        }
                    });
                } else {
                    alert('Please fill all fields.');
                }
            });


            function printErrorMsg(msg) {
                $.each(msg, function(key, value) {
                    $('.' + key + '_err').text(value);
                })
            }
            $("#networksTable").on("click", ".deleteData", function() {
                var result = confirm("Do you Really want to delete this network record?");
                if (result == true) {
                    var id = $(this).attr("data-id");
                    $.ajax({
                        url: "delete-data/" + id,
                        type: 'GET',
                        success: function(data) {
                            dispRef();
                            $("#output").css("display", "block");
                            $("#output").text(data.success);
                            setTimeout(function() {
                                $('#output').fadeOut();
                            }, 3000);
                        },
                        error: function(err) {
                            console.log(err.responseText);

                        }
                    });
                }
            });
        });
    </script>
@endsection
