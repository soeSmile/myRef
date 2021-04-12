/**
 * only client user
 *
 * @param store
 * @param redirect
 */
export default function ({store, redirect}) {

    if (!store.getters['auth/user'].isClient) {

        redirect('/');
    }
}

