import React, { Component } from "react";
import { Grid } from "react-bootstrap";

class Footer extends Component {
  render() {
    return (
      <footer
        className="footer"
        style={{ position: "fixed", bottom: "0", width: "100%" }}
      >
        <Grid fluid>
          <p className="copyright pull-left">
            &copy; {new Date().getFullYear()} Synergie Media
          </p>
        </Grid>
      </footer>
    );
  }
}

export default Footer;
