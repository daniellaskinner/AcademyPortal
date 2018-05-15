
function isValidEmail(elementID) {
    let inputVal = document.getElementById(elementID);
    let email = inputVal.value.trim();
    let re = new RegExp("^\\w+([\\.-]?\\w+)*@\\w+([\\.-]?\\w+)*(\\.\\w{2,3})+$");

    if (re.test(email)) {
        inputVal.style.backgroundColor = "";
        return true
    } else {
        inputVal.style.backgroundColor = "pink";
        return false
    }
}

function validateToPostInputs() {
    let cleanedEmailInput = encodeURI(document.getElementById('userEmail').value);
    let cleanedPasswordInput = encodeURI(document.getElementById('password').value);

    if (isValidEmail('userEmail')) {
        document.getElementById('submitWarning').textContent = 'Form is Goooood!'

        fetch("/api/login",
            {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                method: "POST",
                body: JSON.stringify({
                    "userEmail": cleanedEmailInput,
                    "password": cleanedPasswordInput
                })
            })
            .then(function(data){ return data.json() })
            .then(function (value) { console.log(value) })

    } else {
        document.getElementById('submitWarning').textContent = 'Field input error'
    }
}

document.getElementById('formID').addEventListener('submit', function(e){
    e.preventDefault();
    validateToPostInputs();
});

