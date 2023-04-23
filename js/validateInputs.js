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