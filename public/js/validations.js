function isDate(date) {
    let pattern = /([12]\d{3})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])/
    if (pattern.test(date)) {
        return true
    } else {
        return false
    }
}

function isTime(time) {
    let pattern = /([01][0-9]|2[0-3]):[0-5][0-9]/
    if (pattern.test(time)) {
        return true
    } else {
        return false
    }
}

function isPhoneNumber(phone) {
    let regEx = /^(([+][(]?[0-9]{1,3}[)]?)|([(]?[0-9]{4}[)]?))\s*[)]?[-\s\.]?[(]?[0-9]{1,3}[)]?([-\s\.]?[0-9]{3})([-\s\.]?[0-9]{3,4})$/gm
    if (regEx.test(phone)) {
        return true
    } else {
        return false
    }
}

function isEmail(email) {
    // email regex from http://emailregex.com - "Email Address Regular Expression That 99.99% Works."
    let regEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    if (regEx.test(email)) {
        return true
    } else {
        return false
    }
}

function isUrl(url) {
    let regEx = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/gm
    if (regEx.test(url)) {
        return true
    } else {
        return false
    }
}

function isPostcode(postcode) {
    let regEx = /\b((?:(?:gir)|(?:[a-pr-uwyz])(?:(?:[0-9](?:[a-hjkpstuw]|[0-9])?)|(?:[a-hk-y][0-9](?:[0-9]|[abehmnprv-y])?)))) ?([0-9][abd-hjlnp-uw-z]{2})\b/ig
    if (regEx.test(postcode)) {
        return true
    } else {
        return false
    }
}

