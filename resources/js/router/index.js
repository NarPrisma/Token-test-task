
import App from "../pages/App";
import StoreToken from "../components/StoreToken";
import AllTokens from "../components/AllTokens";


export default {
    mode: 'history',

    routes: [
        {
            path: '/',
            component: App
        },
        {
            path: '/create/token',
            name: 'createToken',
            component: StoreToken,
        },        {
            path: '/all-tokens',
            name: 'allTokens',
            component: AllTokens,
        },
    ]
}
