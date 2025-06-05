function createErrorSpan(className, message) {
    let errorSpan = document.createElement("span");
    errorSpan.className = className;
    errorSpan.innerText = message;
    return errorSpan;
}

function CreateMessageBox(className, message) {
    let messageBox = document.createElement("div");
    messageBox.className = className;
    messageBox.innerText = message;
    return messageBox;
}


// Full Name Validation
let fullName = document.getElementById("fname");
fullName.onblur = () => {
    let prev = fullName.previousElementSibling;
    if (!prev || !prev.classList.contains('fname-error')) {
        if (fullName.value.trim() === "") {
            fullName.parentNode.insertBefore(createErrorSpan("fname-error", "Full Name Is Required"), fullName);
        } else {
            if (!/^[a-zA-Z\s]+$/.test(fullName.value)) {
                fullName.parentNode.insertBefore(createErrorSpan("fname-error", "Full Name Must Contain Only Letters"), fullName);
            }

            if (fullName.value.trim().split(" ").length < 2) {
                fullName.parentNode.insertBefore(createErrorSpan("fname-error", "Full Name Must Be At Least First + Last Name"), fullName);
            }
        }
    }
};

fullName.onfocus = () => {
    let prev = fullName.previousElementSibling;
    while (prev && prev.classList.contains('fname-error')) {
        prev.remove();
        prev = fullName.previousElementSibling;
    }
};
// ------------------------------------

// Username Validation
let userName = document.getElementById("uName");
userName.onblur = () => {
    let prev = userName.previousElementSibling;
    if (!prev || !prev.classList.contains('user-name-error')) {
        if (userName.value.trim() === "") {
            userName.parentNode.insertBefore(createErrorSpan("user-name-error", "Username Is Required"), userName);
        } else { 
            if (/\s/.test(userName.value)) {
                userName.parentNode.insertBefore(createErrorSpan("user-name-error", "Username Must Not Contain Spaces"), userName);
            }
            if (!/^[a-zA-Z0-9 _]+$/.test(userName.value)) {
                userName.parentNode.insertBefore(createErrorSpan("user-name-error", "Username Can't Have Special Characters"), userName);
            }
        }
    }
};

userName.oninput = () => {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let prev = userName.previousElementSibling;
            while (prev && prev.classList.contains('user-name-response')) {
                prev.remove();
                prev = userName.previousElementSibling;
            }
            if (this.responseText !== "") {
                userName.parentNode.insertBefore(createErrorSpan("user-name-response", this.responseText), userName);
            }
        }
    };
    xmlhttp.open("POST", "DB_Ops.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("action=check_username&user_name=" + userName.value.trim());
}

userName.onfocus = () => {
    let prev = userName.previousElementSibling;
    while (prev && prev.classList.contains('user-name-error')) {
        prev.remove();
        prev = userName.previousElementSibling;
    }
};
// ------------------------------------

// Phone Number Validation
let phoneNumber = document.getElementById("phone");

phoneNumber.onblur = () => {
    let prev = phoneNumber.previousElementSibling;
    if (!prev || !prev.classList.contains('phone-num-error')) {
        if (phoneNumber.value.trim() === "") {
            phoneNumber.parentNode.insertBefore(createErrorSpan("phone-num-error", "Phone Number Is Required"), phoneNumber);
        } else {
            if (!/^[0-9]+$/.test(phoneNumber.value)){
                phoneNumber.parentNode.insertBefore(createErrorSpan("phone-num-error", "Phone Number Must Contain Only Digits"), phoneNumber);
            }

            if (phoneNumber.value.trim().length < 10) {
                phoneNumber.parentNode.insertBefore(createErrorSpan("phone-num-len-error", "Phone Number Must Be At Least 10 Digits Long"), phoneNumber);
            }
        }
    }
};

phoneNumber.oninput = () => {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let prev = phoneNumber.previousElementSibling;
            while (prev && prev.classList.contains('phone-num-response')) {
                prev.remove();
                prev = phoneNumber.previousElementSibling;
            }
            if (this.responseText !== "") {
                phoneNumber.parentNode.insertBefore(createErrorSpan("phone-num-response", this.responseText), phoneNumber);
            }
        }
    };
    xmlhttp.open("POST", "DB_Ops.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("action=check_phone&phone_number=" + phoneNumber.value.trim());
}

phoneNumber.onfocus = () => {
    let prev = phoneNumber.previousElementSibling;
    while (prev && prev.classList.contains('phone-num-len-error')) {
        prev.remove();
        prev = phoneNumber.previousElementSibling;
    }
};
// ------------------------------------

// Whats App Number Validation
let whatsAppNumber = document.getElementById("whatsAppNumber");
whatsAppNumber.onblur = () => {
    let prev = whatsAppNumber.previousElementSibling;
    if (!prev || !prev.classList.contains('whats-app-num-error')) {
        if (whatsAppNumber.value.trim() === "") {
            whatsAppNumber.parentNode.insertBefore(createErrorSpan("whats-app-num-error", "Whats App Number Is Required"), whatsAppNumber);
        } else {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let prev = whatsAppNumber.previousElementSibling;
                    while (prev && prev.classList.contains('whats-app-num-response')) {
                        prev.remove();
                        prev = whatsAppNumber.previousElementSibling;
                    }
                    console.log(this.responseText);
                    if (this.responseText) {
                        let response = JSON.parse(this.responseText);
                        if (response[0].status === "invalid") {
                            whatsAppNumber.parentNode.insertBefore(createErrorSpan("whats-app-num-response", "This is Not a Valid Whatsapp Number"), whatsAppNumber);
                        }
                    }
                }
            };
            xmlhttp.open("POST", "API_Ops.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("action=check_whatsapp&whatsapp_number=" + whatsAppNumber.value.trim());
        }
    }
};

