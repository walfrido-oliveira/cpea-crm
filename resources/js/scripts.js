/* PASSWORD ROLES */
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var special = document.getElementById("special");
var length = document.getElementById("length");
var confirmation = document.getElementById("confirmation");
var password = document.getElementById("password");
var passwordConfirmation = document.getElementById("password_confirmation");

if(password) {
    password.onfocus = function() {
        document.getElementById("password-validation").style.display = "block";
    }
    password.onblur = function() {
        document.getElementById("password-validation").style.display = "none";
    }
    password.onkeyup = function() {
        var lowerCaseLetters = /[a-z]/g;
        if(password.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid-password-role");
            letter.classList.add("valid-password-role");
        } else {
            letter.classList.remove("valid-password-role");
            letter.classList.add("invalid-password-role");
        }

        var upperCaseLetters = /[A-Z]/g;
        if(password.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid-password-role");
            capital.classList.add("valid-password-role");
        } else {
            capital.classList.remove("valid-password-role");
            capital.classList.add("invalid-password-role");
        }

        var numbers = /[0-9]/g;
        if(password.value.match(numbers)) {
            number.classList.remove("invalid-password-role");
            number.classList.add("valid-password-role");
        } else {
            number.classList.remove("valid-password-role");
            number.classList.add("invalid-password-role");
        }

        var specials = /[\W_]/g;
        if(password.value.match(specials)) {
            special.classList.remove("invalid-password-role");
            special.classList.add("valid-password-role");
        } else {
            special.classList.remove("valid-password-role");
            special.classList.add("invalid-password-role");
        }

        if(password.value.length >= 8) {
            length.classList.remove("invalid-password-role");
            length.classList.add("valid-password-role");
        } else {
            length.classList.remove("valid-password-role");
            length.classList.add("invalid-password-role");
        }
    };
    password.addEventListener("blur", function() {
        !validate.password(this.value, this.getAttribute('minlength'), this.getAttribute('maxlength')) ?
        validate.addInvalidClass(this) : validate.addValidClass(this);
    });
}

if(passwordConfirmation) {
    passwordConfirmation.onfocus = function() {
        document.getElementById("password-validation").style.display = "block";
    }

    passwordConfirmation.onblur = function() {
        document.getElementById("password-validation").style.display = "none";
    }
    passwordConfirmation.onkeyup = function() {
        if(password.value === passwordConfirmation.value) {
            confirmation.classList.remove("invalid-password-role");
            confirmation.classList.add("valid-password-role");
        } else {
            confirmation.classList.remove("valid-password-role");
            confirmation.classList.add("invalid-password-role");
        }
    };
    passwordConfirmation.addEventListener("blur", function() {
        validate.isEmpty(this.value) || password.value !== this.value ? validate.addInvalidClass(this) : validate.addValidClass(this);
    });

}

window.customSelectArray = {};
window.addEventListener("load", function() {
    document.querySelectorAll(".custom-select:not(:disabled)").forEach(item => {
        if(!item.classList.contains("no-nice-select")) window.customSelectArray[item.id] = NiceSelect.bind(item, {searchable: true, reverse: item.dataset.reverse ? item.dataset.reverse : false});
    });
    window.SpinLoad = new SpinLoad("spin_load");

    document.querySelectorAll('.filter-field').forEach(item => {
        item.addEventListener("change", function() {
            if(item.value) {
                const getUrl = window.location;
                //const baseUrl = `${getUrl.protocol}//${getUrl.host}/${getUrl.pathname.split('/')[1]}?`;
                const baseUrl = `${window.location.href}${!window.location.href.includes("?") ? '?' : ''}`;

                const nextURL = `${baseUrl}${this.name}=${this.value}&`;
                const nextTitle = '';
                const nextState = { additionalInformation: '' };

                window.history.pushState(nextState, nextTitle, nextURL);

            } else {
                const regex = new RegExp(item.name + "=.*");
                const baseUrl = window.location.href.replace(regex, '');

                const nextURL = `${baseUrl}`;
                const nextTitle = '';
                const nextState = { additionalInformation: '' };

                window.history.pushState(nextState, nextTitle, nextURL);
            }
        });
    });
});

class SpinLoad {
    constructor(id) {
        this.spinLoad = document.getElementById(id);
    }

    toggle() {
        this.spinLoad.classList.toggle("hidden");
    }

    show() {
        this.spinLoad.classList.remove("hidden");
    }

    hidden() {
        this.spinLoad.classList.add("hidden");
    }
}
