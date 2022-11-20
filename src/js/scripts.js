function logoutUser() {
  document.cookie = 'PHPSESSID' + '="";-1; path=/';
  document.cookie = 'login' + '="";-1; path=/';
  window.location.replace('./index.php')
}

// Máscara para CPF, Telefone e RG.
function masksForm() {
  $('#formCPFVolunteer').mask('000.000.000-00', {
    reverse: true
  });
  $('#formRGVolunteer').mask('00.000.000.000-0', {
    reverse: true
  });
  $('#formTelVolunteer').mask('(00) 00000-0000', {
    reverse: false
  });
};

function habilitarCMRV() {
  if ($('#flexRadioDefault1').is(':checked')) {
    $('#campocmrv').hide();
  } else {
    $('#campocmrv').show();
  }
}

function validarFormVoluntario() {
$.validator.addMethod("minAge", function (value, element, min) {
  var today = new Date();
  var birthDate = new Date(value);
  var age = today.getFullYear() - birthDate.getFullYear();

  if (age > min + 1) {
    return true;
  }

  var m = today.getMonth() - birthDate.getMonth();

  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  return age >= min;
}, "Você não tem idade!");
  if ($('#flexRadioDefault1').is(':checked')) {
    idade_minima = 14
  } else {
    idade_minima = 18
  }

  $('#FormVolunteer').removeData('validator')

  if ($('#FormVolunteer').validate({
    focusInvalid: true,
    onfocusout: false,
    invalidHandler: function (form, validator) {
      var errors = validator.numberOfInvalids();
      if (errors) {
        validator.errorList[0].element.focus();
      }
    },
    errorClass: "is-invalid",
    errorElement: 'div',
    rules: {
      formNomeVolunteer: {
        required: true,
        minlength: 5
      },
      formSobrenomeVolunteer: {
        required: true,
        minlength: 5
      },
      formEmailVolunteer: {
        required: true,
        minlength: 10
      },
      formCPFVolunteer: {
        required: true,

        minlength: 11
      },
      formRGVolunteer: {
        required: true,
        minlength: 10
      },
      formTelVolunteer: {
        required: true,
        minlength: 11
      },
      BirthDateVolunteer: {
        required: true,
        minAge: idade_minima
      },
      formEstadoVolunteer: {
        required: true
      },
    },
    messages: {
      formNomeVolunteer: {
        required: "Por favor, insira seu nome!",
        minlength: "Seu nome tem que ser maior!"
      },
      formSobrenomeVolunteer: {
        required: "Por favor, insira seu sobrenome!",
        minlength: "Seu nome tem que ser maior!"
      },
      formPassVolunteer: {
        required: "Por favor, insira uma senha!",
        minlength: "Seu senha tem que ser maior!"
      },
      gender: {
        required: "Por favor, insira um gênero!",
      },
      formEmailVolunteer: {
        required: "Por favor, insira seu email!",
        minlength: "Seu email está incompleto!",
        email: "Este não é um endereço de email válido!"
      },
      formCPFVolunteer: {
        required: "Por favor, insira seu CPF!",
        minlength: "Seu CPF está incompleto!",
        number: "Coloque apenas números!"
      },
      formRGVolunteer: {
        required: "Por favor, insira seu RG!",
        minlength: "Seu RG está incompleto!",
        number: "Coloque apenas números!"
      },
      formTelVolunteer: {
        required: "Por favor, insira seu número de celular!",
        minlength: "Seu celular está incompleto!",
        number: "Coloque apenas números!"
      },
      BirthDateVolunteer: {
        required: "Por favor, insira sua data de nascimento!",
        max: "Por favor, coloque uma data de nascimento menor que a data de hoje!",
        minAge: "Por favor, você tem que ter pelo menos " + idade_minima + " anos"
      },
    },
  })); {
    if ($('#FormVolunteer').valid()) {
      $('#FormVolunteer').submit();
    }
  };
};
