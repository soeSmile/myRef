export default ({app}, inject) => {
    /**
     * формирование запроса
     */
    inject('qBuilder', (query, data, reset = {count: 20}) => {
        // если обект дополнить и изменить запрос
        if (data instanceof Object) {
            for (let i in data) {
                query[i] = data[i];
            }
        }

        // сброс запроса
        if (data === 'reset') {
            query = reset;
        }

        return query;
    });

    /**
     * реверс массива для выборки дат
     *
     * @example ['1-2-3','1-2-3'] => ['3-2-1','3-2-1']
     */
    inject('reverseRange', (range) => {
        let array = [];

        for (let i in range) {
            if (range[i]) {
                array.push(range[i].split('-').reverse().join('-'));
            } else {
                return null;
            }
        }

        return array;
    });

    /**
     * сериализация ответов от сервера
     */
    inject('messageToStr', (message = null) => {
        if (typeof message === 'string') return message;

        let data = '<ul>';

        for (let i in message) {

            if (typeof message[i] === 'object') {

                message[i].forEach(function (item, index, array) {
                    data += '<li>' + item + '</li>';
                })
            } else {
                data += '<li>' + message[i] + '</li>';
            }
        }
        data += '</ul>';

        return data;
    });
}
