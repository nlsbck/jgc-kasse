function validateInputs(...inputs) {
    let isAllValid = true;
    inputs.forEach(input => {
        input.classList.add('is-valid');
        input.classList.remove('is-invalid');
        if (input.value === "") {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            isAllValid =  false;
        }
    })
    return isAllValid;
}

function validateCashAmount(...inputs) {
    let regex = /^[0-9]*(\.[0-9]{1,2})?$/;
    let isAllValid = true;
    inputs.forEach(input => {
        input.classList.add('is-valid');
        input.classList.remove('is-invalid');
        if (input.value === "" || !regex.test(input.value)) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            isAllValid =  false;
        }
    })
    return isAllValid;
}