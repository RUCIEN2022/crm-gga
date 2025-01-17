const fetchPartenaire = async () => {
    const url = "http://localhost:8080/crm-gga/app/codes/api/v1/api_partenaire.php";
    try{
        // Appel API avec la méthode GET
      const response = await fetch(url, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      });

      if (response.ok) {
        // recupere la reponse
        const partenaires = await response.json();
  
        // Affichage des partenaire dans la console ou sur la page
        console.log(partenaires);
  
        // Exemple d'affichage des partenaire dans une table HTML
        const tableBody = document.getElementById("TablePartenaire"); // ID du tableau
        if (tableBody) {
          tableBody.innerHTML = ""; // Nettoyage de la table avant de la remplir
     
          contrats.forEach((partenaire) => {
            var i = 1;
            const row = `
              <tr>
                <td>${i}</td>
                <td>${partenaire.denom_social}</td>
                <td>${partenaire.emailEntre}</td>
                <td>${partenaire.telephone_Entr}</td>
                 <td>${partenaire.nomRespo}</td>
                 <td>
                                    <button class="btn btn-sm btn-success me-2">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary me-2">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>

              </tr>`;
            tableBody.insertAdjacentHTML("beforeend", row);
            i++;
          });
        }
  
       
      }else{

      }

    }catch(error){

    }
    
};