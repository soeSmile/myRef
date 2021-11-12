export default ({app, req}) => {
    const {router} = app;

    router.afterEach((to, from) => {
        let headers = {};

        headers.to = to.fullPath;
        headers.from = from.fullPath;

        if (req) {
            headers.ip = req.headers['x-forwarded-for'];
            headers.agent = req.headers['user-agent'];
            headers.lang = req.headers['accept-language'];
        }
    })
}