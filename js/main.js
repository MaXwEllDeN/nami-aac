/*
    Utilizado em: pages/account_management.php
    * Destaca a linha do personagem clicado, e exibe as opções para editar e deletar o personagem.
*/
function activeCharacter(Element){ 
    var parent = Element.parentNode.childNodes; // Pega o pai do objeto clickado
    
    for(var i = 0; i < parent.length; i++){ // Vasculha o Node, procurando os 
        var now = parent[i];
        if (now.nodeName == "TR" && now.className == "active"){
            now.className = "";
            now.querySelectorAll(".action")[0].style.display = "none";
            break;
        }                        
    }
    
    var clicked = Element.querySelectorAll(".action");    

    clicked[0].style.display = "table";
    clicked[0].parentNode.className = "active";
}


/*
    Utilizado em: pages/account_management.php
    * Valida se o usuário realmente quer deletar o personagem.
*/
function confirmDeleteCharacter(Element){
    // TODO    
}

