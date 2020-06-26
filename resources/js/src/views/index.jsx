import React, { useRef, useState, useEffect } from "react";
import { Route, Switch, Redirect } from "react-router-dom";
import { BeatLoader } from "react-spinners";
import { useSelector } from "react-redux";
import { Col } from "react-bootstrap";

import img from "../assets/img/poteau.jpeg";
import AdminNavbar from "../components/Navbars/AdminNavbar";
import Footer from "../components/Footer/Footer";
import Sidebar from "../components/Sidebar/Sidebar";
import EditCentrale from "./admin/EditCentrale";
import api from "../API";
import { userRoutes, adminRoutes, pchRoutes } from "../routes.js";
import EditReport from "./user/EditReport";

const AppEntry = props => {
    const mainPanel = useRef();
    const [loaded, setLoaded] = useState(false);
    const [routes, setRoutes] = useState([]);
    const role = useSelector(state => state.auth.role);

    useEffect(() => {
        if (!role) {
            api.get("/details")
                .then(res => {
                    // console.log(res);
                    const role = res.data.role;
                    role.toLowerCase() === "admin" && setRoutes(adminRoutes);
                    role.toLowerCase() === "pch" && setRoutes(pchRoutes);
                    role.toLowerCase() === "user" && setRoutes(userRoutes);
                    return res;
                })
                .catch(err => err)
                .then(() => setLoaded(true));
        } else {
            role.toLowerCase() === "admin" && setRoutes(adminRoutes);
            role.toLowerCase() === "pch" && setRoutes(pchRoutes);
            role.toLowerCase() === "user" && setRoutes(userRoutes);
            setLoaded(true);
        }
    }, []);

    const getRoutes = routes => {
        return routes.map((prop, key) => {
            return (
                <Route
                    path={prop.path}
                    // render={(props) => <prop.component {...props} />}
                    render={prop.render}
                    key={key}
                    exact
                />
            );
        });
    };
    const getBrandText = path => {
        for (let i = 0; i < routes.length; i++) {
            if (props.location.pathname.indexOf(routes[i].path) !== -1) {
                return routes[i].name;
            }
        }
        return "";
    };

    return (
        <div className="wrapper">
            {loaded ? (
                <>
                    <Sidebar
                        {...props}
                        routes={routes}
                        color={"black"}
                        image={img}
                        hasImage={true}
                    />
                    <div id="main-panel" className="main-panel" ref={mainPanel}>
                        <AdminNavbar
                            {...props}
                            brandText={getBrandText(props.location.pathname)}
                        />
                        <Switch>
                            <Route
                                exact
                                path={"/admin/centrales/:centrale_id"}
                                component={EditCentrale}
                            />
                            <Route
                                //exact
                                path={"/admin/reports/:report_id"}
                                render={props => <EditReport {...props} />}
                            />
                            {getRoutes(routes)}
                            <Redirect from="/admin/" to={`${routes[0].path}`} />
                        </Switch>
                        <Footer />
                    </div>
                </>
            ) : (
                <Col md={{ span: 4, offset: 4 }}>
                    {/* <BeatLoader size={30} /> */}
                </Col>
            )}
        </div>
    );
};

export default AppEntry;
