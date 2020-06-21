import React, { Component } from "react";
import { Navbar, Nav, NavDropdown, Form, Button } from "react-bootstrap";

import AdminNavbarLinks from "./AdminNavbarLinks.jsx";

class Header extends Component {
  constructor(props) {
    super(props);
    this.mobileSidebarToggle = this.mobileSidebarToggle.bind(this);
    this.state = {
      sidebarExists: false,
    };
  }
  mobileSidebarToggle(e) {
    if (this.state.sidebarExists === false) {
      this.setState({
        sidebarExists: true,
      });
    }
    e.preventDefault();
    document.documentElement.classList.toggle("nav-open");
    var node = document.createElement("div");
    node.id = "bodyClick";
    node.onclick = function() {
      this.parentElement.removeChild(this);
      document.documentElement.classList.toggle("nav-open");
    };
    document.body.appendChild(node);
  }
  render() {
    return (
      <Navbar bg="light" expand="lg">
        <Navbar.Brand href="#home">{this.props.brandText}</Navbar.Brand>
        <Navbar.Toggle
          aria-controls="basic-navbar-nav"
          onClick={this.mobileSidebarToggle}
        />
        <Navbar.Collapse id="basic-navbar-nav">
          <AdminNavbarLinks />
        </Navbar.Collapse>
        {/* <Navbar.Collapse id="basic-navbar-nav">
          <AdminNavbarLinks />
        </Navbar.Collapse> */}
      </Navbar>
    );
  }
}

export default Header;
