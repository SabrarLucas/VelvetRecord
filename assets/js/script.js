var valid = document.getElementById("supp");

valid.addEventListener("click",validation);


function validation(e){
    function supprimer(){
        if(confirm("Êtes vous sur de vouloir supprimer ?") == true){
            console.log("Supprimer");
        }
        else{
            console.log("Pas supprimer");
            e.preventDefault();
        }
    }
    supprimer();
}