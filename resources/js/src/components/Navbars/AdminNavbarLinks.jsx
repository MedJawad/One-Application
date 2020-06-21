import React from "react";
import { NavItem, Nav, Button } from "react-bootstrap";
import { useDispatch } from "react-redux";
import auth from "../../actions/auth";

function AdminNavbarLinks() {
  const dispatch = useDispatch();
  const logout = () => {
    dispatch(auth.logout());
  };
  return (
    <Nav className="justify-content-end ml-auto">
      <Button variant="danger" className="ml-auto btn-fill" onClick={logout}>
        Logout
      </Button>
    </Nav>
  );
}

export default AdminNavbarLinks;
