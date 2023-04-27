
export function isCPF(strCPF) {
    strCPF = String(strCPF).replace(/\D/g, "");

    var sum;
    var mod;
    sum = 0;

    if (strCPF.length !== 11 || !Array.from(strCPF).filter(e => e !== strCPF[0]).length) return false;

    for (let i=1; i<=9; i++) sum = sum + parseInt(strCPF.substring(i-1, i)) * (11 - i);
    mod = (sum * 10) % 11;

    if ((mod == 10) || (mod == 11))  mod = 0;
    if (mod != parseInt(strCPF.substring(9, 10)) ) return false;

    sum = 0;
    for (let i = 1; i <= 10; i++) sum = sum + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    mod = (sum * 10) % 11;

    if ((mod == 10) || (mod == 11))  mod = 0;
    if (mod != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}

export function isEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

export function maxLength(max, value) {
    return value.length <= max;
}

export function isEmpty(value) {
    return value == '';
}

export function addInvalidClass(elem) {
    elem.classList.add("is-invalid");
    elem.classList.remove("is-valid");
}

export function addValidClass(elem) {
    elem.classList.add("is-valid");
    elem.classList.remove("is-invalid");
}

export function password(value, min, max) {
    if (!value.match(/[A-Z]/)) { return false; }
    if (!value.match(/[a-z]/)) { return false; }
    if (!value.match(/[0-9]/)) { return false; }
    if (!value.match(/[\W_]/)) { return false; }
    return value.length >= min && value.length <= max;
}

export function dateToDMY(date) {
    let parts = date.split('-');
    let dateResult = new Date(parts[0], parts[1] - 1, parts[2]);
    var d = dateResult.getDate();
    var m = dateResult.getMonth() + 1;
    var y = dateResult.getFullYear();
    return '' + (d <= 9 ? '0' + d : d) + '/' + (m<=9 ? '0' + m : m) + '/' + y;
}

export function sanitizeNumeric(number) {
    return number.replaceAll(" ", "").replaceAll("%", "").replaceAll(".", "").replaceAll(",", ".").replaceAll("R$", "");
}
