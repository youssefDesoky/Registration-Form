let chosePhotoBtn = document.getElementById("choose-photo");
chosePhotoBtn.addEventListener("click", event => {
    event.preventDefault();

    let prev = chosePhotoBtn.previousElementSibling;
    while (prev && prev.classList.contains('photo-error')) {
        prev.remove();
        prev = chosePhotoBtn.previousElementSibling;
    }

    let userImageInput = document.getElementById("user_image_input");
    userImageInput.click();
    userImageInput.addEventListener("change", e => {
        document.getElementById("user-image").src = URL.createObjectURL(userImageInput.files[0]);
        event.target.innerText = "Change Profile Photo";
    });
});
// ----------------------------------------------------------------------------------------------------------------------



document.querySelector(".submit-form").addEventListener("click", event => {
    event.preventDefault();
    let formInputs = document.querySelectorAll(".form-input");
    let isValid = true;

    let spansArray = document.querySelectorAll("#registration-form span");

    document.querySelectorAll(".form-input").forEach(input => {
        if (input.value.trim() === "") {
            isValid = false;
            input.parentNode.insertBefore(createErrorSpan("input-error", `${input.placeholder} Is Required`), input);
        }

        input.addEventListener("focus", () => {
            let prev = input.previousElementSibling;
            while (prev && prev.classList.contains('input-error')) {
                prev.remove();
                prev = input.previousElementSibling;
            }
        });
    });

    // Check if the user choose an image
    let choosePhotoBtn = document.getElementById("choose-photo");
    if (choosePhotoBtn.innerText === "Choose Profile Photo") {
        isValid = false;
        choosePhotoBtn.parentNode.insertBefore(createErrorSpan("photo-error", `Profile Photo Is Required`), choosePhotoBtn);
    }

    if (spansArray.length === 0 && isValid) {
        document.getElementById("registration-form").submit();
    }
    else {
        let errorMessageBox = CreateMessageBox("error-message", "Please Fill All Required Fields Correctly");
        document.getElementById("registration-form").insertBefore(errorMessageBox, document.querySelector(".submit-form"));
        setTimeout(() => {
            errorMessageBox.remove();
        }, 2000);
    }
});