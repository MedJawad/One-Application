import React, { useRef, useState, useEffect } from "react";
import { Route, Switch } from "react-router-dom";

import AdminNavbar from "../components/Navbars/AdminNavbar";
import Footer from "../components/Footer/Footer";
import Sidebar from "../components/Sidebar/Sidebar";

import routes from "../routes.js";
import LocationsList from "../views/LocationsList.jsx";
import LocationView from "../views/LocationView.jsx";
import ReviewsList from "../views/ReviewsList.jsx";
import AnswersList from "../views/AnswersList.jsx";
import UserProfile from "../views/UserProfile.jsx";

const Admin = (props) => {
  const mainPanel = useRef();

  //   useEffect(() => {
  //     console.log(props);

  //     if (!mounted.current) {
  //       mounted.current = true;
  //     } else {
  //       // do componentDidUpate logic
  //       //   if (
  //       //     window.innerWidth < 993 &&
  //       //     // e.history.location.pathname !== e.location.pathname &&
  //       //     document.documentElement.className.indexOf("nav-open") !== -1
  //       //   ) {
  //       //     document.documentElement.classList.toggle("nav-open");
  //       //   }
  //       //   if (e.history.action === "PUSH") {
  //       //     document.documentElement.scrollTop = 0;
  //       //     document.scrollingElement.scrollTop = 0;
  //       // mainPanel.current.scrollTop = 0;
  //       //   }
  //     }
  //   });
  const getRoutes = (routes) => {
    return routes.map((prop, key) => {
      if (prop.layout === "/admin") {
        return (
          <Route
            path={prop.layout + prop.path}
            render={(props) => <prop.component {...props} />}
            key={key}
            exact
          />
        );
      } else {
        return null;
      }
    });
  };
  const getBrandText = (path) => {
    for (let i = 0; i < routes.length; i++) {
      if (
        props.location.pathname.indexOf(routes[i].layout + routes[i].path) !==
        -1
      ) {
        return routes[i].name;
      }
    }
    return "Brand";
  };

  return (
    <div className="wrapper">
      <Sidebar {...props} routes={routes} color={"black"} />
      <div id="main-panel" className="main-panel" ref={mainPanel}>
        <AdminNavbar
          {...props}
          brandText={getBrandText(props.location.pathname)}
        />
        <Switch>
          <Route
            path="/admin/locationfiles/:file_id/locations"
            component={LocationsList}
          />
          <Route
            path="/admin/reviewfiles/:file_id/reviews"
            component={ReviewsList}
          />
          <Route
            path="/admin/locations/:location_id"
            component={LocationView}
          />
          <Route
            path="/admin/reviews/:review_id/answers"
            component={AnswersList}
          />
          <Route path="/admin/users/:user_id" component={UserProfile} />
          {getRoutes(routes)}
        </Switch>
        <Footer />
      </div>
    </div>
  );
};

export default Admin;