whatsAppNumber.oninput = () => {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let prev = whatsAppNumber.previousElementSibling;
            while (prev && prev.classList.contains('whats-app-num-response')) {
                prev.remove();
                prev = whatsAppNumber.previousElementSibling;
            }
            if (this.responseText !== "") {
                whatsAppNumber.parentNode.insertBefore(createErrorSpan("whats-app-num-response", this.responseText), whatsAppNumber);
            }
        }
    };
    xmlhttp.open("POST", "DB_Ops.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("action=check_whatsapp&whatsapp_number=" + whatsAppNumber.value.trim());
}

whatsAppNumber.onfocus = () => {
    let prev = whatsAppNumber.previousElementSibling;
    while (prev && prev.classList.contains('whats-app-num-error')) {
        prev.remove();
        prev = whatsAppNumber.previousElementSibling;
    }
};
// ------------------------------------

// Password Validation
let password = document.getElementById("password");
password.onblur = () => {
    let prev = password.previousElementSibling;
    let passValid = true;
    if (!prev || !prev.classList.contains('pass-error')) {
        if (password.value.trim() === "") {
            password.parentNode.insertBefore(createErrorSpan("pass-error", "Password Is Required"), password);
            passValid = false;
        } else {
            if (password.value.trim().length < 8) {
                let passLenErrorSpan = createErrorSpan("pass-error", "Password Must Be At Least 8 Characters Long");
                password.parentNode.insertBefore(passLenErrorSpan, password);
                passValid = false;
            }

            if (!/[!@#$%^&*(),.?\"'`:{}|<>]/.test(password.value) && password.value.trim().length >= 8) {
                let passSpecialCharErrorSpan = createErrorSpan("pass-error", "Password Must Contain a Special Character");
                password.parentNode.insertBefore(passSpecialCharErrorSpan, password);
                passValid = false;
            }

            if (!/\d/.test(password.value) && password.value.trim().length >= 8) {
                let passNumErrorSpan = createErrorSpan("pass-error", "Password Must Contain a Number");
                password.parentNode.insertBefore(passNumErrorSpan, password);
                passValid = false;
            }
        }
    }

    if (passValid) document.getElementById("cPassword").removeAttribute("disabled");
    else document.getElementById("cPassword").setAttribute("disabled", "disabled");
};

password.onfocus = () => {
    let prev = password.previousElementSibling;
    while (prev && prev.classList.contains('pass-error')) {
        prev.remove();
        prev = password.previousElementSibling;
    }
};
// ------------------------------------

// Confirm Password Validation
let confirmPassword = document.getElementById("cPassword");
confirmPassword.onblur = () => {
    let prev = confirmPassword.previousElementSibling;
    if (!prev || !prev.classList.contains('pass-error')) {
        if (confirmPassword.value.trim() === "") {
            confirmPassword.parentNode.insertBefore(createErrorSpan("pass-error", "Confirm Password Is Required"), confirmPassword);
        }
        else {
            if (confirmPassword.value.trim() !== password.value.trim()) {
                let passMatchErrorSpan = createErrorSpan("pass-error", "Password & Confirmation Password Not Match");
                confirmPassword.parentNode.insertBefore(passMatchErrorSpan, confirmPassword);
            }
        }
    }
};

confirmPassword.onfocus = () => {
    let prev = confirmPassword.previousElementSibling;
    while (prev && prev.classList.contains('pass-error')) {
        prev.remove();
        prev = confirmPassword.previousElementSibling;
    }
};
// ------------------------------------

// Address Validation
let address = document.getElementById("address");
address.onblur = () => {
    let prev = address.previousElementSibling;
    if (!prev || !prev.classList.contains('address-error')) {
        if (address.value.trim() === "") {
            address.parentNode.insertBefore(createErrorSpan("address-error", "Address Is Required"), address);
        } else { }
    }
};

address.onfocus = () => {
    let prev = address.previousElementSibling;
    while (prev && prev.classList.contains('address-error')) {
        prev.remove();
        prev = address.previousElementSibling;
    }
};
// ------------------------------------

// Email Validation
let email = document.getElementById("email");
email.onblur = () => {
    let prev = email.previousElementSibling;
    if (!prev || !prev.classList.contains('email-error')) {
        if(email.value.trim() === "") {
            email.parentNode.insertBefore(createErrorSpan("email-error", "E-mail Is Required"), email);
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            email.parentNode.insertBefore(createErrorSpan("email-error", "This is Not an Email"), email);
        }
    }
};

email.oninput = () => {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let prev = email.previousElementSibling;
            while (prev && prev.classList.contains('email-response')) {
                prev.remove();
                prev = email.previousElementSibling;
            }
            if (this.responseText !== "") {
                email.parentNode.insertBefore(createErrorSpan("email-response", this.responseText), email);
            }
        }
    };
    xmlhttp.open("POST", "DB_Ops.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("action=check_email&user_email=" + email.value.trim());
}

email.onfocus = () => {
    let prev = email.previousElementSibling;
    while (prev && prev.classList.contains('email-error')) {
        prev.remove();
        prev = email.previousElementSibling;
    }
};