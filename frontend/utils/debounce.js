/**
 * debounce
 *
 * @param fn
 * @param ms
 * @return {function(...[*]=)}
 */
export default function debounce(fn, ms) {
    let debounceTimer;

    return function () {

        const context = this;
        const args    = arguments;
        clearTimeout(debounceTimer);

        debounceTimer
            = setTimeout(() => fn.apply(context, args), ms);
    }
}