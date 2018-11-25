
$(function){
  $("#form-test").on("submit",function(){
    nome_input = $("input[name='name']");

    if(nome_input.val() == "" || nome_input.val() == null)
    {
      $("#erro_nome").html("O nome eh obrigatorio.")
      return(false);
    }

    password_input = $("input[name='password']");

    if(password_input.val() == "" || password_input.val() == null)
    {
      $("#erro_nome").html("O senha eh obrigatoria.")
      return(false);
    }

});
