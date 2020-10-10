<!DOCTYPE html>
<html>

<head>
    <title>Upload Image in Laravel using Ajax</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</head>
<style>
    .gambar,
    .alert {
        text-align: center;
    }
</style>

<body>
    <br />
    <div class="container">
        <h3 align="center">Upload Image in Laravel using Ajax</h3>
        <br />
        <div class="alert" id="message" style="display: none"></div>
        <form method="post" id="upload_form" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <table class="table">
                    <input type='hidden' name='doc_id' id='doc_id' value="{{$id}}">
                    <div class="col-sm-12 gambar">
                        <img src="storage/images/default.jpg" class="img-tumbnail img-preview" width="200px">
                    </div>
                    <br>
                    <tr>
                        <td width="40%" align="right"><label>Select File for Upload</label></td>
                        <td width="30"><input type="file" name="image" id="image" class="custom-file-input" onchange="preview()" /></td>
                        <td width="30%" align="left"><input type="submit" name="upload" id="upload" class="btn btn-primary" value="Upload"></td>
                    </tr>
                    <tr>
                        <td width="40%" align="right"></td>
                        <td width="30"><span class="text-muted">jpg, png, gif</span></td>
                        <td width="30%" align="left"></td>
                    </tr>
                </table>
            </div>
        </form>
        <br />

    </div>
</body>

</html>

<script>
    $(document).ready(function() {

        $('#upload_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('uploaded') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#message').css('display', 'block');
                    $('#message').html(data.message);
                    $('#message').addClass(data.class_name);
                    $('.custom-file-input').val('');
                    $('.img-preview').attr('src', 'storage/images/default.jpg');
                }
            })
        });

        // $.

    });
</script>