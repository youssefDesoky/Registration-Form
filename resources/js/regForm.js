let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

var translations = {
    "en": {
        'fullNameRequired': 'Full Name Is Required',
        'fullNameLetters': 'Full Name Must Contain Only Letters',
        'fullNameFormat': 'Full Name Must Be At Least First + Last Name',
        'usernameRequired': 'Username Is Required',
        'usernameNoSpaces': 'Username Must Not Contain Spaces',
        'usernameChars': 'Username Can\'t Have Special Characters',
        'phoneRequired': 'Phone Number Is Required',
        'phoneDigits': 'Phone Number Must Contain Only Digits',
        'phoneLength': 'Phone Number Must Be At Least 10 Digits Long',
        'whatsappRequired': 'WhatsApp Number Is Required',
        'whatsappInvalid': 'This is Not a Valid WhatsApp Number',
        'whatsappFormat': 'Please enter a valid WhatsApp number format',
        'passwordRequired': 'Password Is Required',
        'passwordLength': 'Password Must Be At Least 8 Characters Long',
        'passwordSpecial': 'Password Must Contain a Special Character',
        'passwordNumber': 'Password Must Contain a Number',
        'confirmRequired': 'Confirm Password Is Required',
        'passwordsMatch': 'Password & Confirmation Password Not Match',
        'addressRequired': 'Address Is Required',
        'emailRequired': 'E-mail Is Required',
        'emailInvalid': 'This is Not an Email',
        'Image must be an image file': 'Image must be an image file',
        'Image size must be less than 2MB': 'Image size must be less than 2MB',
        'profile_photoRequired': 'Profile Photo Is Required'
    },
    "ar":{
        'fullNameRequired': 'الاسم الكامل مطلوب',
        'fullNameLetters': 'يجب أن يحتوي الاسم الكامل على أحرف فقط',
        'fullNameFormat': 'يجب أن يكون الاسم الكامل على الأقل الاسم الأول + الاسم الأخير',
        'usernameRequired': 'اسم المستخدم مطلوب',
        'usernameNoSpaces': 'يجب ألا يحتوي اسم المستخدم على مسافات',
        'usernameChars': 'لا يمكن أن يحتوي اسم المستخدم على أحرف خاصة',
        'phoneRequired': 'رقم الهاتف مطلوب',
        'phoneDigits': 'يجب أن يحتوي رقم الهاتف على أرقام فقط',
        'phoneLength': 'يجب أن يكون رقم الهاتف مكونًا من 10 أرقام على الأقل',
        'whatsappRequired': 'رقم الواتساب مطلوب',
        'whatsappInvalid': 'هذا ليس رقم واتساب صالح',
        'whatsappFormat': 'يرجى إدخال تنسيق رقم واتساب صالح',
        'passwordRequired': 'كلمة المرور مطلوبة',
        'passwordLength': 'يجب أن تكون كلمة المرور مكونة من 8 أحرف على الأقل',
        'passwordSpecial': 'يجب أن تحتوي كلمة المرور على حرف خاص',
        'passwordNumber': 'يجب أن تحتوي كلمة المرور على رقم',
        'confirmRequired': 'تأكيد كلمة المرور مطلوب',
        'passwordsMatch': 'كلمة المرور وكلمة المرور المؤكدة غير متطابقتين',
        'addressRequired': 'العنوان مطلوب',
        'emailRequired': 'البريد الإلكتروني مطلوب',
        'emailInvalid': 'هذا ليس بريدًا إلكترونيًا صالحًا',
        'profile_photoRequired': 'صورة الملف الشخصي مطلوبة'
    }
}

// Get current locale from the html lang attribute
function getCurrentLocale() {
     // First try to get from Laravel global object
    if (window.Laravel && window.Laravel.locale) {
        return window.Laravel.locale;
    }
    // Fallback to HTML lang attribute
    return document.documentElement.lang || 'en';
}

