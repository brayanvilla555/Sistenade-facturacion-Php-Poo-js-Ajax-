'use strict'
$("#frmAcceso").on('submit',function(e)
{
    e.preventDefault();
    var logina=$("#logina").val();
    var clavea=$("#clavea").val();

    $.post("../ajax/usuario.php?op=verificar",
        {"logina":logina,"clavea":clavea},
        function(data)
    {
        if (data!="null")
        {
            $(location).attr("href","categoria.php");
        }
        else
        {
            swal("error!", "Usuario y/o contraseña incorecta!", "error");
        }
    });
})