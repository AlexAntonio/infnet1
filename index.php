<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Questão 1 - INFNET</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
</head>
<body>

<?php
    $url='https://dadosabertos.camara.leg.br/api/v2/partidos';
    $result= json_decode(file_get_contents($url));

    $partidos= $result->dados;

    ?>

    <div class="container">
        <div class="row text-center justify-content-center">
            <div class="col">
                <div class="card text-center">
                    <div class="card-header">
                        Partidos Políticos
                    </div>
                    <div class="card-body">
                        <p class="card-text">Selecione um partido para visualizar a lista de parlamentares:</p>
                        <select id="partido" name="partido">
                            <option value="">Selecione um partido</option>
                            <?php foreach($partidos as $partido){ ?>
                                <option value="<?=$partido->id?>"><?=$partido->nome?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div id="info" class="row pt-3">
            <div class="col">
                <h4 class="text-center">Lista de parlamentares</h4>
                <hr />
                <div id="tabela"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $("#info").hide();

            function getList(idPartido){
                var url="https://dadosabertos.camara.leg.br/api/v2/partidos/"+idPartido+"/membros";
                var Httpreq = new XMLHttpRequest(); // a new request
                Httpreq.open("GET",url,false);
                Httpreq.send(null);
                return Httpreq.responseText;
            }

            $( "#partido" ).change(function() {

                var idPartido= document.getElementById("partido").value;

                if(idPartido==''){
                    $("#info").hide();
                }else{
                    var result= getList(idPartido);
                    var lista= JSON.parse(result);

                    var text = "<table class='table table-striped'>";
                    text += "<thead><th>ID</th><th>Nome</th><th>E-mail<th>Sigla do Partido</th>";
                    text += "<th>Sigla UF</th><th>Foto</th></thead>";
                    text += "<tbody>";

                    for (var i = 0; i < lista.dados.length; i++) {
                        text += "<tr>";
                        text += "<td>" + lista.dados[i].id + "</td>";
                        text += "<td>" + lista.dados[i].nome + "</td>";
                        text += "<td>" + lista.dados[i].email + "</td>";
                        text += "<td>" + lista.dados[i].siglaPartido + "</td>";
                        text += "<td>" + lista.dados[i].siglaUf + "</td>";
                        text += "<td><img src='"+ lista.dados[i].urlFoto +"' class='img-fluid' style='width:120px;'/></td>";
                        text += "</tr>";

                    }
                    text += "</tbody>";
                    text += "</table>";


                    $("#info").show();
                    document.getElementById("tabela").innerHTML = text;
                }

            });
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>