<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload de archivos con Ajax</title>
</head>
<body>
    
    <form enctype="multipart/form-data" id="formuploadajax" method="post">
       
        <br />
        <input  type="file" id="archivo" name="archivo"/>
        <input type="submit" value="Subir archivos"/>
    </form>
    <div id="mensaje"></div>
    
    
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>
    $(function(){
        $("#formuploadajax").on("submit", function(e){
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("formuploadajax"));
        
            $.ajax({
                url: "http://localhost/api_firma/public/getFirma",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                    console.log(res);
                   
                    var respuesta= JSON.parse(res);
                    console.log(respuesta.url);
                    console.log(respuesta.filename);
                    window.location=respuesta.url;
                });
        });
    });
    </script>
</body>
</html>