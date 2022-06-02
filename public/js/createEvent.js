//Fonction qui retourne l'element 'select' concernant le type de la collecte
function typeCollecteSelect(){
    let html = "";
        html += "<label for='typeCollecte_id'>Type collecte</label>";
        html += "<select name='typeCollecte' id='typeCollecte_id' class='form-control'>";
        html += "<option value='f'>Fixe</option>";
        html += "<option value='m'>Mobile</option><br>";
        html += "</select><br>";
    return html;
}

//Fonction qui retourne le formulaire d'ajout d'une collecte:
function creerCollecteForm(typeCollecte){
    if(typeCollecte === "f"){
        let fixe = "" +
            "<input type='hidden' value='f' name='typeCollecte'>" +
            "<label for='libCollecte'>Libellé collecte</label><input class='form-control' type='text' id='libCollecte'  name='libCollecte'><br>" +
            "   <label for='centre'>Centre</label>";
        $.ajax({
            type: "get",
            url: "/getAllCenters",
            success: function (data) {
                let centres = JSON.parse(data);
                fixe += '<select name="centre" class="form-control">';
                for(let i = 0 ; i < centres.length ; i++){
                    fixe += "<option value='"+centres[i]["id"]+"'>"+centres[i]["libCentre"]+"</option>";
                }
                fixe += "</select><br>";
                let divFormCollecte = document.getElementById("formCollecte");
                formCollecte.className = "alert alert-info";
                divFormCollecte.innerHTML = fixe;
            },
            error: function () {
                alert("error");
            }
        });
    }else{
        let innerHTML = "<input type='hidden' value='m' name='typeCollecte'>" +
            "<label for=\"libCollecte\">Libellé collecte</label><input class='form-control' type=\"text\" id=\"libCollecte\"  name=\"libCollecte\"><br>" +
            "                        <label for='lieuCollecte'>Lieu</label><input type='text' class='form-control' id='lieuCollecte' name='lieuCollecte'><br>" +
            "                        <label for='ville'>Ville</label>" +
            "                        <select id=\"ville\" class=\"form-control\" name='ville'>";
            $.ajax({
                type : 'get',
                url : "/getAllCities",
                success:function(data){
                    let cities = JSON.parse(data);
                    for(let i = 0 ; i < cities.length; i++){
                        innerHTML += "<option value='"+cities[i]["id"]+"'>"+cities[i]["libVille"]+"</option>";
                    }
                    innerHTML += "                        </select><br><label for='zone'>Zone</label>";
                    innerHTML += "<div id='divZone' class='divZone'></div>";
                    formCollecte.innerHTML = innerHTML;
                    formCollecte.className = "alert alert-info";
                    $("#ville").ready(function(){
                        $.ajax({
                            type: "get",
                            url: "/getZones/"+$("#ville").val(),
                            success:function(data){
                                let zones = JSON.parse(data);
                                let innerHTML = "<select name='zone' id='zone' class='form-control'>";
                                for(let i = 0 ; i < zones.length ; i++){
                                    innerHTML += "<option value='"+zones[i]["id"]+"'>"+zones[i]["libZone"]+"</option>";
                                }
                                innerHTML += "</select>";
                                divZone.innerHTML = innerHTML;
                            },
                            error:function(){
                                console.log("error");
                            }
                        })
                    });
                    $("#ville").on("change", function(){
                        $.ajax({
                            type: "get",
                            url: "/getZones/"+$("#ville").val(),
                            success:function(data){
                                let zones = JSON.parse(data);
                                let innerHTML = "<select name='zone' id='zone' class='form-control'>";
                                for(let i = 0 ; i < zones.length ; i++){
                                    innerHTML += "<option value='"+zones[i]["id"]+"'>"+zones[i]["libZone"]+"</option>";
                                }
                                innerHTML += "</select>";
                                divZone.innerHTML = innerHTML;
                            },
                            error:function(){
                                console.log("error");
                            }
                        });
                    });
                },
                error:function(){
                    alert("err");
                }
            });
    }
}
$(document).ready(function(){
    let typeEvent = document.getElementById("typeEvent");
    let typeCollecteDiv = document.getElementById("typeCollecteDiv");
    if(typeEvent.value === "1"){
        typeCollecteDiv.innerHTML = typeCollecteSelect();
        $('#typeCollecte_id').ready(function(){
            let typeCollecte = document.getElementById("typeCollecte_id");
            creerCollecteForm(typeCollecte.value);
        });
        $("#typeCollecte_id").on("change", function(){
            let typeCollecte = document.getElementById("typeCollecte_id");
            creerCollecteForm(typeCollecte.value);
        });
    }else{
        console.log("Autre type d'evenement");
    }
    $("#typeEvent").on("change", function(){
        if(typeEvent.value === "1"){
            typeCollecteDiv.innerHTML = typeCollecteSelect();
            $('#typeCollecte_id').ready(function(){
                let typeCollecte = document.getElementById("typeCollecte_id");
                creerCollecteForm(typeCollecte.value);
                $("#typeCollecte_id").on("change", function(){
                    let typeCollecte = document.getElementById("typeCollecte_id");
                    creerCollecteForm(typeCollecte.value);
                });
            });
        }else{
            formCollecte.innerHTML = "";
            formCollecte.className = "";
            typeCollecteDiv.innerHTML = "";
        }
    });
});