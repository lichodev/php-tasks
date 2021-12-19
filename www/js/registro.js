async function checkUsername(input) {
  const username = input.value;
  const userDiv = document.createElement('div');

  const result = await fetch(`/api/userExist?username=${username}`);
  const { exist } = await result.json();

  input.className = exist ? 'invalido' : 'valido';

  userDiv.classList.add('message', exist ? 'invalido-div' : 'valido-div');
  userDiv.id = 'user-div';
  userDiv.innerHTML = `<p>${exist ? 'Nombre de usuario en uso. Elige otro.' : 'El nombre de usuario está disponible.'}</p>`
  input.parentElement.appendChild(userDiv);

  isValidForm();
}

function clearUsername() {
  const input = document.querySelector('#username');
  const userDiv = document.querySelector('#user-div');

  input.classList.remove("valido", "invalido");
  userDiv != null && userDiv.remove();
}

function clearPassword() {
  const input = document.querySelector('#password');
  const passwordDiv = document.querySelector('#password-div');

  input.classList.remove("valido", "invalido");
  passwordDiv != null && passwordDiv.remove();
}

function checkPassword(input) {
  /** @type string */
  const password = input.value;
  let rules = [];

  rules.push({
    id: 'caracteres',
    class: password.length >= 8 ? 'valido' : ''
  })

  rules.push({
    id: 'mayuscula',
    class: hasCapital(password) ? 'valido' : ''
  })

  rules.push({
    id: 'numero',
    class: hasNumber(password) ? 'valido' : ''
  })

  for (let li of rules) {
    document.getElementById(li.id).className = li.class;
  }

  isValidForm();
}

function isValidForm() {
  /** @type HTMLButtonElement */
  const btnSubmit = document.querySelector('button[type="submit"]');
  const validos = document.querySelectorAll('.valido');
  if (validos.length === 4) btnSubmit.disabled = false;
  else btnSubmit.disabled = true;
}

function hasCapital(str) {
  const filtered = str.split('')
    .map(letter => Number(/[A-Z]/.test(letter)))
    .reduce((a, b) => a + b, 0);

  return !!filtered;
}

function hasNumber(str) {
  const filtered = str.split('')
    .map(letter => Number(/[0-9]/.test(letter)))
    .reduce((a, b) => a + b, 0);

  return !!filtered;
}

