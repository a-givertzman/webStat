document.addEventListener('click', clickScanner)


// Метод | Отправляет координаты мыши и время кликов на сервер
//
function clickScanner(event) {
    let pos = getMousePos(event.target, event)
    // let path = getDomPath(event.target)
    let path = getUniqueSelector(event.target)
    console.log(path, pos, Date.now())
    postData(
        "http://localhost/webStat/setclick/",
        { 
            click: {
                domain: window.location.hostname,
                path: path,
                pos: pos,
                timestamp: Date.now(),
            },
        }
    ).then((data) => {
      console.log(data); // JSON data parsed by `response.json()` call
    });
}


// Метод | Возвращает адекватные координаты мыши
//         внутри клиентской области <element>
//
function getMousePos(element, event) {
    let rect = element.getBoundingClientRect();
    return {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top
    }
}


function getUniqueSelector(elSrc) {
    if (!(elSrc instanceof Element)) return;
    var sSel,
        aAttr = ['name', 'value', 'title', 'placeholder', 'data-*'], // Общие атрибуты
        aSel = [],

        // Получаем селектор из элемента
        getSelector = function(el) {

            // 1. проверка на наличие ID
            if (el.id) {
                aSel.unshift('#' + el.id);
                return true;
            }
            aSel.unshift(sSel = el.nodeName.toLowerCase());

            // 2. Пробуем получить элемент по классу classes
            if (el.className) {
                aSel[0] = sSel += '.' + el.className.trim().replace(/ +/g, '.');
                if (uniqueQuery()) return true;
            }

            // 3. Пробуем получить элемент по классу и атрибутам
            for (var i = 0; i < aAttr.length; ++i) {
                if (aAttr[i] === 'data-*') {
                    // Массив дата-атрибутов
                    var aDataAttr = [].filter.call(el.attributes, function(attr) {
                        return attr.name.indexOf('data-') === 0;
                    });
                    for (var j=0; j<aDataAttr.length; ++j) {
                        aSel[0] = sSel += '[' + aDataAttr[j].name + '="' + aDataAttr[j].value + '"]';
                        if (uniqueQuery()) return true;
                    }
                } else if (el[aAttr[i]]) {
                    aSel[0] = sSel += '[' + aAttr[i] + '="' + el[aAttr[i]] + '"]';
                    if (uniqueQuery()) return true;
                }
            }

            // 4. Пробуем получить элемент по nth-of-type()
            var elChild = el,
                sChild,
                n = 1;
            while (elChild = elChild.previousElementSibling) {
                if (elChild.nodeName === el.nodeName) ++n;
            }
            aSel[0] = sSel += ':nth-of-type(' + n + ')';
            if (uniqueQuery()) return true;

            // 5. Try to select by nth-child() as a last resort
            elChild = el;
            n = 1;
            while (elChild = elChild.previousElementSibling) ++n;
            aSel[0] = sSel = sSel.replace(/:nth-of-type\(\d+\)/, n > 1 ? ':nth-child(' + n + ')' : ':first-child');
            if (uniqueQuery()) return true;
            return false;
        },

        // Проверяем путь, он должен вернуть только один элемент
        uniqueQuery = function() {
            return document.querySelectorAll(aSel.join('>') || null).length === 1;
        };

    // Поднимаемся по дереву DOM что бы получить уникальный селектор
    while (elSrc.parentNode) {
        if (getSelector(elSrc)) return aSel.join(' > ');
        elSrc = elSrc.parentNode;
    }
}


// Пример отправки POST запроса:
async function postData(url = '', data = {}) {
    // Default options are marked with *
    console.log(data);
    const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        // cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        // credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        // referrerPolicy: 'no-referrer', // no-referrer, *client
        body: JSON.stringify(data) // body data type must match "Content-Type" header
    });
    console.log(response);
    return await response.json(); // parses JSON response into native JavaScript objects
}