// Translation function
function __(key) {
    const locale = getCurrentLocale();
    return translations[locale] && translations[locale][key] 
            ? translations[locale][key] 
            : translations['en'][key] || key;
}

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
            fullName.parentNode.insertBefore(createErrorSpan("fname-error", __('fullNameRequired')), fullName);
        } else {
            if (!/^[a-zA-Z\s]+$/.test(fullName.value)) {
                fullName.parentNode.insertBefore(createErrorSpan("fname-error", __('fullNameLetters')), fullName);
            }

            if (fullName.value.trim().split(" ").length < 2) {
                fullName.parentNode.insertBefore(createErrorSpan("fname-error", __('fullNameFormat')), fullName);
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
            userName.parentNode.insertBefore(createErrorSpan("user-name-error", __('usernameRequired')), userName);
        } else { 
            if (/\s/.test(userName.value)) {
                userName.parentNode.insertBefore(createErrorSpan("user-name-error", __('usernameNoSpaces')), userName);
            }
            if (!/^[a-zA-Z0-9 _]+$/.test(userName.value)) {
                userName.parentNode.insertBefore(createErrorSpan("user-name-error", __('usernameChars')), userName);
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
                userName.parentNode.insertBefore(
                    createErrorSpan("user-name-response", this.responseText),
                    userName
                );
            }
        }
    };
    xmlhttp.open("POST", "validate/username", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send("user_name=" + encodeURIComponent(userName.value.trim()));
};

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
            phoneNumber.parentNode.insertBefore(createErrorSpan("phone-num-error", __('phoneRequired')), phoneNumber);
        } else {
            if (!/^[0-9]+$/.test(phoneNumber.value)){
                phoneNumber.parentNode.insertBefore(createErrorSpan("phone-num-error", __('phoneDigits')), phoneNumber);
            }

            if (phoneNumber.value.trim().length < 10) {
                phoneNumber.parentNode.insertBefore(createErrorSpan("phone-num-len-error", __('phoneLength')), phoneNumber);
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
    xmlhttp.open("POST", "validate/phone", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send("phone_number=" + encodeURIComponent(phoneNumber.value.trim()));
};

phoneNumber.onfocus = () => {
    let prev = phoneNumber.previousElementSibling;
    while (prev && prev.classList.contains('phone-num-len-error')) {
        prev.remove();
        prev = phoneNumber.previousElementSibling;
    }
};
// ------------------------------------

// WhatsApp Number Validation
let whatsAppNumber = document.getElementById("whatsAppNumber");

// On blur - Check with external API if number is valid WhatsApp
whatsAppNumber.onblur = () => {
    let prev = whatsAppNumber.previousElementSibling;
    while (prev && prev.classList.contains('whats-app-num-error')) {
        prev.remove();
        prev = whatsAppNumber.previousElementSibling;
    }

    const value = whatsAppNumber.value.trim();
    if (value === "") {
        whatsAppNumber.parentNode.insertBefore(createErrorSpan("whats-app-num-error", __('whatsappRequired')), whatsAppNumber);
    } else {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                console.log("API Status:", this.status);
                console.log("API Response:", this.responseText);
                
                if (this.status == 200) {
                    if (this.responseText) {
                        try {
                            let response = JSON.parse(this.responseText);
                            
                            // Check if the response is an array (new API format)
                            if (Array.isArray(response) && response.length > 0) {
                                // Get the first result (since we're only checking one number)
                                const numberResult = response[0];
                                
                                // Only show error if status is not "valid"
                                if (numberResult.status !== "valid") {
                                    whatsAppNumber.parentNode.insertBefore(
                                        createErrorSpan("whats-app-num-error", __('whatsappInvalid')),
                                        whatsAppNumber
                                    );
                                }
                            } 
                            // Check for old API format or error response
                            else if (!response.exists || response.error) {
                                whatsAppNumber.parentNode.insertBefore(
                                    createErrorSpan("whats-app-num-error", __('whatsappInvalid')),
                                    whatsAppNumber
                                );
                            }
                        } catch (e) {
                            console.error("Invalid JSON:", this.responseText);
                            // Fallback to basic validation if JSON parsing fails
                            const cleanNumber = value.replace(/[\s\-()]/g, '');
                            const whatsappRegex = /^\+?[0-9]{10,15}$/;
                            
                            if (!whatsappRegex.test(cleanNumber)) {
                                whatsAppNumber.parentNode.insertBefore(
                                    createErrorSpan("whats-app-num-error", __('whatsappFormat')),
                                    whatsAppNumber
                                );
                            }
                        }
                    }
                } else {
                    console.error("API Error:", this.status, this.responseText);
                    // Fallback to basic format validation
                    const cleanNumber = value.replace(/[\s\-()]/g, '');
                    const whatsappRegex = /^\+?[0-9]{10,15}$/;
                    
                    if (!whatsappRegex.test(cleanNumber)) {
                        whatsAppNumber.parentNode.insertBefore(
                            createErrorSpan("whats-app-num-error", __('whatsappFormat')),
                            whatsAppNumber
                        );
                    }
                }
            }
        };

        xmlhttp.open("POST", "check-whatsapp", true);
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);
        xmlhttp.send(JSON.stringify({
            action: "check_whatsapp",
            whatsapp_number: value
        }));
    }
};

