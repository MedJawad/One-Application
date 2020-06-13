import React from "react";
import { NavItem, Nav } from "react-bootstrap";
import { useDispatch } from "react-redux";
import auth from "../../actions/auth";

function AdminNavbarLinks() {
  const dispatch = useDispatch();
  const logout = () => {
    dispatch(auth.logout());
  };
  return (
    <div>
      <Nav>
        <NavItem eventKey={1} href="/dashboard">
          <i className="fa fa-dashboard" />
          <p className="hidden-lg hidden-md">Dashboard</p>
        </NavItem>
      </Nav>
      <Nav pullRight>
        <NavItem eventKey={1} href="#">
          Account
        </NavItem>
        <NavItem eventKey={3} href="#" onClick={logout}>
          Log out
        </NavItem>
      </Nav>
    </div>
  );
}

export default AdminNavbarLinks;
