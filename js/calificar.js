var cont;
function calificar(item){
   cont=item.id[0];
   let nombre=item.id.substring(1);
   document.getElementById("btn"+nombre).classList.remove("d-none");
   for (let i = 1; i <=5; i++) {
      if(i<=cont){
         document.getElementById(i+nombre).style.color="#1630d9"; 
      }
      else{
         document.getElementById(i+nombre).style.color="#cbd1ce";  
      } 
   } 
}



