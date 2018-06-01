
export function httpPost(url, data) {
    return new Promise(function(resolve, reject) {

        const xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);

        xhr.onload = function() {
            if (this.status == 200) {
                try {
                    const obj = JSON.parse(this.responseText);
                    if (typeof(obj) === 'object') {
                        resolve(obj);
                    } else {
                        reject(this.responseText);
                    }
                } catch (err) {
                    reject(this.responseText);
                }
            } else {
                reject(`${this.status} ${this.statusText}`);
            }
        };

        xhr.onerror = function() {
            reject(new Error("Network Error"));
        };

        const formData = new FormData();
        for (let k in data) {
            if (!data.hasOwnProperty(k)) {
                continue;
            }
            formData.append(k, data[k]);
        }

        xhr.send(formData);
    });
}
