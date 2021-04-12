/**
 * only auth user
 *
 * @param store
 * @param redirect
 */
export default function ({store, redirect}) {

    if (!store.getters['auth/hasToken']) {

        redirect('/');
    }
}

