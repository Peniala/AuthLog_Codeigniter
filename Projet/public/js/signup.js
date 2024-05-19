const s = document.querySelector("#signupButton");
const popup = document.querySelector("#popup");
const close = document.getElementsByClassName("p-close")[0];
const p_text = document.querySelector('.p-content-text');
const current_pass = document.querySelector('input[name="password"]');
const verify_pass = document.querySelector('input[name="passwd"]');
const m = document.querySelector('.match-content');
// handle click on the `connexion` button
s.addEventListener('click' , e => {
    e.preventDefault();
    const formData = new FormData(document.getElementById("signup"));
    if(formData.get('nom') == '' || formData.get('prenom') == '' || formData.get('password') == ''){
        p_text.innerText = "Veuillez remplir tous les champs!";
        popup.style.display = 'block';
        return;
    }
    if(current_pass.value != verify_pass.value) {
        m.style.display = 'block';
        return;
    }
    signup(formData);
});
// keep track of the change in the password entry
current_pass.addEventListener('input', () => {
    if(current_pass.value != verify_pass.value) {
        m.style.display = 'block';
        return;
    } else {
        m.style.display = 'none';
    }
});
verify_pass.addEventListener('input', () => {
    if(current_pass.value != verify_pass.value) {
        m.style.display = 'block';
        return;
    } else {
        m.style.display = 'none';
    }
});

const signup = async(formData) => {
    document.querySelector('.loader-container').style.display = 'block';
    fetch('/inscription', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body : formDataToJson(formData)
    })
    .then(
        resp => resp.json()
    )
    .then(
        data => {
            // console.log(data);
            document.querySelector('.loader-container').style.display = 'none';
            if(data.status_code === 201) {
                p_text.innerText = data.status+' Rember this login: '+data.login;
                popup.style.display = 'block';
            } else {
                p_text.innerHTML = `<strong>${data.status}</strong>`;
                popup.style.display = 'block';
            }
        }
    )
    .catch(err => {
        console.error(err)
    });
}

const formDataToJson = (formData) => {
    const json = {};
    for (const [key, value] of formData.entries()) {
      if (json[key]) {
        const existingValue = json[key];
        if (Array.isArray(existingValue)) {
          existingValue.push(value);
        } else {
          json[key] = [existingValue, value];
        }
      } else {
        json[key] = value;
      }
    }
    return JSON.stringify(json);
};
close.onclick = () => {
    popup.style.display = 'none';
}
window.onclick = e => {
    if (e.target == popup) {
        popup.style.display = 'none';
    }
}
