
export function padStart(text, len, s = '0') {
    text += '';
    if (text.length >= len) {
        return text;
    }
    while (text.length < len) {
        text = s + text;
    }
    return text;
}

export function capitalize(text) {
    return text && text[0].toUpperCase() + text.slice(1) || '';
}

