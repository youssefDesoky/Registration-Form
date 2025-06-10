var translations = {
    "en":{
        "changePhoto": "Change Profile Photo"
    },
    "ar":{
        "changePhoto": "تغيير صورة الملف الشخصي"
    }
};

function getCurrentLocale() {
    if (window.Laravel && window.Laravel.locale) {
        return window.Laravel.locale;
    }
    return document.documentElement.lang || 'en';
}


function __(key) {
    const locale = getCurrentLocale();
    return translations[locale] && translations[locale][key] 
            ? translations[locale][key] 
            : translations['en'][key] || key;
}

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
        event.target.innerText = __("changePhoto");
    });
});