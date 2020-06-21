import React, { Component } from "react";
import { NavLink } from "react-router-dom";

import AdminNavbarLinks from "../Navbars/AdminNavbarLinks.jsx";

// import logo from "../../assets/img/reactlogo.png";
import logo from "../../assets/img/Onep.png";
import { Nav, Row, Col } from "react-bootstrap";

class Sidebar extends Component {
    constructor(props) {
        super(props);
        this.state = {
            width: window.innerWidth
        };
    }
    activeRoute(routeName) {
        return this.props.location.pathname.indexOf(routeName) > -1
            ? "active"
            : "";
    }
    updateDimensions() {
        this.setState({ width: window.innerWidth });
    }
    componentDidMount() {
        this.updateDimensions();
        window.addEventListener("resize", this.updateDimensions.bind(this));
    }
    render() {
        const sidebarBackground = {
            backgroundImage: "url(" + this.props.image + ")"
        };
        return (
            <div
                id="sidebar"
                className="sidebar"
                data-color={this.props.color}
                data-image={this.props.image}
            >
                {this.props.hasImage ? (
                    <div
                        className="sidebar-background"
                        style={sidebarBackground}
                    />
                ) : null}
                <div className="logo">
                    <a href="#" className="simple-text logo-mini">
                        <div className="logo-img">
                            <img src={logo} alt="logo_image" />
                        </div>
                    </a>
                    <a href="#" className="simple-text logo-normal">
                        ONEEP
                    </a>
                </div>
                <div className="sidebar-wrapper">
                    <ul className="nav">
                        {this.props.routes.map((prop, key) => {
                            if (!prop.redirect)
                                return (
                                    <li className={"col-md-12"} key={key}>
                                        <NavLink
                                            to={prop.path}
                                            className="nav-link"
                                            activeClassName="active"
                                        >
                                            {/* <i className={prop.icon} /> */}
                                            <Row>
                                                <Col md={2}>{prop.icon}</Col>
                                                <Col>
                                                    <p>{prop.name}</p>
                                                </Col>
                                            </Row>
                                        </NavLink>
                                    </li>
                                );
                            return null;
                        })}
                        {this.state.width <= 991 ? <AdminNavbarLinks /> : null}
                    </ul>
                </div>
            </div>
        );
    }
}

export default Sidebar;
