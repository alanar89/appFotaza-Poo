
//document.getElementById("login").addEventListener("click", validar);
function validar(){
pass=document.getElementById("pass").value;
mail=document.getElementById("mail").value;
p=document.getElementById("passError");
m=document.getElementById("mailError");
var exp=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
if(!exp.test(mail)){
m.classList.add("d-block");
m.classList.remove("d-none");
}else{
    m.classList.add("d-none");
    m.classList.remove("d-block");
}
if(pass.length<4){
    p.classList.add("d-block");
    p.classList.remove("d-none");
}else{
    p.classList.add("d-none");
    p.classList.remove("d-block");
}
if(exp.test(mail)&&pass.length>3){
     document.formLogin.submit();
}
}