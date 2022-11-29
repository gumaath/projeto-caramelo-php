function logoutUser() {
  document.cookie = 'PHPSESSID' + '="";-1; path=/';
  document.cookie = 'login' + '="";-1; path=/';
  window.location.replace('./index.php')
}

// Máscara para CPF, Telefone e RG.
function masksForm() {
  $('#formCPF').mask('000.000.000-00', {
    reverse: true
  });
  $('#formRG').mask('00.000.000.000-0', {
    reverse: true
  });
  $('#formTel').mask('(00) 00000-0000', {
    reverse: false
  });
};

function habilitarCMRV() {
  if ($('#tipoUsuario1').is(':checked')) {
    $('#campocmrv').hide();
  } else {
    $('#campocmrv').show();
  }
}

function validarForm() {
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
  if ($('#tipoUsuario1').is(':checked')) {
    idade_minima = 14
  } else {
    idade_minima = 18
  }

  $('#FormRegister').removeData('validator')

  if ($('#FormRegister').validate({
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
      formNome: {
        required: true,
        minlength: 5
      },
      formEmail: {
        required: true,
        minlength: 10
      },
      formCPF: {
        required: true,

        minlength: 11
      },
      formRG: {
        required: true,
        minlength: 10
      },
      formCMRV: {
        required: true,
        minlength: 4
      },
      formTel: {
        required: true,
        minlength: 11
      },
      BirthDate: {
        required: true,
        minAge: idade_minima
      },
    },
    messages: {
      formNome: {
        required: "Por favor, insira seu nome!",
        minlength: "Seu nome tem que ser maior!"
      },
      formPass: {
        required: "Por favor, insira uma senha!",
        minlength: "Seu senha tem que ser maior!"
      },
      gender: {
        required: "Por favor, insira um gênero!",
      },
      formCMRV: {
        required: "Por favor, insira seu CRMV!",
        minlength: "Seu CRMV está incompleto!",
      },
      formEmail: {
        required: "Por favor, insira seu email!",
        minlength: "Seu email está incompleto!",
        email: "Este não é um endereço de email válido!"
      },
      formCPF: {
        required: "Por favor, insira seu CPF!",
        minlength: "Seu CPF está incompleto!",
        number: "Coloque apenas números!"
      },
      formRG: {
        required: "Por favor, insira seu RG!",
        minlength: "Seu RG está incompleto!",
        number: "Coloque apenas números!"
      },
      formTel: {
        required: "Por favor, insira seu número de celular!",
        minlength: "Seu celular está incompleto!",
        number: "Coloque apenas números!"
      },
      BirthDate: {
        required: "Por favor, insira sua data de nascimento!",
        max: "Por favor, coloque uma data de nascimento menor que a data de hoje!",
        minAge: "Por favor, você tem que ter pelo menos " + idade_minima + " anos"
      },
    },
  })); {
    if ($('#FormRegister').valid()) {
      $('#FormRegister').submit();
    }
  };
};
