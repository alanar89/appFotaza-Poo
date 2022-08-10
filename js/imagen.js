
//document.getElementById("login").addEventListener("click", validar);
function validar(){
    nombre=document.getElementById("nombre").value;
    apellido=document.getElementById("apellido").value;
    pass=document.getElementById("pass").value;
    mail=document.getElementById("mail").value;
    nom=document.getElementById("nombreError");
    ape=document.getElementById("apellidoError");
    p=document.getElementById("passError");
    m=document.getElementById("mailError");
    var exp=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
    if(nombre.length<2){
        nom.classList.add("d-block");
        nom.classList.remove("d-none");
    }else{
       nom.classList.add("d-none");
       nom.classList.remove("d-block");
    }
    if(apellido.length<2){
        ape.classList.add("d-block");
        ape.classList.remove("d-none");
    }else{
        ape.classList.add("d-none");
        ape.classList.remove("d-block");
    }
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
    if(exp.test(mail)&&pass.length>3&&nombre.length>1&&apellido.length>1){
         document.formRegistro.submit();
    }
    }