// On input - Check if number already exists in database
whatsAppNumber.oninput = () => {
    let prev = whatsAppNumber.previousElementSibling;
    while (prev && prev.classList.contains('whats-app-num-response')) {
        prev.remove();
        prev = whatsAppNumber.previousElementSibling;
    }
    
    const value = whatsAppNumber.value.trim();
    if (value) {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText !== "") {
                    whatsAppNumber.parentNode.insertBefore(
                        createErrorSpan("whats-app-num-response", this.responseText), 
                        whatsAppNumber
                    );
                }
            }
        };
        
        xmlhttp.open("POST", "validate/whatsapp", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);
        xmlhttp.send("whatsapp_number=" + encodeURIComponent(value));
    }
};

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
            password.parentNode.insertBefore(createErrorSpan("pass-error", __('passwordRequired')), password);
            passValid = false;
        } else {
            if (password.value.trim().length < 8) {
                let passLenErrorSpan = createErrorSpan("pass-error", __('passwordLength'));
                password.parentNode.insertBefore(passLenErrorSpan, password);
                passValid = false;
            }

            if (!/[!@#$%^&*(),.?\"'`:{}|<>]/.test(password.value) && password.value.trim().length >= 8) {
                let passSpecialCharErrorSpan = createErrorSpan("pass-error", __('passwordSpecial'));
                password.parentNode.insertBefore(passSpecialCharErrorSpan, password);
                passValid = false;
            }

            if (!/\d/.test(password.value) && password.value.trim().length >= 8) {
                let passNumErrorSpan = createErrorSpan("pass-error", __('passwordNumber'));
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
            confirmPassword.parentNode.insertBefore(createErrorSpan("pass-error", __('confirmRequired')), confirmPassword);
        }
        else {
            if (confirmPassword.value.trim() !== password.value.trim()) {
                let passMatchErrorSpan = createErrorSpan("pass-error", __('passwordsMatch'));
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
            address.parentNode.insertBefore(createErrorSpan("address-error", __('addressRequired')), address);
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
            email.parentNode.insertBefore(createErrorSpan("email-error", __('emailRequired')), email);
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            email.parentNode.insertBefore(createErrorSpan("email-error", __('emailInvalid')), email);
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
    xmlhttp.open("POST", "validate/email", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);
    xmlhttp.send("user_email=" + encodeURIComponent(email.value.trim()));
};

email.onfocus = () => {
    let prev = email.previousElementSibling;
    while (prev && prev.classList.contains('email-error')) {
        prev.remove();
        prev = email.previousElementSibling;
    }
};
// ------------------------------------

// image Validation
let imageInput = document.getElementById("user_image_input");

imageInput.onchange = () => {
    let prev = imageInput.previousElementSibling;
    while (prev && prev.classList.contains('image-error')) {
        prev.remove();
        prev = imageInput.previousElementSibling;
    }

    if (imageInput.files.length > 0) {
        let file = imageInput.files[0];
        if (!file.type.startsWith('image/')) {
            imageInput.parentNode.insertBefore(createErrorSpan("image-error", __('Image must be an image file')), imageInput);
        } else if (file.size > 2 * 1024 * 1024) { // 2MB limit
            imageInput.parentNode.insertBefore(createErrorSpan("image-error", __('Image size must be less than 2MB')), imageInput);
        }
    }
}

// ----------------------------------------------------------------------------------------------------------------------


document.querySelector(".submit-form").addEventListener("click", event => {
    event.preventDefault();
    let formInputs = document.querySelectorAll(".form-input");
    let isValid = true;

    let spansArray = document.querySelectorAll("#registration-form span");

    document.querySelectorAll(".form-input").forEach(input => {
        if (input.value.trim() === "" ) {
            isValid = false;
            input.parentNode.insertBefore(createErrorSpan("input-error", input.placeholder + (getCurrentLocale() === 'en' ? ' Is Required' : ' مطلوب')), input);        }

        input.addEventListener("focus", () => {
            let prev = input.previousElementSibling;
            while (prev && prev.classList.contains('input-error')) {
                prev.remove();
                prev = input.previousElementSibling;
            }
        });
    });

    let imageInput = document.getElementById("user_image_input");
    // Add a check to make sure the element exists
    if (imageInput) {
        if (!imageInput.files || imageInput.files.length === 0) {
            isValid = false;
            // If you want to show an error message:
            let choosePhotoBtn = document.getElementById("choose-photo");
            imageInput.parentNode.insertBefore(createErrorSpan("photo-error", __("profile_photoRequired")), choosePhotoBtn);
        }
    }

    if (spansArray.length === 0 && isValid) {
        document.getElementById("registration-form").submit();
    }
    // else {
    //     let errorMessageBox = CreateMessageBox("error-message", "Please Fill All Required Fields Correctly");
    //     document.getElementById("registration-form").insertBefore(errorMessageBox, document.querySelector(".submit-form"));
    //     setTimeout(() => {
    //         errorMessageBox.remove();
    //     }, 2000);
    // }
});