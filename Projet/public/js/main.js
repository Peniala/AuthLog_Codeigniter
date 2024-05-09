const b = document.querySelector("#loginButton");
const popup = document.querySelector("#popup");
const close = document.getElementsByClassName("p-close")[0];
const p_text = document.querySelector('.p-content-text');
b.addEventListener('click', (e) => {
    e.preventDefault();
    login();
});

const login = async() => {
    const prenom = document.querySelector("input[name='prenom']").value;
    const nom = document.querySelector("input[name='nom']").value;
    const password = document.querySelector("input[name='password']").value;
    if(username == '' || password == '') {
        p_text.innerText = 'Veuillez remplir tous les champs!';
        popup.style.display = 'block';
        return ;
    }
    HTTP_STATUS_CODE = 0;
    fetch('/connexion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({nom, prenom, password})
    })
    .then(
      resp => {
        HTTP_STATUS_CODE = resp.status
        return resp.json()
      }
    )
    .then(
        data => {
            if(HTTP_STATUS_CODE == 200) {
          // ito no ovaina rehefa tiana anao redirection makany am page d'accueil
                window.location.href = '/accueil';
            } else {
                p_text.innerText = data.status;
                popup.style.display = 'block';    
            }   

        }
    )
    .catch(err => {
        console.error(err)
    });
}

close.onclick = () => {
    popup.style.display = 'none';
}
window.onclick = e => {
    if (e.target == popup) {
        popup.style.display = 'none';
    }
}
