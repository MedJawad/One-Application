import "bootstrap/dist/css/bootstrap.min.css";
import "./assets/css/animate.min.css";
import "./assets/sass/light-bootstrap-dashboard-react.scss?v=1.3.0";
import "./assets/css/demo.css";
import "./assets/css/pe-icon-7-stroke.css";

import React, { useEffect } from "react";
import ReactDOM from "react-dom";

import { BrowserRouter, Route, Switch, Redirect } from "react-router-dom";

import { useDispatch, useSelector } from "react-redux";
import { Provider } from "react-redux";

import AdminLayout from "./layouts/Admin.jsx";
import Auth from "./Auth/Auth";
import authActions from "./actions/auth";

import store from "./store/index";

const App = (props) => {
    const isAuthenticated = useSelector((state) => state.auth.token != null);
    const dispatch = useDispatch();
    useEffect(() => {
        dispatch(authActions.loginWithCookie());
    }, [dispatch]);
    console.log(isAuthenticated);

    let authRedirect = null;
    if (!isAuthenticated) {
        authRedirect = <Redirect to="/login" />;
    }

    return (
        <BrowserRouter>
            <Switch>
                <Route path="/login" render={(props) => <Auth {...props} />} />
                {authRedirect}
                {isAuthenticated && (
                    <Route path="/admin" render={(props) => <AdminLayout {...props} />} />
                )}
                {isAuthenticated && <Redirect from="/" to="/admin/dashboard" />}
            </Switch>
        </BrowserRouter>
    );
};

export default App;

ReactDOM.render(
    <Provider store={store}>
        <App />
    </Provider>,
    document.getElementById("app")
);
