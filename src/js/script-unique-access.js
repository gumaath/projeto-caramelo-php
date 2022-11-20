function gerarCodigo(pet) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    var charactersLength = characters.length;
    var dados = [];
    for (var i = 0; i <= 5; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    dados['codigo'] = result;
    dados['pet'] = pet;
    $.post('Uniquecode.php',
        {
            codigo: dados['codigo'],
            pet: dados['pet']
        },
        function (data) {
            $('#codigo-unico-'+pet).hide();
            obj = JSON.parse(data)
            $('#modal-body'+pet).html(obj.html);
            $('#copiar'+pet).removeAttr("disabled");
            $('#copiar'+pet).attr("valor", dados['codigo']);
        }).fail(function () {
            //if posting your form fails
            alert("Posting failed.");
        });
}