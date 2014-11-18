function afficher(id)
{
    if (id != '')
    {
        var image="<center><img src='/pointcom/img/loading.gif' style='width: 180px;' ></center>";
        $("#info").empty();
        $(image).appendTo("#info");
        $("#info").show();
        $.post(
            '/pointcom/questions/avencer/' + id,
            {
                //id: $("#ChembreBlocId").val()
            },
            function(data)
            {
                $("#info").empty();
                //$(data).appendTo("#info");
                $("#info").html(data).text();
                $("#info").show();
            },
            'text' // type
            );
    }
}