var teste= document.getElementById('msgenviada');



function login(){
  document.getElementById('login').innerHTML = "onclick ok";
}

function createAcc(){
  document.getElementById('createAcc').innerHTML = "onclick ok";
}

function createRoom(){
  document.getElementById('createRoom').innerHTML = "onclick ok";
}

function myRoom(){
  document.getElementById('myRoom').innerHTML = "onclick ok";
}

function sendTxt(){

 document.getElementById("sendTxt").innerHTML = "onclick ok"

}

function sendDice(){
  button = document.getElementById("sendDice");
  button.innerHTML = Math.trunc(((Math.random() * 20) + 1));
}
